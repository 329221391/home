<?php
//master and slaver
//return [
//    'class' => 'yii\db\Connection',
//    'charset' => 'utf8',
//////    'tablePrefix'=>'yii_computer_',//not need tablePrefix
//    'masterConfig' => [
//        'username' => 'home',
//        'password' => 'dl2983252',
//        'attributes' => [
//            PDO::ATTR_TIMEOUT => 10,
//        ],
//    ],
//    'masters' => [
//        ['dsn' => 'mysql:host=106.3.40.117;port=3306;dbname=home',]
//    ],
//    'slaveConfig' => [
//        'username' => 'home',
//        'password' => 'dl2983252',
//        'attributes' => [
//            PDO::ATTR_TIMEOUT => 10,
//        ],
//    ],
//    'slaves' => [
//        ['dsn' => 'mysql:host=106.3.40.117;port=3307;dbname=home',]
//    ],
//];

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=tf_user_pltfm',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
//    'tablePrefix'=>'yii_computer_',//not need tablePrefix
];
