<?php

namespace Azuriom\Plugin\Support\Notifications;

use Azuriom\Plugin\Support\Models\Comment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCommented extends Notification
{
    /**
     * @var \Azuriom\Plugin\Support\Models\Comment
     */
    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
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
}
