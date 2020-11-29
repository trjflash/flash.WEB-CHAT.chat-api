<?php

namespace app\controllers;

use app\components\flash\ChatApi;
use app\components\flash\flashWhatsAppBot;
use app\components\flash\whatsAppBot;
use app\models\LoginForm;
use app\models\WaBotLastMessageModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\MainPages;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/site/error.twig'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {


        $this->view->title = "Чаты";

//        $bot = new ChatApi('oycyoxh358s1yvd8');
//        $res = $bot->getDialogs();
//
//        \flashHelpers::stopA($res);

        $bot = new flashWhatsAppBot();
        $dialogs = $bot->sendRequestGet("dialogs");
        //\flashHelpers::stopA($dialogs);
        $page['page_content'] = $dialogs;
//        for ($i=0; $i < 30; $i++){
//            $dialogs->dialogs[$i]->lastMessage = $bot->getLastChatMessage($dialogs->dialogs[$i]->id);
//        }


        //\flashHelpers::stopA($dialogs);

        return $this->render('main.twig', compact('page'));

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('authForm.twig', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {

        $data_string = 'code=0AY0e-g4tMDCU8JusgGZ414Phwn56GYpSxtGeiuEN2a1ZtxZNSzXq-RgIB4IKUrvujmVebQ&
                        33949710378-gsqgv9pkiuf7u01jclsmn89c25po0fb3.apps.googleusercontent.com&
                        client_secret=8vE-4msMjGfygtFsqzAFXIqv&
                        redirect_uri=chat.onclinic.kz&
                        grant_type=authorization_code';
        //\flashHelpers::stopA($data);
        $curl = curl_init('www.googleapis.com/oauth2/v4/token');

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        // Принимаем в виде массива. (false - в виде объекта)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . strlen($data_string))
        );
        //\flashHelpers::stopA($curl);
        $result = curl_exec($curl);
        curl_close($curl);
        //\flashHelpers::stopA($result);
    }
}
