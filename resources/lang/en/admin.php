<?php

return [
    'title' => 'Support',

    'categories' => [
        'title' => 'Categories',
        'edit' => 'Edit category #:category',
        'create' => 'Create category',

        'delete_empty' => 'The category contains tickets and can\'t be deleted.',
    ],

    'tickets' => [
        'title' => 'Tickets',
        'show' => 'Ticket #:ticket - :name',
        'create' => 'Create ticket',

        'open' => 'Open tickets',
    ],

    'permissions' => [
        'tickets' => 'View and manage support tickets',
        'categories' => 'View and manage support categories',
    ],

    'settings' => [
        'title' => 'Support settings',
        'webhook' => 'Discord Webhook URL',
        'webhook_info' => 'When an user create a ticket or add a comment it will create a notification on this webhook. Leave empty to disable',
    ],

    'logs' => [
        'tickets' => [
            'closed' => 'Closed ticket #:id',
        ],
    ],
];
