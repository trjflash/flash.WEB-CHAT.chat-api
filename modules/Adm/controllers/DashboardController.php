<?php

namespace app\modules\Adm\controllers;

class DashboardController extends  AdminAppController{

    public function actionIndex(){

        return $this->render('dashboard.twig');
    }
}