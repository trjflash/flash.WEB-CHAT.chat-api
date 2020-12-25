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
                        'actions' => ['login', 'error'],
                        'allow' => true,
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
        $instanceId = '';
        $instanceName =  '';

        //\flashHelpers::stopA(Yii::$app->user->can('instanceAdmin'));

        if(count($instanceCity) == 1){
            $instanceId = ChatInstancesModel::getInstanceIdByName($instanceCity[0]['inst_name'])[0]['instance'];
            $instanceName = ChatInstancesModel::getInstanceDisplayNameByName($instanceCity[0]['inst_name']);



        }
        else{

            $session = Yii::$app->session;
            $session->set('currentInstance', $instanceCity[0]['inst_name']);
            $instanceId = ChatInstancesModel::getInstanceIdByName($instanceCity[0]['inst_name'])[0]['instance'];
            $instanceName = ChatInstancesModel::getInstanceDisplayName($instanceCity[0]['inst_name']);

        }
        //\flashHelpers::stopA($instanceId);

        $dialogs = ChatsInfo::getChats($instanceId);
        $username = Yii::$app->user->identity->display_name;


        $page['page_content'] = array_reverse($dialogs);
        //\flashHelpers::stopA($page);
        return $this->render('main.twig', compact('page', 'username', 'instanceName'));

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

        \flashHelpers::stopA(Yii::$app->security->generatePasswordHash(1234));
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
    public function actionAbout(){
		/*
		$code = "4/0AY0e-g56uq8XFAlifCLlGqbnbB5jDxamIWyTKb76Iw2Mdn5s9GVTjrZuHSKfthesPZAcag";
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://www.google.com/m8/feeds/contacts/trjflash@gmail.com/full?access_token=ya29.a0AfH6SMDrjm_zbYPjGLg4pigVXBV5jCmNkY_mbi-xcqBgRE77CAvubgBulCiih5bhgucrkUV69a3Ag1r9ubDTDrltZU3ENYbheOnYmaDVgMZVWujAMwwbxQRJOr5K1RTNJ6cXPor2J1vEHshV_g6ec7pARjdY9n-CKohDHWJlMTA',
			CURLOPT_VERBOSE => true,

			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 30,

		));

        $result = curl_exec($curl);
        curl_close($curl);

        \flashHelpers::stopA($result);*/
	}
	public function actionError(){
        \flashHelpers::stopA('ERROR');
    }
}
