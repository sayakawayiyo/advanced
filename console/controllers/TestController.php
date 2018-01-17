<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 15:49
 */

namespace console\controllers;


use yii\console\Controller;

class TestController extends Controller
{
    public function actionIndex($name, $age)
    {
        echo "name is {$name}\n";
        echo "age is {$age}";
        return self::EXIT_CODE_NORMAL;
    }
}