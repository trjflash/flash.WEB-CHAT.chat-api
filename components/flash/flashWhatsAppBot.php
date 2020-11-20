<?php
namespace app\components\flash;

{
    class flashWhatsAppBot{
        //specify instance URL and token
        private $APIurl = 'https://eu191.chat-api.com/instance195686/';
        private $token = 'oycyoxh358s1yvd8';

        public function __construct(){
            //get the JSON body from the instance
            $json = file_get_contents('php://input');
            $decoded = json_decode($json,true);

            //write parsed JSON-body to the file for debugging
            ob_start();
            var_dump($decoded);
            $input = ob_get_contents();
            ob_end_clean();
            file_put_contents('input_requests.log',$input.PHP_EOL,FILE_APPEND);

            if(isset($decoded['messages'])){
                //check every new message
                foreach($decoded['messages'] as $message){
                    //delete excess spaces and split the message on spaces. The first word in the message is a command, other words are parameters
                    $text = explode(' ',trim($message['body']));
                    //current message shouldn't be send from your bot, because it calls recursion
                    if(!$message['fromMe']){
                        //check what command contains the first word and call the function
                        switch(mb_strtolower($text[0],'UTF-8')){
                            case 'hi':  {$this->welcome($message['chatId'],false); break;}
                            case 'chatId': {$this->showchatId($message['chatId']); break;}
                            case 'time':   {$this->time($message['chatId']); break;}
                            case 'me':     {$this->me($message['chatId'],$message['senderName']); break;}
                            case 'file':   {$this->file($message['chatId'],$text[1]); break;}
                            case 'ptt':     {$this->ptt($message['chatId']); break;}
                            case 'geo':    {$this->geo($message['chatId']); break;}
                            case 'group':  {$this->group($message['author']); break;}
                            default:        {$this->welcome($message['chatId'],true); break;}
                        }
                    }
                }
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
    }

    //execute the class when this file is requested by the instance
    new flashWhatsAppBot();
}