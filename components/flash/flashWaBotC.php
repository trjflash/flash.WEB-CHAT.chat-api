<?php
namespace app\components\flash;

use app\models\ChatCollationModel;
use app\models\ChatInstancesModel;
use Yii;

class flashWaBotC{

    //specify instance URL and token
    private $APIurl;
    private $token;
    private $instanceId;

    public function __construct($instanceData){

        $this->APIurl = $instanceData[0]['link'];
        $this->token = $instanceData[0]['token'];
        $this->instanceId = $instanceData[0]['instance'];

    }

    public function sendMessageByPhone($phone, $text){
        file_put_contents('/web/sites/chat.onclinic.local/www/components/jobs/logs/mailingErrorData.txt', PHP_EOL . 'mailing ', FILE_APPEND);

        $data = array('phone'=>$phone,'body'=>$text);
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

}