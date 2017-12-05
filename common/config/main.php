<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //配置数据库
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=test_17',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf-8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 24*3600,
            'schemaCache' => 'cache',
        ],
        'authManager' => ['class' => 'yii\rbac\DbManager']
    ],
    //配置语言
    'language' => 'zh-CN',
    //配置时区
    'timeZone' => 'Asia/Shanghai',
];
