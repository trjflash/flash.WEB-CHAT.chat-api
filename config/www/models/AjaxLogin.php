<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AjaxLogin extends Model
{
    private $username;
    private $password;
    private $remember = true;

    private $_user = false;

    public  function getData($postArray){
        $this->password = $postArray['password'];
        $this->username = $postArray['username'];
        $this->remember = $postArray['remember'];
    }

    public function login()
    {
        if(!User::findByUsername($this->username))
            return false;
        else
            //TO:DO validate method
            return Yii::$app->user->login($this->getUser(), $this->remember ? 3600*24*30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}