<?php
namespace app\components\jobs;

use yii\base\BaseObject;
use app\components\flash\flashWhatsAppBot;
use yii\queue\JobInterface;

class WaMailing extends BaseObject implements JobInterface{
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
            for ($i = 0; $i<count($data[0]); $i++) {

            file_put_contents('/web/sites/chat.onclinic.kz/www/components/jobs/logs/mailingErrorData.txt', PHP_EOL . $data[0][$i][0], FILE_APPEND);
                if (preg_match_all('^[7][7]{1}[0-7]{1}[0-8]{1}\d{7}$^', $data[0][$i][0])) {

                    $this->bot->sendMessageByPhone($data[0][$i][0], $data[0][$i][1]);
                    sleep(5);
                }
            }
            //file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . $this->data, FILE_APPEND);

        }catch (\Exception $e){
            file_put_contents('/web/sites/chat.onclinic.kz/www/components/jobs/logs/mailingErrorMessage.txt', PHP_EOL . $e->getMessage(), FILE_APPEND);
            file_put_contents('/web/sites/chat.onclinic.kz/www/components/jobs/logs/mailingErrorData.txt', PHP_EOL . $this->data, FILE_APPEND);
        }


    }
}