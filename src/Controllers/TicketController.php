<?php

namespace Azuriom\Plugin\Support\Controllers;

use Azuriom\Azuriom;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\TicketRequest;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

        return view('support::tickets.index', ['tickets' => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('support::tickets.create', ['categories' => Category::all()]);
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

        if (($webhookUrl = setting('support.webhook')) !== null) {
            $user = $request->user();

            $embed = Embed::create()
                ->title(trans('support::messages.webhook.ticket'))
                ->author($user->name, null, $user->getAvatar())
                ->addField(trans('messages.fields.title'), $ticket->subject)
                ->addField(trans('support::messages.fields.category'), $ticket->category->name)
                ->addField(trans('messages.fields.content'), Str::limit($comment->content, 1995))
                ->url(route('support.admin.tickets.show', $ticket))
                ->color('#004de6')
                ->footer('Azuriom v'.Azuriom::version())
                ->timestamp(now());

            rescue(function () use ($embed, $webhookUrl) {
                DiscordWebhook::create()->addEmbed($embed)->send($webhookUrl);
            });
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

        return view('support::tickets.show', ['ticket' => $ticket]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Http\Client\HttpClientException
     */
    public function close(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->closed_at = now();
        $ticket->save();

        if (($webhookUrl = setting('support.webhook')) !== null) {
            $user = $request->user();

            $embed = Embed::create()
                ->title(trans('support::messages.webhook.closed'))
                ->author($user->name, null, $user->getAvatar())
                ->addField(trans('messages.fields.title'), $ticket->subject)
                ->addField(trans('support::messages.fields.category'), $ticket->category->name)
                ->url(route('support.admin.tickets.show', $ticket))
                ->color('#004de6')
                ->footer('Azuriom v'.Azuriom::version())
                ->timestamp(now());

            rescue(function () use ($embed, $webhookUrl) {
                DiscordWebhook::create()->addEmbed($embed)->send($webhookUrl);
            });
        }

        return redirect()->route('support.tickets.show', $ticket)
            ->with('success', trans('support::admin.tickets.status.closed'));
    }
}
