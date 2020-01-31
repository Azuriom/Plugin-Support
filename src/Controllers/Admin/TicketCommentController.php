<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\CommentRequest;
use Illuminate\Http\Request;

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
        $ticket->comments()->create($request->validated());

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.comments.status.created'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Support\Requests\CommentRequest  $request
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Ticket $ticket, Comment $comment)
    {
        $comment->update($request->validated());

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.comments.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Ticket $ticket, Comment $comment)
    {
        $comment->delete();

        return redirect()->route('support.admin.tickets.show', $ticket)
            ->with('success', trans('support::admin.comments.status.deleted'));
    }
}
