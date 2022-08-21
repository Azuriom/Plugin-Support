<?php

return [
    'title' => '支持',

    'fields' => [
        'subject' => '主题',
        'category' => '类别',
        'ticket' => '工单',
        'comment' => '评论',
    ],

    'actions' => [
        'create' => '创建一个新的工单',
        'reopen' => '重新打开',
        'close' => '关闭',
    ],

    'state' => [
        'open' => '开启',
        'closed' => '关闭',
    ],

    'tickets' => [
        'closed' => '此工单已关闭',

        'open' => '创建工单',

        'notification' => '您的支持工单上的新回复',

        'info' => '<strong>:author</strong> 于 :date 创建了类别为 <strong>:category</strong> 的工单',
    ],

    'webhook' => [
        'ticket' => '支持上的新工单',
        'comment' => '关于支持的新评论',
        'closed' => '工单已关闭',
    ],

    'mails' => [
        'comment' => [
            'subject' => '您的工单上的新回复.',
            'message' => '您好 :user，您的工单 #:id 已由 :author 回复.',
            'view' => '查看工单',
        ],
    ],
];
