<?php

namespace Azuriom\Plugin\Support\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Support\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        return $user->is($comment->author) || $user->is($comment->ticket->author);
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->is($comment->author);
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->is($comment->author);
    }
}
