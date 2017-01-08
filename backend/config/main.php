<?php

$params = array_merge (require (__DIR__ . '/../../common/config/params.php'), require (__DIR__ . '/../../common/config/params-local.php'), require (__DIR__ . '/params.php'), require (__DIR__ . '/params-local.php'));

return [
    'id' => 'app-backend',
    'basePath' => dirname (__DIR__),
    'language' => 'fa',
    'controllerNamespace' => 'backend\controllers',
    'homeUrl' => '/shop2/admin',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => TRUE,
            'identityCookie' => [
                'name' => '_dJHJSDjndasnsKUJSDAS645642ASKJD8 ',
                // unique for backend
            ],
        ],
        'session' => [
            'name' => 'jhdfsjJKSADJHjsadhjashd4546sdkja',
            'savePath' => sys_get_temp_dir (),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning'
                    ],
                ],
            ],
        ],
        'errorHandler' => ['errorAction' => 'site/error',],
        'request' => ['baseUrl' => '/shop2/admin',],
        'urlManager' => [
            'enablePrettyUrl' => TRUE,
            'showScriptName' => FALSE,
            'rules' => [
                '' => 'site/index',
                '<action>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
