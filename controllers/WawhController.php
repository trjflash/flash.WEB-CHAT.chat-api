<?php


namespace app\controllers;
//models
use app\models\ChatsInfo;
use app\models\ChatsMessages;
use app\models\ChatInstancesModel;
//API
use app\components\flash\flashWaBotC;

//helpers
use flashAjaxHelpers;
use flashHelpers;
//core
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WawhController extends Controller{
    public $enableCsrfValidation = false;


    public function actionWh(){
        //flashHelpers::stopA(file_get_contents('php://input'));
        //file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . file_get_contents('php://input') , FILE_APPEND);
        if(Yii::$app->request->isPost){

            $data = json_decode(file_get_contents('php://input'));
            //flashHelpers::stopA(json_decode(file_get_contents('php://input')));
            $instanceData = ChatInstancesModel::getInstanceByid($data->instanceId);
            $bot = new flashWaBotC($instanceData);

            //file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . $data , FILE_APPEND);
            for($i = 0; $i < count($data->messages); $i++){
                $chatId = $data->messages[$i]->chatId;
                $fromMe = '0';
                if($data->messages[$i]->fromMe != false)
                    $fromMe = '1';
                if(!empty(ChatsInfo::checkChat($chatId,$data->instanceId))){
                    $newMessage = new ChatsMessages();

                    $newMessage->messageId = $data->messages[$i]->id;
                    $newMessage->body = $data->messages[$i]->body;
                    $newMessage->self = $data->messages[$i]->self;
                    $newMessage->fromMe = $fromMe;
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
                    $newMessage->isNew = '1';
                    $newMessage->instance = $data->instanceId;

                    try {
                        $res = $newMessage->save();
                        file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt','error'.var_dump($res), FILE_APPEND);
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
                            $newChat->instance = $data->instanceId;

                            $res = $newChat->save();
                            $newMessage = new ChatsMessages();

                            $newMessage->messageId = $data->messages[$i]->id;
                            $newMessage->body = $data->messages[$i]->body;
                            $newMessage->self = $data->messages[$i]->self;
                            $newMessage->fromMe = $fromMe;
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
                            $newMessage->isNew = '1';
                            $newMessage->instance = $data->instanceId;

                            //file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt','error'.var_dump($res), FILE_APPEND);
                            try {
                                $res = $newMessage->save();

                                file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt','error'.var_dump($res), FILE_APPEND);
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