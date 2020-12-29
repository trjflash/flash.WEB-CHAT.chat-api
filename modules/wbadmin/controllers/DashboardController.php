<?php

namespace app\modules\wbadmin\controllers;

class DashboardController extends  AdminAppController{

    public function actionIndex(){

        return $this->render('dashboard.twig');
    }
}