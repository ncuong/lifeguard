<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ]
    ],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
        ],
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport'=>false,
            'viewPath' => '@common/mail',
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'vietbinh.test01@gmail.com',
//                'password' => 'vietbinh.test',
//                'port' => '25',
//                'encryption' => 'tls', //depends if you need it
//            ],
        ],

//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport'=>false,
//            'transport' => [
//	            'class' => 'Swift_SmtpTransport',
//	            'host' => 'smtp.gmail.com',//smtp.mandrillapp.com
//	            'username' => 'vietbinh.test01@gmail.com',
//	            'password' => 'vietbinh.test',
//	            'port' => '587',
//	            'encryption' => 'tls',
//        	],
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'd-M-Y H:i:s',
            'timeFormat' => 'H:i:s',
        ]
    ],
    'params' => $params,
];