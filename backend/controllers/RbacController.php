<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 12:10
 */

namespace backend\controllers;


use yii\web\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $blogIndex = $auth->createPermission('/blog/index');
        $blogIndex->description = '博客列表';
        $auth->add($blogIndex);
        $blogManage = $auth->createRole('博客管理');
        $auth->add($blogManage);
        $auth->addChild($blogManage, $blogIndex);
        $auth->assign($blogManage, 1);
    }
}