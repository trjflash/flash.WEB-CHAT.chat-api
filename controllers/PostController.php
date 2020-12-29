<?php


namespace app\controllers;


use app\components\flash\flashWhatsAppBot;

use app\components\jobs\WaMailing;
use app\models\AjaxLogin;
use app\models\ChatCollationModel;
use app\models\ChatInstancesModel;
use app\models\User;
use app\modules\Adm\models\MenuEditorModel;
use app\modules\Adm\models\MenuTableToController;
use app\modules\Adm\models\RootEditorsModel;
use app\modules\Adm\models\ShopCategoriesModel;
use app\modules\Adm\models\ShopGoodsModel;
use app\modules\Adm\models\ShopGoodsPhotosModel;
use app\modules\Adm\models\TablesForLinksModel;
use app\modules\Adm\models\MenuEditorsTypesModel;
//API
use app\models\ChatsMessages;

use flashAjaxHelpers;
use flashHelpers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class PostController extends Controller{


    private $bot;
    private $session;
    private $instanceId;


    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['request'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'request' => ['post','get'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->session = Yii::$app->session;

        if(Yii::$app->user->getId() && $this->session->has('currentInstance')){
            $this->bot = new flashWhatsAppBot();
            $this->instanceId = ChatInstancesModel::getInstanceIdByName($this->session->get('currentInstance'));

        }


    }

    public function actionRequest(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            switch ($data['action']){
                case 'login':
                    $this->adminLogin();
                    break;
                case 'addinstance':
                    self::saveInstance($data);
                    break;
                case 'editinstance':
                    self::getInstanceData($data);
                    break;
                case 'delinstance':
                    self::removeInstance($data);
                    break;
                case 'adduser':
                    self::saveUser($data);
                    break;
                case "getBotMessagesByCHatId":
                    $this->getWaBotMessagesById($data);
                    break;
                case "sendMessInCHat":
                    $this->sendMessage($data);
                    break;
                case "getNewMessagesInChat":
                    $this->getNewMessages($data);
                    break;
                case "checkNewMessages":
                    $this->checkNewMessages();
                    break;
                case "getChatInfo":
                    $this->getDialogInfo($data);
                    break;
                case "uploadPhonesList":
                    $this->makeMailing();
                    break;
                case "changeInstance":
                    $this->changeInstance($data);
                    break;

                default:
                    break;

            }
        }
    }

    private function adminLogin(){
        //\flashHelpers::stopA($auth);
        $model = new AjaxLogin();
        $model->getData(Yii::$app->request->post());
        $auth = $model->login();


        if ($auth) {


            $exit['error'] = false;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
            $exit['mess'] = flashAjaxHelpers::returnJson(40);
            echo json_encode($exit);
        }
        else{
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(3);
            echo json_encode($exit);
        }
    }

    private function saveInstance($data){
        
        $instance = json_decode($data['instanceContent']);

        $instanceData = ChatInstancesModel::findOne((['name'=>flashHelpers::translit($instance->name)]));


        if(!$instanceData){

            $instanceData = new ChatInstancesModel();

        }

        $instanceData->link = $instance->apiUrl;
        $instanceData->token = $instance->token;
        $instanceData->instance = $instance->instanceId;
        $instanceData->name = flashHelpers::translit($instance->name);
        $instanceData->display_name = $instance->name;

        try {

            if($instanceData->save()){

                try {
                    $collation = new ChatCollationModel();
                    $collation->inst_name = flashHelpers::translit($instance->name);
                    $collation->user = 1;

                    $collation->save();

                }catch (\Exception $e){
                    $exit['error'] = true;
                    $exit['mess'] = flashAjaxHelpers::returnJson(61);
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                    echo json_encode($exit);
                    exit();
                }


                $exit['error'] = true;
                $exit['mess'] = flashAjaxHelpers::returnJson(62);
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                echo json_encode($exit);
                exit();
            }
        }catch (Exception $e){

            $exit['error'] = true;
            $exit['mess'] = flashAjaxHelpers::returnJson(61);
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            echo json_encode($exit);
            exit();

        }

    }

    private function removeInstance($data){
        $instance = json_decode($data['instanceContent']);

        $instanceData = ChatInstancesModel::findOne(['instance'=>$instance->instanceId]);

        try{
            $res = $instanceData->delete();
            if($res){
                $exit['error'] = false;
                $exit['mess'] = flashAjaxHelpers::returnJson(65);
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                echo json_encode($exit);
                exit();
            }

        }catch (\Exception $e){
            $exit['error'] = true;
            $exit['mess'] = flashAjaxHelpers::returnJson(64);
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            echo json_encode($exit);
            exit();
        }
    }

    private function getInstanceData($data){
        $instanceName = json_decode($data['instanceContent'])->instanceId;
        $instanceData = ChatInstancesModel::getInstanceByName($instanceName);
        if($instanceData){
            $exit['error'] = false;
            $exit['instanceData'] = $instanceData[0];
            echo json_encode($exit);
            exit();

        }else{
            $exit['error'] = true;
            $exit['mess'] = flashAjaxHelpers::returnJson(63);
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            echo json_encode($exit);
            exit();
        }

    }

    private function getWaBotMessagesById($data){

        $messages['messages'] = '';
        $chatId = $data['chatId'];
        if(!preg_match_all('^[7][7]{1}[0-7]{1}[0-8]{1}\d{7}(@c.us)$^', $chatId)) {
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(59);
            echo json_encode($exit);
            exit();
        }
        //flashHelpers::stopA($chatId);
        //flashHelpers::stopA($data        );
        $bot = new flashWhatsAppBot();

        $messages['messages'] = ChatsMessages::getChatMessages($chatId,$this->instanceId);
        $bot->sendReadChat($chatId);

        $messages['messages'] = ($messages['messages']);
        ChatsMessages::updateAll(['isNew'=>'0'],['chatId'=>$chatId, 'instance'=>$this->instanceId]);

        $exit['error'] = false;
        $exit['data'] = $messages;
        echo json_encode($exit);
        exit();
    }

    private function saveUser($data){
        $newData = json_decode($data['userContent']);

        $user = new User();

        $user->username = $newData->userLogin;
        $user->secret = \Yii::$app->security->generatePasswordHash($newData->userPass);
        $user->display_name = $newData->userName;
        $roles = Yii::$app->authManager->getRoles();
        //
        try {
            $res = $user->save();
            if ($res){
                for ($i = 0; $i< count($newData->userInstance); $i++) {
                    $collation = new ChatCollationModel();
                    $collation->inst_name = $newData->userInstance[$i];
                    $collation->user = $user->getId();
                    try {
                        $collation->save();

                        try {
                            $auth = Yii::$app->authManager;
                            $auth->assign(Yii::$app->authManager->getRole(($newData->userRole)),$user->getId());

                            $exit['error'] = false;
                            $exit['mess'] = flashAjaxHelpers::returnJson(69);
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                            echo json_encode($exit);
                            exit();


                        }catch (\Exception $e){

                            $userData = User::findOne(['id'=>$user->getId()]);

                            $userData->delete();

                            $exit['error'] = true;
                            $exit['mess'] = flashAjaxHelpers::returnJson(68);
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                            echo json_encode($exit);
                            exit();
                        }


                    }catch (\Exception $e){
                        $userData = User::findOne(['id'=>$user->getId()]);

                        $userData->delete();

                        $exit['error'] = true;
                        $exit['mess'] = flashAjaxHelpers::returnJson(67);
                        $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                        echo json_encode($exit);
                        exit();
                    }
                }
            }

        }catch (\Exception $e){
            $exit['error'] = true;
            $exit['mess'] = flashAjaxHelpers::returnJson(66);
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(2);
            echo json_encode($exit);
            exit();
        }

    }

    private function getWaBotMessagesByPhone($data){
        $messages['messages'] = '';
        $chatId = $data['chatId'];
        //flashHelpers::stopA($chatId);

        $bot = new flashWhatsAppBot();
        $messages['messages'] = ChatsMessages::getChatMessages($chatId);
        $bot->sendReadChat($chatId);

        $messages['messages'] = ($messages['messages']);
        ChatsMessages::updateAll(['isNew'=>'0'],['chatId'=>$chatId, 'instance'=>$this->instanceId]);

        $exit['error'] = false;
        $exit['data'] = $messages;
        echo json_encode($exit);
        exit();
    }

    private function sendMessage($data){

        if(empty($_FILES)) {
            $sendResult = json_decode($this->bot->sendMessage($data['chatId'], $data['message']));
            //flashHelpers::stopA($sendResult->sent);
            if ($sendResult->sent) {
                $exit['error'] = false;
                echo json_encode($exit);
                exit();
            }
        }
        else{

            for ($i = 0; $i < count($_FILES); $i++){

                $ext = explode('.', $_FILES[$i]['name']);
                //Helpers::stopA($_FILES);
                $fileName = flashHelpers::generateRandString(10).'.'.end($ext);


                try {
                    $res = move_uploaded_file($_FILES[$i]['tmp_name'], Yii::getAlias('@outfiles/') . $fileName);
                    //flashHelpers::stopA($res);
                }catch (\Exception $e){
                    //flashHelpers::stopA($e->getMessage());
                }

                $file = "https://chat.onclinic.kz/images/out/".$fileName;
                //flashHelpers::stopA($file);
                $sendResult = json_decode($this->bot->sendFile($data['chatId'], $data['message'], $file, $_FILES[0]['name']));

                unlink(Yii::getAlias('@outfiles/') . $fileName);
                //flashHelpers::stopA($sendResult->error);
                if (!isset($sendResult->error)) {
                    $exit['error'] = false;
                    echo json_encode($exit);
                    exit();
                }
                else{
                    $exit['error'] = true;
                    $exit['mess'] = $sendResult->error;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                    echo json_encode($exit);
                    exit();
                }

            }
        }
    }

    private function getNewMessages($data){
        //flashHelpers::testA($data);
        if(isset($data['requestBody']['chatId']) && isset($data['requestBody']['lastMessageId']) ){

            $messages['messages'] = ChatsMessages::getNewChatMessages($data['requestBody']['chatId'],$this->instanceId);

            ChatsMessages::updateAll(['isNew'=>'0'],['chatId'=>$data['requestBody']['chatId'], 'instance'=>$this->instanceId]);

            if (count($messages['messages']) != 0) {
                $this->bot->sendReadChat($data['requestBody']['chatId']);
                $exit['error'] = false;
                $exit['data'] = $messages;
                echo json_encode($exit);
                exit();
            }
            else{
                $exit['error'] = false;
                $exit['data'] = "NO MESSAGES (((";
                echo json_encode($exit);
                exit();
            }
        }
        else{
            $exit['error'] = false;
            $exit['data'] = "NO MESSAGES (((";
            echo json_encode($exit);
            exit();
        }
    }

    private function checkNewMessages(){

        $messages['messages'] = ChatsMessages::checkNewMessages($this->instanceId);
        if (count($messages['messages']) != 0) {
            header('Content-Type: application/json');
            $exit['error'] = false;
            $exit['data'] = $messages;
            echo json_encode($exit);
            exit();
        }
        else{
            header('Content-Type: application/json');
            $exit['error'] = false;
            $exit['data'] = "NO MESSAGES (((";
            echo json_encode($exit);
            exit();
        }

    }

    private function getDialogInfo($data){
        $chatInfo = $this->bot->getDialogInfo($data['requestBody']['chatId']);
        if (!empty($chatInfo)) {
            $exit['error'] = false;
            $exit['data'] = $chatInfo;
            echo json_encode($exit);
            exit();
        }
        else{
            $exit['error'] = false;
            $exit['data'] = "NO INFO (((";
            echo json_encode($exit);
            exit();
        }
    }

    private function makeMailing(){


        $res = array();

        for ($i = 0; $i < count($_FILES); $i++){

            $ext = explode('.', $_FILES[$i]['name']);
            //Helpers::stopA($_FILES);
            $file = flashHelpers::generateRandString(10).'.'.end($ext);

            try {
                move_uploaded_file($_FILES[$i]['tmp_name'], Yii::getAlias('@outfiles/') . $file);
                $res[] = Yii::getAlias('@outfiles/') . $file;
                //flashHelpers::stopA($res);
            }catch (\Exception $e){
                //flashHelpers::stopA($e->getMessage());
            }
        }


        $pExcel = IOFactory::load($res[0]);
        foreach ($pExcel->getWorksheetIterator() as $worksheet) {
            // выгружаем данные из объекта в массив
            $tables[] = $worksheet->toArray();
        }
        $data = [];
        for($i = 0; $i < count($tables); $i++) {
            $data[] = $tables[$i];
            //
        }
        $data = json_encode($data);
//flashHelpers::stopA($data);

        $queueNum = Yii::$app->queue->push(new WaMailing(['data' => $data,'instance'=>$this->instanceId]));

        //flashHelpers::stopA($queueNum);
		unlink($res[0]);
		
        $exit['error'] = false;
        $exit['mess'] = flashAjaxHelpers::returnJson(58);
        $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
        echo json_encode($exit);
        exit();
    }

    private function changeInstance($data){
        $session = Yii::$app->session;
        try{
            ChatInstancesModel::getInstanceIdByName($data['instance'])[0]['instance'];
            $session->set('currentInstance', $data['instance']);

            $exit['error'] = false;
            echo json_encode($exit);
            exit();

        }catch (\Exception $e){
            $exit['error'] = true;
            $exit['mess'] = flashAjaxHelpers::returnJson(60);
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(2);
            echo json_encode($exit);
            exit();
        }
    }
}