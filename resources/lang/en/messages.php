<?php

return [
    'title' => 'Support',

    'fields' => [
        'subject' => 'Subject',
        'category' => 'Category',
        'ticket' => 'Ticket',
        'comment' => 'Comment',
    ],

    'actions' => [
        'create' => 'Open a new ticket',
        'reopen' => 'Reopen',
        'close' => 'Close',
    ],

    'state' => [
        'open' => 'Open',
        'closed' => 'Closed',
        'replied' => 'Replied',
    ],

    'tickets' => [
        'closed' => 'This ticket is closed.',

        'open' => 'Open a ticket',

        'notification' => 'New response on your support ticket.',

        'info' => '<strong>:author</strong> created this ticket in the category <strong>:category</strong> the :date.',
    ],

    'webhook' => [
        'ticket' => 'New ticket on the support',
        'comment' => 'New comment on the support',
        'closed' => 'Ticket closed',
    ],

    'mails' => [
        'comment' => [
            'subject' => 'New reply on your support ticket',
            'message' => 'Hello :user, your support ticket #:id got a new reply from :author.',
            'view' => 'View the ticket',
        ],
    ],

    'days' => 'jours',
];
