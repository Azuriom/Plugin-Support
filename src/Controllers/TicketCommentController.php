<?php

namespace Azuriom\Plugin\Support\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\CommentRequest;

class TicketCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Ticket $ticket)
    {
        abort_if(! $request->user()->is($ticket->author), 403);

        $comment = $ticket->comments()->create($request->validated());

        $comment->persistPendingAttachments($request->input('pending_id'));

        $comment->sendDiscordWebhook();

        return to_route('support.tickets.show', $ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CommentRequest $request, Ticket $ticket, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return to_route('support.tickets.show', $ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Ticket $ticket, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return to_route('support.admin.tickets.show', $ticket);
    }
}
