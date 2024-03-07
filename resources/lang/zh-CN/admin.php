return [
    'title' => '支持',

    'categories' => [
        'title' => '分类',
        'edit' => '编辑分类 #:category',
        'create' => '创建分类',

        'delete_empty' => '该分类包含工单，无法删除。',
    ],

    'tickets' => [
        'title' => '工单',
        'show' => '工单 #:ticket - :name',
        'create' => '创建工单',

        'open' => '打开工单',
    ],

    'permissions' => [
        'tickets' => '查看和管理支持工单',
        'categories' => '查看和管理支持分类',
    ],

    'settings' => [
        'title' => '支持设置',
        'home_message' => '首页消息',
        'webhook' => 'Discord Webhook URL',
        'webhook_info' => '当用户创建工单或添加评论时，将在此 Webhook 上创建通知。留空以禁用',
        'scheduler' => '当设置了 CRON 任务时，工单可以在一定时间后自动关闭。',
        'auto_close' => '自动关闭工单前的延迟时间',
        'auto_close_info' => '当工单在此时间内未收到任何回复时，将自动关闭。留空以禁用。',
        'reopen' => '允许用户重新打开已关闭的工单。',
    ],

    'logs' => [
        'tickets' => [
            'reopened' => '重新打开工单 #:id',
            'closed' => '关闭工单 #:id',
        ],
    ],
];
