<?php
namespace app\components\jobs;

use app\components\flash\flashWaBotC;
use app\models\ChatInstancesModel;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class WaMailing extends BaseObject implements JobInterface{
    public $data;
    public $instance;
    private $bot ;

    private $debug = false;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $instanceData = ChatInstancesModel::getInstanceByid($this->instance);
        $this->bot = new flashWaBotC($instanceData);

    }

    public function execute($queue)
    {
        if($this->debug)
            file_put_contents(Yii::getAlias('@wabotmailing/mailingErrorData.txt'), PHP_EOL . 'mailing ', FILE_APPEND);

        try {
            $data = json_decode($this->data);
            if($this->debug)
                file_put_contents(Yii::getAlias('@wabotmailing/mailingErrorData.txt'), PHP_EOL . 'mailing ', FILE_APPEND);

            for ($i = 0; $i<count($data[0]); $i++) {

                if($this->debug)
                    file_put_contents(Yii::getAlias('@wabotmailing/mailingErrorData.txt'), PHP_EOL . 'mailing ', FILE_APPEND);
                if (preg_match_all('^[7][7]{1}[0-7]{1}[0-8]{1}\d{7}$^', $data[0][$i][0])) {

                    $this->bot->sendMessageByPhone($data[0][$i][0], $data[0][$i][1]);
                    sleep(5);
                }
            }
            //file_put_contents('/web/sites/chat.onclinic.kz/www/controllers/data.txt', PHP_EOL . $this->data, FILE_APPEND);

        }catch (\Exception $e){
            if($this->debug)
                file_put_contents(Yii::getAlias('@wabotmailing/mailingErrorMessage.txt'), PHP_EOL . 'mailing ', FILE_APPEND);

            if($this->debug)
                file_put_contents(Yii::getAlias('@wabotmailing/mailingErrorData.txt'), PHP_EOL . 'mailing ', FILE_APPEND);
        }


    }
}