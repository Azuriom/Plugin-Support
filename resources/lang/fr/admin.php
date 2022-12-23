<?php

return [
    'title' => 'Support',

    'categories' => [
        'title' => 'Catégories',
        'edit' => 'Éditer la catégorie #:category',
        'create' => 'Créer une catégorie',

        'delete_empty' => 'La catégorie contient des tickets et ne peut pas être supprimée.',
    ],

    'tickets' => [
        'title' => 'Tickets',
        'show' => 'Ticket #:ticket - :name',
        'create' => 'Créer un ticket',

        'open' => 'Tickets ouverts',
    ],

    'permissions' => [
        'tickets' => 'Voir et gérer les tickets du support',
        'categories' => 'Voir et gérer les catégories des tickets du support',
    ],

    'settings' => [
        'title' => 'Paramètres du support',
        'home_message' => 'Message de la page d\'accueil',
        'webhook' => 'URL de webhook Discord',
        'webhook_info' => 'Lorsqu\'un utilisateur crée un ticket ou ajoute un commentaire, ca va créer une notification sur ce webhook. Laissez vide pour ne pas utiliser de webhook.',
    ],

    'logs' => [
        'tickets' => [
            'closed' => 'Fermeture du ticket #:id',
        ],
    ],
];
