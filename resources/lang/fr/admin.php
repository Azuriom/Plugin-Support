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

    'fields' => [
        'title' => 'Champs du modèle pour les tickets',
        'info' => 'Un modèle est utilisé pour définir les champs qui seront affichés lors de la création d\'un ticket au lieu d\'un champ de texte libre.',
        'required' => 'Est-ce que ce champ est requis ?',
        'options' => 'Options',

        'text' => 'Texte',
        'textarea' => 'Zone de texte (plusieurs lignes)',
        'number' => 'Nombre',
        'email' => 'E-Mail',
        'checkbox' => 'Case à cocher',
        'dropdown' => 'Menu déroulant',
    ],

    'settings' => [
        'title' => 'Paramètres du support',
        'home_message' => 'Message de la page d\'accueil',
        'delay' => 'Délai entre deux tickets',
        'webhook' => 'URL de webhook Discord',
        'webhook_info' => 'Lorsqu\'un utilisateur crée un ticket ou ajoute un commentaire, ca va créer une notification sur ce webhook. Laissez vide pour ne pas utiliser de webhook.',
        'scheduler' => 'Lorsque les tâches CRON sont configurées, les tickets peuvent être automatiquement fermés après un certain temps.',
        'auto_close' => 'Délai avant de fermer les tickets automatiquement',
        'auto_close_info' => 'Lorsqu\'un ticket ne reçoit pas de réponse pendant ce temps, il sera automatiquement fermé. Laissez vide pour désactiver.',
        'reopen' => 'Autoriser les utilisateurs à réouvrir un ticket fermé.',
    ],

    'logs' => [
        'tickets' => [
            'reopened' => 'Réouverture du ticket #:id',
            'closed' => 'Fermeture du ticket #:id',
        ],
    ],
];
