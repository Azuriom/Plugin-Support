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
     *
     * @param  \Azuriom\Plugin\Support\Requests\CommentRequest  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Ticket $ticket)
    {
        abort_if($request->user()->id !== $ticket->author_id, 403);

        $ticket->comments()->create($request->validated());

        return redirect()->route('support.tickets.show', $ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\CommentRequest  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CommentRequest $request, Ticket $ticket, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return redirect()->route('support.tickets.show', $ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Ticket $ticket, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('support.admin.tickets.show', $ticket);
    }
}
