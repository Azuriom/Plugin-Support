<?php

namespace Azuriom\Plugin\Support\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
use Azuriom\Plugin\Support\Models\Ticket;

class SupportAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards(): array
    {
        return [
            'vote_sites' => [
                'color' => 'warning',
                'name' => trans('support::admin.tickets.open'),
                'value' => Ticket::open()->count(),
                'icon' => 'bi bi-ticket',
            ],
        ];
    }
}
