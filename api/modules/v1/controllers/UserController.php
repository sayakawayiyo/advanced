<?php

namespace api\modules\v1\controllers;

use api\models\LoginForm;
use api\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Response;

class UserController extends ActiveController
{
    public $modelClass = 'api\models\User';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                'optional' => [
                    'login',
                    'signup-test'
                ]
            ],
            //跨域
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Headers' => ['authorization'],
                ],
            ],
        ]);
    }

    public function actionSignupTest()
    {
        $user = new User();
        $user->generateAuthKey();
        $user->setPassword('123456');
        $user->username = 'test3';
        $user->email = 'test2@qq.com';

        return $user->save(false);
    }

    /**
     * 登录
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->setAttributes(Yii::$app->request->post());
        if (($user = $model->login())) {
            return [
                'code' => 0,
                'data' => [
                    'token' => $user->api_token
                ]
            ];
        } else {
            $errors = $model->errors;
            $firstError = current($errors);
            return [
                'code' => 10001,
                'msg' => $firstError[0]
            ];
        }
    }

    /**
     * 获取用户信息
     * @return array
     */
    public function actionUserProfile()
    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
        // 到这一步，token都认为是有效的了
        // 下面只需要实现业务逻辑即可
        $user = $this->authenticate(Yii::$app->user, Yii::$app->request, Yii::$app->response);
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email

        ];
    }
}
