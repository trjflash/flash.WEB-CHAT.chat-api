<?php
namespace app\components\flash;

use app\models\ChatCollationModel;
use app\models\ChatInstancesModel;
use Yii;

{
    class flashWhatsAppBot{
        //specify instance URL and token
        private $APIurl;
        private $token;
        private $instanceId;

        public function __construct(){
            $instanceCity = ChatCollationModel::GetCitiesForOperator(Yii::$app->user->getId());
            if(count($instanceCity) == 1){
                $instanceData = ChatInstancesModel::getInstanceByName($instanceCity[0]['inst_name']);

                $this->APIurl = $instanceData[0]['link'];
                $this->token = $instanceData[0]['token'];
                $this->instanceId = $instanceData[0]['instance'];
            }

        }

        //this function calls function sendRequest to send a simple message
        //@param $chatId [string] [required] - the ID of chat where we send a message
        //@param $text [string] [required] - text of the message
        public function welcome($chatId, $noWelcome = false){
            $welcomeString = ($noWelcome) ? "Incorrect command\n" : "WhatsApp Demo Bot PHP\n";
            $this->sendMessage($chatId,
                $welcomeString.
                "Commands:\n".
                "1. chatId - show ID of the current chat\n".
                "2. time - show server time\n".
                "3. me - show your nickname\n".
                "4. file [format] - get a file. Available formats: doc/gif/jpg/png/pdf/mp3/mp4\n".
                "5. ptt - get a voice message\n".
                "6. geo - get a location\n".
                "7. group - create a group with the bot"
            );
        }

        //sends Id of the current chat. it is called when the bot gets the command "chatId"
        //@param $chatId [string] [required] - the ID of chat where we send a message
        public function showchatId($chatId){
            $this->sendMessage($chatId,'chatId: '.$chatId);
        }
        //sends current server time. it is called when the bot gets the command "time"
        //@param $chatId [string] [required] - the ID of chat where we send a message
        public function time($chatId){
            $this->sendMessage($chatId,date('d.m.Y H:i:s'));
        }
        //sends your nickname. it is called when the bot gets the command "me"
        //@param $chatId [string] [required] - the ID of chat where we send a message
        //@param $name [string] [required] - the "senderName" property of the message
        public function me($chatId,$name){
            $this->sendMessage($chatId,$name);
        }
        //sends a file. it is called when the bot gets the command "file"
        //@param $chatId [string] [required] - the ID of chat where we send a message
        //@param $format [string] [required] - file format, from the params in the message body (text[1], etc)
        public function file($chatId,$format){
            $availableFiles = array(
                'doc' => 'document.doc',
                'gif' => 'gifka.gif',
                'jpg' => 'jpgfile.jpg',
                'png' => 'pngfile.png',
                'pdf' => 'presentation.pdf',
                'mp4' => 'video.mp4',
                'mp3' => 'mp3file.mp3'
            );

            if(isset($availableFiles[$format])){
                $data = array(
                    'chatId'=>$chatId,
                    'body'=>'https://domain.com/PHP/'.$availableFiles[$format],
                    'filename'=>$availableFiles[$format],
                    'caption'=>'Get your file '.$availableFiles[$format]
                );
                $this->sendRequest('sendFile',$data);
            }
        }

        //sends a voice message. it is called when the bot gets the command "ptt"
        //@param $chatId [string] [required] - the ID of chat where we send a message
        public function ptt($chatId){
            $data = array(
                'audio'=>'https://domain.com/PHP/ptt.ogg',
                'chatId'=>$chatId
            );
            $this->sendRequest('sendAudio',$data);
        }

        //sends a location. it is called when the bot gets the command "geo"
        //@param $chatId [string] [required] - the ID of chat where we send a message
        public function geo($chatId){
            $data = array(
                'lat'=>51.51916,
                'lng'=>-0.139214,
                'address'=>'Ваш адрес',
                'chatId'=>$chatId
            );
            $this->sendRequest('sendLocation',$data);
        }

        //creates a group. it is called when the bot gets the command "group"
        //@param chatId [string] [required] - the ID of chat where we send a message
        //@param author [string] [required] - "author" property of the message
        public function group($author){
            $phone = str_replace('@c.us','',$author);
            $data = array(
                'groupName'=>'Group with the bot PHP',
                'phones'=>array($phone),
                'messageText'=>'It is your group. Enjoy'
            );
            $this->sendRequest('group',$data);
        }

        public function sendMessage($chatId, $text){
            $data = array('chatId'=>$chatId,'body'=>$text);
            $res = $this->sendRequestPost('message',$data);
            return $res;
        }

        public function sendMessageByPhone($phone, $text){
            $data = array('phone'=>$phone,'body'=>$text);
            $res = $this->sendRequestPost('message',$data);
            return $res;
        }
        public function sendFile($chatId, $text, $file, $filename){
            $data = array('chatId'=>$chatId,'filename'=>$filename,'caption'=>$text,'body'=>$file);
            $res = $this->sendRequestPost('sendFile',$data);
            return $res;
        }

        public function sendRequestPost($method,$data){

            if(is_array($data))
                $data_string = json_encode ($data, JSON_UNESCAPED_UNICODE);
            else
                $data_string = $data;

            //\flashHelpers::stopA($data);
            $curl = curl_init($this->APIurl.$method.'?token='.$this->token);

            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            // Принимаем в виде массива. (false - в виде объекта)
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            //\flashHelpers::stopA($curl);
            $result = curl_exec($curl);
            curl_close($curl);
            //\flashHelpers::stopA($result);
            return $result;

        }

        public function sendRequestGet($method, $params = false){

            $request = '';
            if($params)
                $request = $this->APIurl.$method.'?token='.$this->token.'&'.implode('&', $params);
            else
                $request = $this->APIurl.$method.'?token='.$this->token;

            //\flashHelpers::stopA($request);
            $curl = curl_init($request);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $result = curl_exec($curl);
            curl_close($curl);

            return json_decode($result);
        }

        public function getLastChatMessage($chatId){
            return $this->sendRequestGet("messages", ["limit=1","chatId=$chatId"]);
        }
        public function getNewMessagesInChat($chatId, $lastMessageId){
            return $this->sendRequestGet("messages", ["lastMessageNumber=".$lastMessageId."","chatId=$chatId"]);
        }
        public function sendReadChat($chatId){
            return $this->sendRequestPost("readChat", array("chatId"=>$chatId));
        }
        public function getChatMessages($chatId){
            return $this->sendRequestGet("messagesHistory", ["count=30","chatId=$chatId"]);
        }
        public function getMessages(){

            $date = date("d-m-Y").' 00:00:00';
            $date = strtotime($date);
            //\flashHelpers::stopA($date);
            return $this->sendRequestGet("messages",["min_time=$date"]);
        }
        public function checkInstanceId($instanceId){
            if($this->instanceId == $instanceId)
                return true;
            else
                return false;
        }
        public function getDialogInfo($chatId){
           return $this->sendRequestGet('dialog',["chatId=$chatId"]);
		   //\flashHelpers::stopA($res);
        }
    }

    //execute the class when this file is requested by the instance
    new flashWhatsAppBot();
}