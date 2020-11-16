<?php

namespace app\modules\Adm\controllers;

class AuthController extends AdminAppController{

    public function actionIndex(){

        return $this->render('authForm.twig');
    }
}