<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '0q12ZlRHWWAKya01FjGe5SNu6Jl5vcVl',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            // Имя генератора
            'giiant-crud' => [
                // Класс генератора
                'class'     => 'app\gii\generators\gcrud\Generator',
                // Настройки шаблонов
                'templates' => [
                    // Имя шаблона => путь к шаблону
                    'myCrud' => '@app/gii/generators/gcrud/default',
                ]
            ],
            'giiant-model' => [
                'class'     => 'schmunk42\giiant\generators\model\Generator',
                'templates' => [
                    'myModel' => '@app/gii/generators/giiant-model/default',
                ]
            ],
            'ajaxcrud' => [
                'class'     => 'johnitvn\ajaxcrud\generators\Generator',
                'templates' => [
                    'myAjax' => '@app/gii/generators/ajax/default',
                ]
            ],
            'crud' => [
                'class'     => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'constCrud' => '@app/gii/generators/crud/construct',
                ]
            ]
        ],
    ];
}

return $config;
