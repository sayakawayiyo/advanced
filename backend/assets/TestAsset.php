<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 16:02
 */

namespace backend\assets;


use yii\web\AssetBundle;

class TestAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site_test.css'
    ];

    public $js = [
        'js/test.js'
    ];
    
    public $depends = [
        'backend\assets\Test2Asset'
    ];
}