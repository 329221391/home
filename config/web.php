<?php

$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
//    'urlManager'=>array(
//        'urlFormat'=>'path',
//        'showScriptName'=>false,    // 这一步是将代码里链接的index.php隐藏掉。
//        'rules'=>array(
//            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//        ),
//    ),
    'modules' => [
        'gii' => 'yii\gii\Module',
        'Hshop' => [
            'class' => 'app\modules\Hshop\Hshop',
        ],
        'Tshop' => [
            'class' => 'app\modules\Tshop\Tshop',
        ],
        'Pshop' => [
            'class' => 'app\modules\Pshop\Pshop',
        ],
        'Hres' => [
            'class' => 'app\modules\Hres\Hres',
        ],
        'Tres' => [
            'class' => 'app\modules\Tres\Tres',
        ],
        'Pres' => [
            'class' => 'app\modules\Pres\Pres',
        ],
        'Redfl' => [
            'class' => 'app\modules\Admin\Redfl\Redfl',
        ],
        'manage' => [
            'class' => 'app\modules\manage\manage',
        ],
        'AppBase' => [
            'class' => 'app\moduels\AppBase\AppBase',
        ],
        'Logs' => [
            'class' => 'app\modules\Admin\Logs\Logs',
        ],
        'Apkversion' => [
            'class' => 'app\modules\Admin\Apkversion\Apkversion',
        ],
        'Articles' => [
            'class' => 'app\modules\Admin\Articles\Articles',
        ],
        'Location' => [
            'class' => 'app\modules\Admin\Location\Location',
        ],
        'Admin' => [
            'class' => 'app\modules\Admin\Admin\Admin',
        ],
        'Customs' => [
            'class' => 'app\modules\Admin\Custom\Customs',
        ],
        'Schools' => [
            'class' => 'app\modules\Admin\School\School',
        ],
        'Classes' => [
            'class' => 'app\modules\Admin\Classes\Classes',
        ],
        'Message' => [
            'class' => 'app\modules\Admin\Message\Message',
        ],
        'CatDefalut' => [
            'class' => 'app\modules\Admin\CatDefalut\CatDefalut',
        ],
        'Catalogue' => [
            'class' => 'app\modules\Admin\Catalogue\Catalogue',
        ],
        'CatalogueDes' => [
            'class' => 'app\modules\Admin\CatalogueDes\CatalogueDes',
        ],
        'Notes' => [
            'class' => 'app\modules\Admin\Notes\Notes',
        ],
        'Vote' => [
            'class' => 'app\modules\Admin\Vote\Vote',
        ],
        'Stats' => [
            'class' => 'app\modules\Stats\Stats',
        ],
        'Score' => [
            'class' => 'app\modules\Score\Score',
        ],
        'Club' => [
            'class' => 'app\modules\Club\Club',
        ],
        'ZhaoSheng' => [
            'class' => 'app\modules\Admin\ZhaoSheng\ZhaoSheng'
        ],
        'ZhaoPin' => [
            'class' => 'app\modules\Admin\ZhaoPin\ZhaoPin'
        ],
        'CheckIn' =>[
            'class' => 'app\modules\Admin\CheckIn\CheckIn'
        ],
        'Homework' =>[
            'class' => 'app\modules\Admin\Homework\Homework'
        ],
        'Pic' =>[
            'class' => 'app\modules\Admin\Pic\Pic'
        ],
        'Course' =>[
            'class' => 'app\modules\Admin\Course\Course'
        ],
        'Shipping' =>[
            'class' => 'app\modules\Admin\Shipping\Shipping'
        ],
        'Prize' =>[
            'class' => 'app\modules\Admin\Prize\Prize'
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'NKRkc1lOScbJuypvl2B6AJB1NIPsOS2y',
            'enableCsrfValidation' => false,
        ],
        'db' => require(__DIR__ . '/db.php'),
        'db2' => require(__DIR__ . '/db2.php'),
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => './index.php'
        ],
        'errorHandler' => [
            'errorAction' => 'site/myerror',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com',
                'username' => '1031534918@qq.com',
                'password' => 'csenejfahoeqbbcg',
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['1031534918@qq.com' => 'admin']
            ],
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
if (!YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
return $config;
