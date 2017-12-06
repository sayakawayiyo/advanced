<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 18:49
 */

namespace backend\components;


use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class AccessControl extends ActionFilter
{

    /**
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        //当前路由
        $actionId = '/' . $action->getUniqueId();

        //当前登陆用户的id
        $user = Yii::$app->getUser();
        $userId = $user->id;

        $routes = [];
        $manager = Yii::$app->getAuthManager();
        foreach ($manager->getPermissionsByUser($userId) as $name => $value) {
            if ($name[0] === '/') {
                $routes[] = $name;
            }
        }

        if (in_array($actionId, $routes)) {
            return true;
        }
        $this->denyAccess($user);
    }


    /**
     * @param User $user
     * @throws ForbiddenHttpException
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException('不允许访问....');
        }
    }
}