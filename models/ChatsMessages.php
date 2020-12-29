<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class ChatsMessages extends ActiveRecord{



    public static function tableName(){
        return 'flash_cms_table_chats_messages';
    }
    public function getChatMessages($chatId,$instanceId){
        return self::find()->where(['chatId' => "$chatId",'instance'=>$instanceId])->asArray()->all();
    }
	public function getNewChatMessages($chatId,$instanceId){

        return self::find()->where(['chatId' => "$chatId",'isNew'=>'1','instance'=>$instanceId])->asArray()->all();
    }
	public function checkNewMessages($instanceId){
        return self::find()->select(['chatId'])->where(['isNew'=>'1','fromMe'=>'0','instance'=>$instanceId])->distinct()->asArray()->all();
	}

}