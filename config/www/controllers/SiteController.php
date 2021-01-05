<?php

namespace app\controllers;

use app\models\ChatCollationModel;
use app\models\ChatInstancesModel;
use app\models\LoginForm;
use app\models\ChatsInfo;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * @var mixed|string
     */

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['chatOperator'],

                    ],

                    [
                        'allow' => true,
                        'actions' => ['login', 'error'],
                        'roles' => ['?','@'], // " ? " for guest user
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                    'login' => ['post','get'],
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


        $instanceCity = ChatCollationModel::GetCitiesForOperator(Yii::$app->user->getId());
        $session = Yii::$app->session;

        //\flashHelpers::stopA(Yii::$app->user->can('instanceAdmin'));

        if(count($instanceCity) == 1){
            $session->set('currentInstance', $instanceCity[0]['inst_name']);
            $instanceId = ChatInstancesModel::getInstanceIdByName($instanceCity[0]['inst_name']);
            $instanceName = ChatInstancesModel::getInstanceDisplayNameByName($instanceCity[0]['inst_name']);

        }
        else{
            if($session->has('currentInstance')){
                $instanceId = ChatInstancesModel::getInstanceIdByName($session->get('currentInstance'));
                $instanceName = ChatInstancesModel::getInstanceDisplayName($session->get('currentInstance'));
            }
            else {
                $session->set('currentInstance', $instanceCity[0]['inst_name']);
                $instanceId = ChatInstancesModel::getInstanceIdByName($instanceCity[0]['inst_name']);
                $instanceName = ChatInstancesModel::getInstanceDisplayName($instanceCity[0]['inst_name']);
            }
        }
        //\flashHelpers::stopA($instanceId);

        $dialogs = ChatsInfo::getChats($instanceId);
        $username = Yii::$app->user->identity->display_name;
        $currentInstance = $session->get("currentInstance");


        $page['page_content'] = array_reverse($dialogs);
        //\flashHelpers::stopA($currentInstance);
        return $this->render('main.twig', compact('page', 'username', 'instanceName', 'currentInstance'));

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(){

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

	public function actionError(){

        \flashHelpers::stopA('ERROR');
    }
}
