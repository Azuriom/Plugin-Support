<?php

return [
    'title' => 'Support',

    'fields' => [
        'subject' => 'Sujet',
        'category' => 'Catégorie',
        'ticket' => 'Ticket',
    ],

    'actions' => [
        'open-new' => 'Ouvrir un nouveau ticket',
        'reopen' => 'Réouvrir',
        'close' => 'Fermer',
    ],

    'state' => [
        'open' => 'Ouvert',
        'closed' => 'Fermé',
    ],

    'tickets' => [
        'closed' => 'Ce ticket est fermé.',

        'title-open' => 'Ouvrir un ticket',

        'notification' => 'Nouvelle réponse sur votre ticket dans le support.',

        'status-info' => '<strong>:author</strong> a créé ce ticket dans la catégorie <strong>:category</strong> le :date.',
    ],

    'webhook' => [
        'ticket' => 'Nouveau ticket sur le support',
        'comment' => 'Nouvelle réponse sur le support',
        'closed' => 'Ticket fermé',
    ],
];
