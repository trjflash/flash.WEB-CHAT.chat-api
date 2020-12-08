<?php


namespace app\controllers;
//models
use app\models\ChatsInfo;
use app\models\ChatsMessages;
//API
use app\components\flash\flashWhatsAppBot;
//helpersa
use flashAjaxHelpers;
use flashHelpers;
//core
use Yii;
use yii\web\Controller;

class WawhController extends Controller{
    public $enableCsrfValidation = false;


    public function actionWh(){
        //flashHelpers::stopA(file_get_contents('php://input'));

        if(Yii::$app->request->isPost){
            $bot = new flashWhatsAppBot();

            $data = json_decode(file_get_contents('php://input'));

            $res = file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . file_get_contents('php://input'), FILE_APPEND);
            if($bot->checkInstanceId($data->instanceId)){
                for($i = 0; $i < count($data->messages); $i++){
                    $chatId = $data->messages[$i]->chatId;

                    if(!empty(ChatsInfo::checkChat($chatId))){
                        $newMessage = new ChatsMessages();

                        $newMessage->messageId = $data->messages[$i]->id;
                        $newMessage->body = $data->messages[$i]->body;
                        $newMessage->fromMe = $data->messages[$i]->fromMe;
                        $newMessage->self = $data->messages[$i]->self;
                        $newMessage->isForwarded = $data->messages[$i]->isForwarded;
                        $newMessage->author = $data->messages[$i]->author;
                        $newMessage->time = $data->messages[$i]->time;
                        $newMessage->chatId = $data->messages[$i]->chatId;
                        $newMessage->messageNumber = $data->messages[$i]->messageNumber;
                        $newMessage->type = $data->messages[$i]->type;
                        $newMessage->senderName = $data->messages[$i]->senderName;
                        $newMessage->caption = $data->messages[$i]->caption;
                        $newMessage->quotedMsgBody = $data->messages[$i]->quotedMsgBody;
                        $newMessage->quotedMsgId = $data->messages[$i]->quotedMsgId;
                        $newMessage->quotedMsgType = $data->messages[$i]->quotedMsgType;
                        $newMessage->chatName = $data->messages[$i]->chatName;
                        $newMessage->isNew = 1;
                        try {
                            $res = $newMessage->save();
                            if($res){
                                return 'success';
                                exit();
                            }
                        }catch (\Exception $e){
                            file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt','error'.$e->getMessage(), FILE_APPEND);
                        }
                    }
                    else{
                        $chatInfo = $bot->getDialogInfo($chatId);
                        if(!empty($chatInfo)){
                            try {
                                $newChat = new ChatsInfo();
                                $newChat->chatId = $chatId;
                                $newChat->chatName = $chatInfo->name;
                                $newChat->chatImage = $chatInfo->image;

                                $res = $newChat->save();
                                $newMessage = new ChatsMessages();

                                $newMessage->messageId = $data->messages[$i]->id;
                                $newMessage->body = $data->messages[$i]->body;
                                $newMessage->fromMe = $data->messages[$i]->fromMe;
                                $newMessage->self = $data->messages[$i]->self;
                                $newMessage->isForwarded = $data->messages[$i]->isForwarded;
                                $newMessage->author = $data->messages[$i]->author;
                                $newMessage->time = $data->messages[$i]->time;
                                $newMessage->chatId = $data->messages[$i]->chatId;
                                $newMessage->messageNumber = $data->messages[$i]->messageNumber;
                                $newMessage->type = $data->messages[$i]->type;
                                $newMessage->senderName = $data->messages[$i]->senderName;
                                $newMessage->caption = $data->messages[$i]->caption;
                                $newMessage->quotedMsgBody = $data->messages[$i]->quotedMsgBody;
                                $newMessage->quotedMsgId = $data->messages[$i]->quotedMsgId;
                                $newMessage->quotedMsgType = $data->messages[$i]->quotedMsgType;
                                $newMessage->chatName = $data->messages[$i]->chatName;
                                $newMessage->isNew = 1;

                                try {
                                    $res = $newMessage->save();
                                    if($res){
                                        return 'success';
                                        exit();
                                    }
                                }catch (\Exception $e){
                                    file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt','error'.$e->getMessage(), FILE_APPEND);
                                }
                            }catch (\Exception $e){
                                file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt','error'.$e->getMessage(), FILE_APPEND);

                                return 'invalid chat ID';
                                exit();
                            }
                            //flashHelpers::stopA(ChatsInfo::checkChat($chatId));
                        }
                    }
                    exit();
                }
            }
        }
    }
}