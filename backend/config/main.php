<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
    ],
    'aliases' => [
        '@mdm/admin' => '@vendor/mdsoft/yii2-admin',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\UserBackend',
            'enableAutoLogin' => true,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'urlManager' => [
            //是否开启美化效果
            'enablePrettyUrl' => true,
            //是否显示脚本名index.php
            'showScriptName' => true,
            'enableStrictParsing' => true,
            'suffix' => '.html',
            'rules' => [
                '<controller:\w+>/<action:\w+>/<page:\d+>' => '<controller>/<action>',
                '/blogs/<id:\d+>' => '/blog/view',
                '/blogs' => '/blog/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>",
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
            'appendTimestamp' => true
        ],
        'authManager' => [
            'class' => 'yii\rbac\Dbmanager',
            'defaultRoles' => ['guest'],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => [
                        //'basePath' => '@app/themes/spring',
                        //'baseUrl' => '@web/themes/spring',
//                        '@app/themes/spring',
//                        '@app/themes/christmas',
                    ]
                ]
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ]
    ],
    'params' => $params,
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
        ],
    ],
    'as theme' => [
       'class' => 'backend\components\ThemeControl'
    ]
];
