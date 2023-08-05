<?php

namespace Azuriom\Plugin\Support\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Support\Models\Ticket;

class TicketPolicy
{
    /**
     * Determine whether the user can view the ticket.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->is($ticket->author);
    }

    /**
     * Determine whether the user can update the ticket.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->is($ticket->author);
    }
}
