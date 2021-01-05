<?php


namespace app\models;


use app\modules\wbadmin\models\UsersModel;
use yii\db\ActiveRecord;

class ChatCollationModel extends ActiveRecord
{
    public static function tableName(){
        return 'flash_cms_table_chat_inst_collation';
    }

    public function getInstance(){
        return $this->hasMany(ChatInstancesModel::className(), ['inst_name' => 'name']);
    }

    public function GetCitiesForOperator($userId){
        return self::find()->where(['user' => "$userId"])->select('inst_name')->asArray()->all();
    }

    public function getOperators($instance){

        $data = self::findAll(['inst_name'=>$instance]);
        $userData = [];
        for ($i = 0; $i< count($data); $i++){
            $dt = UsersModel::getChatUsers($data[$i]->user);

            if(!empty($dt))
                $userData[$i] = $dt[0];
        }
        return array_values($userData);
    }

}