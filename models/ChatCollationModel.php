<?php


namespace app\models;


use yii\db\ActiveRecord;

class ChatCollationModel extends ActiveRecord
{
    public static function tableName(){
        return 'flash_cms_table_chat_inst_collation';
    }

    public function getOperators(){
        return $this->hasMany(ChatInstancesModel::className(), ['inst_name' => 'name']);
    }

    public function GetCitiesForOperator($userId){
        return self::find()->where(['user' => "$userId"])->select('inst_name')->asArray()->all();
    }

}