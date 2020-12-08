<?php
namespace app\components\jobs;

use yii\base\BaseObject;
use app\components\flash\flashWhatsAppBot;

class WaMailing extends BaseObject implements \yii\queue\JobInterface{
    public $data;
    private $bot ;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->bot = new flashWhatsAppBot();
    }

    public function execute($queue)
    {

        try {
            $data = json_decode($this->data);
            for ($i = 0; $i<count($data[0]); $i++){
                $this->bot->sendMessageByPhone($data[0][$i][0], $data[0][$i][1]);
                sleep(5);
            }
            //file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . $this->data, FILE_APPEND);

        }catch (\Exception $e){
            file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . $e->getMessage(), FILE_APPEND);
        }


    }
}