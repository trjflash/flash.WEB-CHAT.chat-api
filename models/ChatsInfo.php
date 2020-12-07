<?php

namespace app\models;
use yii\db\ActiveRecord;

class ChatsInfo extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_chats_info';
    }
    public function getChatImage($chatId){
        return self::find()->where(['chatId' => "$chatId"])->select('chatImage')->asArray()->all()[0]['chatImage'];;
    }
    public function checkChat($chatId){
        return self::find()->where(['chatId' => "$chatId"])->select('id')->asArray()->all();
    }

    public function getChats(){
        return self::find()->asArray()->all();
    }

}