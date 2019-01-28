<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\rbac\DbManager;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Task;


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
                    'only' => ['index','logout','client-create','dashboard'], // your own action which permission the login
                    'rules' => [
                        [
                            'actions' => ['index','logout','client-create','dashboard'], // your own action which permission the login
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function($rule, $action) {
                     Yii::$app->response->redirect(['site/login']); 
                     },
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
//        return $this->render('index');
        return $this->redirect(['site/dashboard']);

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

        $session = Yii::$app->session;
        $session->open();

        if(!$session['user']['login']) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $userdata = User::find()->where(['id'=>Yii::$app->user->getId()])->asArray()->all();
                // print_r($userdata);
                $new_date = date('d M Y h:i A');
                $session['user'] = array(
                        "login" => true,
                        "id"=>$userdata[0]['id'],
                        "username"=>$userdata[0]['nik'],
                        "role"=>$userdata[0]['role'],
                        "last_login"=>$new_date,
                    );

                if ($userdata[0]['role'] == 'admin') {
                    if (\Yii::$app->authManager->getRolesByUser($userdata[0]['id']) == NULL) {
                        $auth = new DbManager;
                        $auth->init();
                        $role = $auth->getRole('admin');
                        $auth->assign($role, $userdata[0]['id']);
                    }
                }
                else {
                    if (\Yii::$app->authManager->getRolesByUser($userdata[0]['id']) == NULL) {
                        $auth = new DbManager;
                        $auth->init();
                        $role = $auth->getRole('user');
                        $auth->assign($role, $userdata[0]['id']);
                    }
                }

                return $this->redirect(['dashboard']);
            }

            else {
                return $this->render('login', [
                'model' => $model,
                ]);
            }
        }

        else {
            return $this->goBack();
        }
        $session->close();
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
    public function actionDashboard()
    {
        $session = Yii::$app->session;
        $session->open();

        //count my task
        $mytask[0] = Task::find()->where(['user_to' => $session['user']['username']])->andWhere(['status' => 'pending'])->count();
        $mytask[1] = Task::find()->where(['user_to' => $session['user']['username']])->andWhere(['status' => 'rejected'])->count();
        $mytask[2] = Task::find()->where(['user_to' => $session['user']['username']])->andWhere(['status' => 'progress'])->count();
        $mytask[3] = Task::find()->where(['user_to' => $session['user']['username']])->andWhere(['status' => 'done'])->count();

        //count my request
        $myrequest[0] = Task::find()->where(['user_from' => $session['user']['username']])->andWhere(['status' => 'pending'])->count();
        $myrequest[1] = Task::find()->where(['user_from' => $session['user']['username']])->andWhere(['status' => 'rejected'])->count();
        $myrequest[2] = Task::find()->where(['user_from' => $session['user']['username']])->andWhere(['status' => 'progress'])->count();
        $myrequest[3] = Task::find()->where(['user_from' => $session['user']['username']])->andWhere(['status' => 'done'])->count();

        $data = Task::find()->where(['user_from' => $session['user']['username']])->orWhere(['user_to' => $session['user']['username']])->limit(10)->orderBy(['update_at' => SORT_DESC])->all();
//        return $this->render('dashboard');

        return $this->render('dashboard',array(
            'data'=>$data,
            'mytask'=>$mytask,
            'myrequest'=>$myrequest,
        ));
    }

    public function actionUserguide(){
//        $download = Comment::findOne($id);
        $path = Yii::getAlias('@webroot').'/uploads/'.'user_guide.pdf';

        return Yii::$app->response->sendFile($path);
    }
}