<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 15:59
 */

namespace backend\components;


use Yii;
use yii\base\ActionFilter;

class MyBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        return true;
    }
    
    public function isGuest()
    {
        return Yii::$app->user->isGuest;
    }
}