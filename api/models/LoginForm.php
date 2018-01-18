<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/18
 * Time: 14:15
 */

namespace api\models;



use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    /**
     * @var User
     */
    private $_user;
    const GET_API_TOKEN = 'generate_api_token';

    public function init()
    {
        parent::init();
        $this->on(self::GET_API_TOKEN, [$this, 'onGenerateApiToken']);
    }

    /**
     * @inheritdoc
     * 对客户端表单数据进行验证的rule
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * 自定义的密码认证方法
     * @param $attributes
     * @param $params
     */
    public function validatePassword($attributes, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = $this->getUser();
            if (!$this->_user || !$this->_user->validatePassword($this->password)) {
                $this->addError($attributes, '用户名或密码错误.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $this->trigger(self::GET_API_TOKEN);
            return $this->_user;
        } else {
            return null;
        }
    }

    /**
     * 根据用户名获取用户的认证信息
     * @return null|User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

    /**
     *登录校验成功后，为用户生成新的token
     *如果token失效，则重新生成token
     */
    public function onGenerateApiToken()
    {
        if (!User::apiTokenIsValid($this->_user->api_token)) {
            $this->_user->generateApiToken();
            $this->_user->save(false);
        }
    }
}