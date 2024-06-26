<?php

namespace Azuriom\Plugin\Support\Models;

use Azuriom\Azuriom;
use Azuriom\Models\Traits\Attachable;
use Azuriom\Models\Traits\HasMarkdown;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $content
 * @property int $author_id
 * @property int $ticket_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Support\Models\Ticket $ticket
 */
class Comment extends Model
{
    use Attachable;
    use HasMarkdown;
    use HasTablePrefix;
    use HasUser;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'support_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
    ];

    /**
     * The user key associated with this model.
     */
    protected string $userKey = 'author_id';

    /**
     * Get the ticket of this comment.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user who created this comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parseContent(): HtmlString
    {
        return $this->parseMarkdown('content');
    }

    public function sendDiscordWebhook(): void
    {
        if (($webhookUrl = setting('support.webhook')) === null) {
            return;
        }

        $embed = Embed::create()
            ->title(trans('support::messages.webhook.comment'))
            ->author($this->author->name, null, $this->author->getAvatar())
            ->addField(trans('support::messages.fields.ticket'), $this->ticket->subject)
            ->addField(trans('messages.fields.category'), $this->ticket->category->name)
            ->addField(trans('messages.fields.content'), Str::limit($this->content, 1995))
            ->url(route('support.admin.tickets.show', $this->ticket))
            ->color('#004de6')
            ->footer('Azuriom v'.Azuriom::version())
            ->timestamp(now());

        $webhook = DiscordWebhook::create()->addEmbed($embed);

        rescue(fn () => $webhook->send($webhookUrl));
    }
}
