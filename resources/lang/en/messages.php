<?php

return [
    'title' => 'Support',

    'fields' => [
        'subject' => 'Subject',
        'category' => 'Category',
        'ticket' => 'Ticket',
    ],

    'actions' => [
        'open-new' => 'Open a new ticket',
        'reopen' => 'Reopen',
        'close' => 'Close',
    ],

    'state' => [
        'open' => 'Open',
        'closed' => 'Closed',
    ],

    'tickets' => [
        'closed' => 'This ticket is closed.',

        'title-open' => 'Open a ticket',

        'notification' => 'New response on your support ticket.',

        'status-info' => '<strong>:author</strong> created this ticket in the category <strong>:category</strong> the :date.',
    ],

    'webhook' => [
        'ticket' => 'New ticket on the support',
        'comment' => 'New comment on the support',
        'closed' => 'Ticket closed',
    ],
];
