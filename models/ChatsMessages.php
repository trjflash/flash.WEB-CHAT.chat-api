<?php

namespace app\models;
use yii\db\ActiveRecord;

class ChatsMessages extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_chats_messages';
    }
    public function getChatMessages($chatId){
        return self::find()->where(['chatId' => "$chatId"])->asArray()->all();
    }
	public function getNewChatMessages($chatId){
        return self::find()->where(['chatId' => "$chatId",'isNew'=>'1'])->asArray()->all();
    }
	public function checkNewMessages(){
		return self::find()->select(['chatId'])->where(['isNew'=>'1','fromMe'=>'0'])->distinct()->asArray()->all();
	}

}