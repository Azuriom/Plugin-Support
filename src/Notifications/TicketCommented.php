<?php

namespace Azuriom\Plugin\Support\Notifications;

use Azuriom\Plugin\Support\Models\Comment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCommented extends Notification
{
    protected Comment $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('support.tickets.show', $this->comment->ticket);

        return (new MailMessage())
            ->subject(trans('support::messages.mails.comment.subject'))
            ->line(trans('support::messages.mails.comment.message', [
                'user' => $this->comment->ticket->author->name,
                'author' => $this->comment->author->name,
                'id' => $this->comment->ticket->id,
            ]))
            ->action(trans('support::messages.mails.comment.view'), $url);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
}
