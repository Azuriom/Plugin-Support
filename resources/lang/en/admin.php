<?php

return [
    'title' => 'Support',

    'categories' => [
        'title' => 'Categories',
        'title-edit' => 'Edit category #:category',
        'title-create' => 'Create category',

        'status' => [
            'created' => 'The category has been created.',
            'updated' => 'This category has been updated.',
            'deleted' => 'This category has been deleted.',

            'error-delete' => 'The category contains tickets and can\'t be deleted.',
        ],
    ],

    'tickets' => [
        'title' => 'Tickets',
        'title-show' => 'Ticket #:ticket - :name',
        'title-create' => 'Create ticket',

        'open-tickets' => 'Open tickets',

        'status' => [
            'created' => 'The ticket has been created.',
            'updated' => 'This ticket has been updated.',
            'deleted' => 'This ticket has been deleted.',
            'closed' => 'This ticket has been closed.',
            'opened' => 'This ticket has been opened.',
        ],
    ],

    'comments' => [
        'status' => [
            'created' => 'The comment has been created.',
            'updated' => 'This comment has been updated.',
            'deleted' => 'This comment has been deleted.',
        ],
    ],

    'permissions' => [
        'tickets' => 'View and manage support tickets',
        'categories' => 'View and manage support categories',
    ],

    'settings' => [
        'title' => 'Support settings',
        'webhook' => 'Discord Webhook URL',
        'webhook-info' => 'When an user create a ticket or add a comment it will create a notification on this webhook. Leave empty to disable',
    ],
];
