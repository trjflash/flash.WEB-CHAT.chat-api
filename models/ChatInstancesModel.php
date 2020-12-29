<?php


namespace app\models;


use yii\db\ActiveRecord;

class ChatInstancesModel extends ActiveRecord
{
    public static function tableName(){
        return 'flash_cms_table_chat_instances';
    }

    public function getInstanceForOperator(){
        return $this->hasOne(ChatCollationModel::className(), ['name' => 'inst_name']);
    }

    public function getInstanceByName($instanceName){
        return self::find()->where(['name' => "$instanceName"])->select(['link','token','instance'])->asArray()->all();
    }
    public function getInstanceByid($instanceid){
        return self::find()->where(['instance' => "$instanceid"])->select(['link','token','instance'])->asArray()->all();
    }

    public function getInstanceDisplayNameByName($instanceName){
        return self::find()->where(['name' => "$instanceName"])->select(['name','display_name'])->asArray()->all();
    }
    public function getInstanceDisplayName(){
        return self::find()->select(['name','display_name'])->asArray()->all();
    }

    public function GetInstanceIdByName($instanceName){
        return self::find()->where(['name' => "$instanceName"])->select('instance')->asArray()->all();
    }
}