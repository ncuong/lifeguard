<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager' // 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ],
    ],
    'aliases' => [
        '@mdm/admin' => __DIR__.'/../../vendor/yiisoft/yii2-admin/',
    ],
//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/login',
//            'site/logout',
//            'admin/*', // add or remove allowed actions to this list
//        ]
//    ],
];
