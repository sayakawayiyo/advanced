<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 21:35
 */

namespace backend\components;


use Yii;
use yii\base\ActionFilter;

class ThemeControl extends ActionFilter
{
    public function init()
    {
        $switch = intval(Yii::$app->request->get('switch'));
        $theme = $switch ? 'spring' : 'christmas';

        Yii::$app->view->theme = Yii::createObject([
            'class' => 'yii\base\Theme',
            'pathMap' => [
                '@app/views' => [
                    '@app/themes/{$theme}',
                ]
            ]
        ]);
    }

}