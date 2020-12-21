<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'layout' => false,
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'queue'
		],
    'language' => 'ru-RU',
    'modules' => [
        'adm' => [
            'class' => 'app\modules\Adm\Module',
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@activtheme' => 'Colorlib',
        '@ptmpls' => '@app/views/themes/Colorlib',
        '@repeatable' => '@ptmpls/repeatable',
        '@feature' => '@ptmpls/feature',
        '@webfeature' => '@app/web/images/feature',
        '@modules' => '@app/modules',
        '@shopphotos' => '@app/web/images/shop',
        '@outfiles' => '@app/web/images/out',
        '@console' => '@app/console',
    ],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
	
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@console/runtime/queue',
            'as log' => \yii\queue\LogBehavior::class,
        ],
        'viewRenderer' => array(
            'class' => 'ext.ETwigViewRenderer',

            // All parameters below are optional, change them to your needs
            'fileExtension' => '.twig',
            'options' => array(
                'autoescape' => true,
            ),
            'extensions' => array(
                'My_Twig_Extension',
            ),
            'globals' => array(
                'html' => 'CHtml'
            ),
            'functions' => array(
                'rot13' => 'str_rot13',
            ),
            'filters' => array(
                'jencode' => 'CJSON::encode',
            ),
            // Change template syntax to Smarty-like (not recommended)
            'lexerOptions' => array(
                'tag_comment'  => array('{*', '*}'),
                'tag_block'    => array('{', '}'),
                'tag_variable' => array('{$', '}')
            ),
        ),
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XN_WK0_ugW-vFIoAOLvCw1DjfHwsU09X',
            'baseUrl' =>''
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
                        'adm' => 'adm/dashboard',
                        'login' => 'site/login',

                    [
                        'pattern'=>'<url:.+>',
                        'route' => 'materials/view',
                        'suffix' => '.html',
                    ],
                )
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
