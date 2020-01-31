<?php

namespace Azuriom\Plugin\Support\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Support\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the DocDummyModel.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id || $user->id === $comment->ticket->author_id;
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO
    }

    /**
     * Determine whether the user can update the DocDummyModel.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id;
    }

    /**
     * Determine if the given comment can be deleted by the user.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id;
    }
}
