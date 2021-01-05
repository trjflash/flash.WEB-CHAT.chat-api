<?php


namespace app\models;


class WaBotLastMessageModel extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_bwa_bot_last_message';
    }

    public static function getLastMessageByChatId($id){
        return self::find()->where(['chat_id' => $id])->asArray()->all();
    }

}