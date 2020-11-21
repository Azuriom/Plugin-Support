<?php

namespace Azuriom\Plugin\Support\Controllers;

use Azuriom\Azuriom;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Requests\CommentRequest;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;
use Illuminate\Support\Str;

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
        abort_if(! $request->user()->is($ticket->author), 403);

        $comment = $ticket->comments()->create($request->validated());

        if (($webhookUrl = setting('support.webhook')) !== null) {
            $user = $request->user();

            $embed = Embed::create()
                ->title(trans('support::messages.webhook.comment'))
                ->author($user->name, null, $user->getAvatar())
                ->addField(trans('support::messages.fields.ticket'), $ticket->subject)
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
