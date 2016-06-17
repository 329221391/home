<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
        'articles' => 'app\modules\Admin\Articles',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'info'],
                    'categories' => ['yii\*'],
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['trace', 'info','error', 'warning'],
                    'message' => [
                        'to' => ['gjc1978@126.com', '1031534918@qq.com'],
                        'subject' => 'New jyq log message',
                    ],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
