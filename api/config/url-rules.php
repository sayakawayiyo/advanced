<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 16:42
 */

/**
 * 在这里配置所有的路由规则
 */
$urlRuleConfigs = [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/user'],
        'extraPatterns' => [
            'POST login' => 'login',
            'GET signup-test' => 'signup-test',
            'GET,OPTIONS user-profile' => 'user-profile',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/goods']
    ]
];

/**
 * 基本的url规则配置
 * @param $unit
 * @return array
 */
function baseUrlRules($unit)
{
    $config = [
        'class' => 'yii\rest\UrlRule',
    ];
    return array_merge($config, $unit);
}

return array_map('baseUrlRules', $urlRuleConfigs);