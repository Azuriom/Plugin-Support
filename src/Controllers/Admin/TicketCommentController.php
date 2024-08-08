<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Notifications\AlertNotification;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Notifications\TicketCommented;
use Azuriom\Plugin\Support\Requests\CommentRequest;

class TicketCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Ticket $ticket)
    {
        /** @var \Azuriom\Plugin\Support\Models\Comment $comment */
        $comment = $ticket->comments()->create($request->validated());

        $comment->persistPendingAttachments($request->input('pending_id'));

        (new AlertNotification(trans('support::messages.tickets.notification')))
            ->from($comment->author)
            ->link(route('support.tickets.show', $ticket))
            ->send($ticket->author);

        $comment->sendDiscordWebhook();

        $ticket->author->notify(new TicketCommented($comment));

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Ticket $ticket, Comment $comment)
    {
        $comment->update($request->validated());

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Ticket $ticket, Comment $comment)
    {
        $comment->delete();

        return to_route('support.admin.tickets.show', $ticket)
            ->with('success', trans('messages.status.success'));
    }
}
