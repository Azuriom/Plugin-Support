<?php

namespace Azuriom\Plugin\Support\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Support\Models\Ticket;

class TicketPolicy
{
    /**
     * Determine whether the user can view the ticket.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->is($ticket->author);
    }

    /**
     * Determine whether the user can update the ticket.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Support\Models\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->is($ticket->author);
    }
}
