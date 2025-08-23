<?php

return [
    'title' => 'Support',

    'seconds' => 'secondes',

    'fields' => [
        'subject' => 'Sujet',
        'ticket' => 'Ticket',
        'comment' => 'Commentaire',
        'assignee' => 'Assigné',
    ],

    'actions' => [
        'create' => 'Ouvrir un nouveau ticket',
        'reopen' => 'Réouvrir',
    ],

    'state' => [
        'open' => 'Ouvert',
        'closed' => 'Fermé',
        'replied' => 'Répondu',
    ],

    'tickets' => [
        'closed' => 'Ce ticket est fermé.',

        'open' => 'Ouvrir un ticket',

        'notification' => 'Nouvelle réponse sur votre ticket dans le support.',
        'delay' => 'Vous devez attendre :time avant de pouvoir ouvrir un nouveau ticket.',
        'info' => '<strong>:author</strong> a créé ce ticket dans la catégorie <strong>:category</strong> le :date.',
    ],

    'webhook' => [
        'ticket' => 'Nouveau ticket sur le support',
        'comment' => 'Nouvelle réponse sur le support',
        'closed' => 'Ticket fermé',
    ],

    'mails' => [
        'comment' => [
            'subject' => 'Nouvelle réponse sur votre ticket sur le support',
            'message' => 'Bonjour :user, votre ticket support #:id a reçu une nouvelle réponse de :author.',
            'view' => 'Voir le ticket',
        ],
    ],

    'days' => 'jours',
];
