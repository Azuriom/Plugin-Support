<?php

namespace Azuriom\Plugin\Support\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
use Azuriom\Plugin\Support\Models\Ticket;

class SupportAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards()
    {
        return [
            'vote_sites' => [
                'color' => 'warning',
                'name' => trans('support::admin.tickets.open-tickets'),
                'value' => Ticket::open()->count(),
                'icon' => 'fas fa-ticket-alt',
            ],
        ];
    }
}
