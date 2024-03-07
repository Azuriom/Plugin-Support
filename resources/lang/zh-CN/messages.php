return [
    'title' => '支持',

    'fields' => [
        'subject' => '主题',
        'category' => '分类',
        'ticket' => '工单',
        'comment' => '评论',
    ],

    'actions' => [
        'create' => '打开新工单',
        'reopen' => '重新打开',
        'close' => '关闭',
    ],

    'state' => [
        'open' => '打开',
        'closed' => '关闭',
        'replied' => '已回复',
    ],

    'tickets' => [
        'closed' => '此工单已关闭。',

        'open' => '打开工单',

        'notification' => '您的支持工单有新回复。',

        'info' => '<strong>:author</strong> 在 :date 创建了此工单，属于分类 <strong>:category</strong>。',
    ],

    'webhook' => [
        'ticket' => '支持中的新工单',
        'comment' => '支持中的新评论',
        'closed' => '工单已关闭',
    ],

    'mails' => [
        'comment' => [
            'subject' => '您的支持工单收到新回复',
            'message' => '你好 :user，您的支持工单 #:id 收到了来自 :author 的新回复。',
            'view' => '查看工单',
        ],
    ],

    'days' => '天',
];
