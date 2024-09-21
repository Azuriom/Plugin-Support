<?php

namespace Azuriom\Plugin\Support\View\Composers;

use Azuriom\Extensions\Plugin\AdminUserEditComposer;
use Azuriom\Models\User;
use Azuriom\Plugin\Support\Models\Ticket;
use Illuminate\View\View;

class SupportAdminUserComposer extends AdminUserEditComposer
{
    public function getCards(User $user, View $view): array
    {
        $tickets = Ticket::whereBelongsTo($user, 'author')
            ->with(['author', 'category'])
            ->latest()
            ->get();

        if ($tickets->isEmpty()) {
            return [];
        }

        $view->with('tickets', $tickets);

        return [
            'support' => [
                'name' => trans('support::admin.tickets.title'),
                'view' => 'support::admin.users.tickets',
            ],
        ];
    }
}
