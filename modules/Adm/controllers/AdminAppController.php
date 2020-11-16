<?php

namespace app\modules\Adm\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class AdminAppController extends Controller{


    public function behaviors(){

        return[
            'access' => [
                'class' =>AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ]
        ];
    }
}