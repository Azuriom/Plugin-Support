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
            'created' => 'Le commentaire a été créé.',
            'updated' => 'Ce commentaire a été mis à jour.',
            'deleted' => 'Ce commentaire a été supprimé.',
        ],
    ],
];