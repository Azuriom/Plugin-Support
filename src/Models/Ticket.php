<?php

namespace Azuriom\Plugin\Support\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $subject
 * @property int $author_id
 * @property int $category_id
 * @property \Carbon\Carbon|null $closed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Support\Models\Category $category
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
     * Get the comments of this ticket.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function statusMessage()
    {
        return trans('support::messages.state.'.($this->isClosed() ? 'closed' : 'open'));
    }

    public function isClosed()
    {
        return $this->closed_at !== null;
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
