<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 11:43
 */

namespace backend\components\event;


use yii\base\Event;

class MailEvent extends Event
{
    public $email;
    public $subject;
    public $content;
}