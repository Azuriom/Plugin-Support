<?php

namespace Azuriom\Plugin\Support\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\TicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::with('category')->where('author_id', Auth::id())->get();
        $infoText = setting('support.home');

        return view('support::tickets.index', [
            'infoText' => $infoText !== null ? new HtmlString($infoText) : null,
            'tickets' => $tickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('support::tickets.create', [
            'categories' => Category::all(),
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\TicketRequest  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function store(TicketRequest $request)
    {
        $ticket = Ticket::create(Arr::except($request->validated(), 'content'));

        $comment = $ticket->comments()->create(Arr::only($request->validated(), 'content'));

        $comment->persistPendingAttachments($request->input('pending_id'));

        if (($webhookUrl = setting('support.webhook')) !== null) {
            $webhook = $ticket->createCreatedDiscordWebhook();

            rescue(fn () => $webhook->send($webhookUrl));
        }

        return redirect()->route('support.tickets.show', $ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['category', 'author', 'comments.author']);

        return view('support::tickets.show', [
            'ticket' => $ticket,
            'pendingId' => old('pending_id', Str::uuid()),
            'canReopen' => setting('support.reopen', false),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\TicketRequest  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->validated());

        return redirect()->route('support.tickets.show', $ticket)
            ->with('success', trans('support::admin.tickets.status.updated'));
    }

    public function close(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->closed_at = now();
        $ticket->save();

        ActionLog::log('support-tickets.closed', $ticket);

        if (($webhookUrl = setting('support.webhook')) !== null) {
            $webhook = $ticket->createClosedDiscordWebhook($request->user());

            rescue(fn () => $webhook->send($webhookUrl));
        }

        return redirect()->route('support.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    public function open(Request $request, Ticket $ticket)
    {
        abort_if(! setting('support.reopen', false), 404);

        $this->authorize('update', $ticket);

        $ticket->closed_at = null;
        $ticket->save();

        ActionLog::log('support-tickets.reopened', $ticket);

        return redirect()->route('support.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }
}
