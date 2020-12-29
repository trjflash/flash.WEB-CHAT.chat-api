<?php

namespace app\modules\wbadmin\controllers;

class AuthController extends AdminAppController{

    public function actionIndex(){

        return $this->render('authForm.twig');
    }
}