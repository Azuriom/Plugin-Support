<?php

return [
    'title' => 'Support',

    'categories' => [
        'title' => 'Catégories',
        'title-edit' => 'Éditer la catégorie #:category',
        'title-create' => 'Créer une catégorie',

        'status' => [
            'created' => 'La catégorie a été créée.',
            'updated' => 'Cette catégorie a été mise à jour.',
            'deleted' => 'Cette catégorie a été supprimée.',

            'error-delete' => 'La catégorie contient des tickets et ne peut pas être supprimée.',
        ],
    ],

    'tickets' => [
        'title' => 'Tickets',
        'title-show' => 'Ticket #:ticket - :name',
        'title-create' => 'Créer un ticket',

        'open-tickets' => 'Tickets ouverts',

        'status' => [
            'created' => 'Le ticket a été créé.',
            'updated' => 'Ce ticket a été mis à jour.',
            'deleted' => 'Ce ticket a été supprimé.',
            'closed' => 'Ce ticket a été fermé.',
            'opened' => 'Ce ticket a été ouvert.',
        ],
    ],

    'comments' => [
        'status' => [
            'created' => 'Votre réponse a été ajoutée.',
            'updated' => 'Cette réponse a été mise à jour.',
            'deleted' => 'Cette réponse a été supprimée.',
        ],
    ],

    'permissions' => [
        'tickets' => 'Voir et gérer les tickets du support',
        'categories' => 'Voir et gérer les catégories des tickets du support',
    ],

    'settings' => [
        'title' => 'Paramètres du support',
        'webhook' => 'URL de webhook Discord',
        'webhook-info' => 'Lorsqu\'un utilisateur crée un ticket ou ajoute un commentaire, ca va créer une notification sur ce webhook. Laissez vide pour ne pas utiliser de webhook.',
    ],
];
