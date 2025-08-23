<?php

return [
    'title' => 'Support',

    'seconds' => 'seconds',

    'fields' => [
        'subject' => 'Subject',
        'ticket' => 'Ticket',
        'comment' => 'Comment',
        'assignee' => 'Assignee',
    ],

    'actions' => [
        'create' => 'Open a new ticket',
        'reopen' => 'Reopen',
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
        'delay' => 'You need to wait :time before opening a new ticket.',
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

    'days' => 'days',
];
