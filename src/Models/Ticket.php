<?php

namespace Azuriom\Plugin\Support\Models;

use Azuriom\Azuriom;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $subject
 * @property int $author_id
 * @property int $category_id
 * @property \Carbon\Carbon|null $closed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Support\Models\Category $category
 * @property \Azuriom\Plugin\Support\Models\Comment $comment
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Support\Models\Comment[] $comments
 *
 * @method static \Illuminate\Database\Eloquent\Builder open()
 */
class Ticket extends Model
{
    use HasTablePrefix;
    use HasUser;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'support_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'category_id',
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'author_id';

    /**
     * Get the user who created this ticket.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category of this ticket.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the latest comment of this ticket.
     */
    public function comment()
    {
        return $this->hasOne(Comment::class)->latest();
    }

    /**
     * Get the comments of this ticket.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function userReplied()
    {
        return $this->comment->author->is($this->author);
    }

    public function statusMessage()
    {
        return trans('support::messages.state.'.($this->isClosed() ? 'closed' : 'open'));
    }

    public function isClosed()
    {
        return $this->closed_at !== null;
    }

    public function createCreatedDiscordWebhook()
    {
        $comment = $this->comments()->first();

        $embed = Embed::create()
            ->title(trans('support::messages.webhook.ticket'))
            ->author($this->author->name, null, $this->author->getAvatar())
            ->addField(trans('messages.fields.title'), $this->subject)
            ->addField(trans('support::messages.fields.category'), $this->category->name)
            ->addField(trans('messages.fields.content'), Str::limit($comment->content, 1995))
            ->url(route('support.admin.tickets.show', $this))
            ->color('#004de6')
            ->footer('Azuriom v'.Azuriom::version())
            ->timestamp(now());

        return DiscordWebhook::create()->addEmbed($embed);
    }

    public function createClosedDiscordWebhook(User $user)
    {
        $embed = Embed::create()
            ->title(trans('support::messages.webhook.closed'))
            ->author($user->name, null, $user->getAvatar())
            ->addField(trans('messages.fields.title'), $this->subject)
            ->addField(trans('support::messages.fields.category'), $this->category->name)
            ->url(route('support.admin.tickets.show', $this))
            ->color('#004de6')
            ->footer('Azuriom v'.Azuriom::version())
            ->timestamp(now());

        return DiscordWebhook::create()->addEmbed($embed);
    }

    /**
     * Scope a query to only include open tickets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen(Builder $query)
    {
        return $query->whereNull('closed_at');
    }
}
