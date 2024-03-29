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
        'home_message' => 'Home message',
        'webhook' => 'Discord Webhook URL',
        'webhook_info' => 'When an user create a ticket or add a comment it will create a notification on this webhook. Leave empty to disable',
        'scheduler' => 'When CRON tasks are setup, tickets can be automatically closed after a certain time.',
        'auto_close' => 'Delay before automatically closing tickets',
        'auto_close_info' => 'When a ticket doesn\'t receive any answer during this time, it will be automatically closed. Leave empty to disable.',
        'reopen' => 'Allow users to reopen a closed ticket.',
    ],

    'logs' => [
        'tickets' => [
            'reopened' => 'Reopened ticket #:id',
            'closed' => 'Closed ticket #:id',
        ],
    ],
];
