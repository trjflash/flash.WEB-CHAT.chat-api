<?php


namespace app\modules\wbadmin\controllers;

use app\models\ChatCollationModel;
use app\models\ChatInstancesModel;
use app\modules\wbadmin\models\UsersModel;
use Yii;

class EditorsController extends AdminAppController{

    public function actionInstances(){

        $instances = ChatInstancesModel::getInstanceDisplayName();

        return $this->render('instancesList.twig', compact('instances'));
    }
    public function actionUsers(){

        $instanceCity = ChatCollationModel::GetCitiesForOperator(Yii::$app->user->getId());
        //\flashHelpers::stopA($instanceCity);

        if(count($instanceCity) == 1){
            $instances = ChatInstancesModel::getInstanceDisplayNameByName($instanceCity[0]['inst_name']);
        }
        else{

            $instances = ChatInstancesModel::getInstanceDisplayName($instanceCity[0]['inst_name']);

        }
        $users = array();

        for ($i = 0; $i<count($instances); $i ++){
            $users = array_merge($users,ChatCollationModel::getOperators($instances[$i]['name']));

        }

        $roles = array();
        $permissions = Yii::$app->authManager->getRoles();
        //\flashHelpers::stopA($permissions);
        $i=0;
        foreach ($permissions as $key => $perm) {

            $roles[$i]['roleName'] = $perm->name;
            $roles[$i]['displayName'] = $perm->description;
            $i++;
        }

        //\flashHelpers::stopA($roles);
        return $this->render('usersList.twig', compact('users','instances', 'roles'));
    }


}