<?php

namespace Azuriom\Plugin\Support\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Support\Models\Ticket;

class TicketPolicy
{
    /**
     * Determine whether the user can view the DocDummyModel.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->author_id;
    }

    /**
     * Determine whether the user can update the DocDummyModel.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->author_id;
    }
}
