<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 11:32
 */

namespace backend\controllers;


use backend\components\event\MailEvent;
use yii\web\Controller;

class SendMailController extends Controller
{
    const SEND_MAIL = 'send_mail';

    public function init()
    {
        parent::init();
        
        // 绑定邮件类，当事件触发的时候，调用我们刚刚定义的邮件类Mail
        $this->on(self::SEND_MAIL, ['backend\components\Mail', 'sendMail']);
    }

    public function actionSend()
    {
        //触发邮件事件
        $event = new MailEvent();
        $event->email = '12345679@qq.com';
        $event->subject = '事件邮件测试';
        $event->content = '邮件测试内容';

        $this->trigger(self::SEND_MAIL, $event);
    }
}