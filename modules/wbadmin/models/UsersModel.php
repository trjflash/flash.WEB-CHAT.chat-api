<?php


namespace app\modules\wbadmin\models;


class UsersModel extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_users';
    }

    public function getChatUsers($id){
        return self::find()->select(['username','display_name'])->where(['!=','username','flashadmin'])->andWhere(['id' => $id])->asArray()->all();
    }

}