<?php

return [
    'title' => '支持',

    'categories' => [
        'title' => '类别管理',
        'edit' => '编辑类别 #:category',
        'create' => '创建类别',

        'delete_empty' => '此类别下存在工单，还不能被删除.',
    ],

    'tickets' => [
        'title' => '工单',
        'show' => '工单 #:ticket - :name',
        'create' => '创建工单',

        'open' => '打开工单',
    ],

    'permissions' => [
        'tickets' => '查看和管理支持票',
        'categories' => '查看和管理支持类别',
    ],

    'settings' => [
        'title' => '支持设置',
        'webhook' => 'Discord Webhook URL',
        'webhook_info' => '当用户创建工单或添加评论时，它将在此 Webhook 上创建一个通知。留空则禁用',
    ],

    'logs' => [
        'tickets' => [
            'closed' => '已关闭工单 #:id',
        ],
    ],
];
