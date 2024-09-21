<?php

namespace Azuriom\Plugin\Support\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\TicketRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryTicketController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        return view('support::tickets.create', [
            'category' => $category,
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request, Category $category)
    {
        if ($delay = Ticket::newTicketDelay($request->user())) {
            return redirect()->back()->withInput()
                ->with('error', trans('support::messages.tickets.delay', [
                    'time' => $delay,
                ]));
        }

        $ticket = $category->tickets()->create(Arr::only($request->validated(), 'subject'));

        $comment = $ticket->comments()->create(Arr::only($request->validated(), 'content'));

        $comment->persistPendingAttachments($request->input('pending_id'));

        if (($webhookUrl = setting('support.webhook')) !== null) {
            rescue(fn () => $ticket->createCreatedDiscordWebhook()->send($webhookUrl));
        }

        return to_route('support.tickets.show', $ticket);
    }
}
