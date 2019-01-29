<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\User;
use app\models\Comment;
use app\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;



/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','monitoring','mytask','myrequest'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['@'], // '@' All logged in users / or your access role e.g. 'admin', 'user'
                    ],
                    [
                        'allow' => false, // Do not have access
                        'roles'=>['?'], // Guests '?'
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andWhere('customers.status = 10');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyrequest(){
        $session = Yii::$app->session;
        $session->open();

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_from'=>$session['user']['username']]);
        $session['task'] = "myrequest";

        return $this->render('myrequest', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMytask(){
        $session = Yii::$app->session;
        $session->open();

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_to'=>$session['user']['username']]);
        $session['task'] = "mytask";

        return $this->render('mytask', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDone($id){
        $task = Task::findOne($id);
        $task->status = 'done';
        $task->update_at = date('m-d-Y H:i:s');
        $task->save();

//        return $this->redirect(['task/mytask']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionApprove($id){
        $model = Task::findOne($id);
        $model->status = 'progress';
        $model->update_at = date('m-d-Y H:i:s');
        $model->save();

//        return $this->redirect(['task/mytask']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionReject($id) {
        $model = Task::findOne($id);
        $model->status = 'rejected';
        $model->update_at = date('m-d-Y H:i:s');
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRequest($id) {
        $model = Task::findOne($id);
        $model->status = 'pending';
        $model->update_at = date('m-d-Y H:i:s');
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate2() {
        $data = Yii::$app->request->post();

//        print_r($data['id']);
        echo \Yii::$app->view->renderFile('@app/views/task/update2.php',array('id'=>$data['id']));

    }

    public function actionUpdatetask(){
        $session = Yii::$app->session;
        $session->open();

        $data = Yii::$app->request->post();
        $request = Yii::$app->request;

        $model = new Task();
        $model = Task::findOne($data['idd']);
        $model->date_from = $data['date_from'];
        $model->date_to = $data['date_to'];
        $model->user_to = $data['Task']['user_to'];
        $model->user_from = $session['user']['username'];
        $model->remark = $data['Task']['remark'];
        $model->status = $data['Task']['status'];
        $model->description = $data['Task']['description'];
        $model->update_at = date('m-d-Y H:i:s');
        $model->create_at = date('m-d-Y H:i:s');

        print_r($model);
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCreate2(){
        $session = Yii::$app->session;
        $session->open();

        $request = Yii::$app->request;
        $model = new Task();
        $data = Yii::$app->request->post();
//        print_r($data);
//        echo $data['Task']['date_from'];
//        echo $data['remark'];
        $model->date_from = $data['Task']['date_from'];
        $model->date_to = $data['Task']['date_to'];
//        print_r($data['_mode']); exit;
        if ($data['_mode'] == 'task') {
            $model->user_to = $session['user']['username'];
            if (isset($data['user_value'])) {
                $model->user_from = $data['user_value'];
            }
        }
        else {
            $model->user_from = $session['user']['username'];
            if (isset($data['user_value'])) {
                $model->user_to = $data['user_value'];
            }

        }

        $model->remark = $data['Task']['remark'];
        $model->status = $data['Task']['status'];
        $model->description = $data['Task']['description'];
        $model->update_at = date('m-d-Y H:i:s');
        $model->create_at = date('m-d-Y H:i:s');


            if($model->validate()) {
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            }
            else {
                echo "fail";
            }

    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        $session->open();
        $request = Yii::$app->request;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($session['task'] == 'myrequest') {
                if ($model->status == 'pending') {
                    return [
                        'title' => "Task #" . $id,
                        'content' => $this->renderAjax('view', [
                            'model' => $this->findModel($id),
                        ]),
                        'footer' =>
                            Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']).
                        Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"])
                    ];
                }
                else {
                    return [
                        'title' => "Task #" . $id,
                        'content' => $this->renderAjax('view', [
                            'model' => $this->findModel($id),
                        ]),
                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"])
                    ];
                }
            }
            else if($session['task'] == 'mytask') {
                return [
                    'title' => "Task #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"])
                ];
            }
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Task model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;
        $session->open();

        if ($session['task'] == 'myrequest') {
            $mode = 'Create New Request';
        }
        else {
            $mode = 'Create New Task';
        }

        $request = Yii::$app->request;
        $model = new Task();
        $model->create_at = date('m-d-Y H:i:s');
        $model->update_at = date('m-d-Y H:i:s');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $mode,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=>Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"]).
                        Html::button('Close',['class'=>'btn btn-default','data-dismiss'=>"modal"])


                ];
            }else if($model->load($request->post()) && $model->save()){
//                if($session['task'] == 'myrequest') {
//                    return $this->redirect(['myrequest']);
//                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $mode,
                    'content'=>'<span class="text-success">Create Task success</span>',
                    'footer'=>Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote']).
                        Html::button('Close',['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
                ];


            }else{
                return [
                    'title'=> $mode,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=>Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"]).
                        Html::button('Close',['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Task model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Task #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=>Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"]).
                        Html::button('Close',['class'=>'btn btn-default','data-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Task #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=>Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote']).
                        Html::button('Close',['class'=>'btn btn-default','data-dismiss'=>"modal"])
                ];
            }else{
                return [
                    'title'=> "Update Task #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=>Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"]).
                        Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Task model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $session = Yii::$app->session;
        $session->open();
        $request = Yii::$app->request;
        Comment::deleteAll('task_id = :id', [':id' => $id]);

        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
//            if($session['task'] == 'myrequest') {
//                return $this->redirect(['myrequest']);
//            }
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
//            return $this->redirect(['myrequest']);
        }else{
            /*
            *   Process for non-ajax request
            */
//            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
//            return $this->redirect(['myrequest']);
//            return $this->redirect(['myrequest']);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Delete multiple existing Task model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }
    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMonitoring(){
        $user_data = User::find()->select('nik')->all();
        return $this->render('monitoring',array(
            'user_data' => $user_data,
        ));
    }

    public function actionSearchnik(){
        $this->layout = false;
        $data = Yii::$app->request->post();
        $nik = $data['nik'];

        $data_done = Task::find()->where(['user_to' => $nik])->andWhere(['status' => 'done'])->orderBy(['status' => SORT_ASC])->all();
        $data_progress = Task::find()->where(['user_to' => $nik])->andWhere(['status' => 'progress'])->orderBy(['status' => SORT_ASC])->all();

        $mystatus[0] = Task::find()->where(['user_to' => $nik])->andWhere(['status' => 'done'])->count();
        $mystatus[1] = Task::find()->where(['user_to' => $nik])->andWhere(['status' => 'progress'])->count();

//        print_r($data_task);
        return $this->render('table_monitoring',array(
            'data_done' => $data_done,
            'data_progress' => $data_progress,
            'mystatus' => $mystatus,
            'nik' => $nik
        ));
    }

    public function actionComment() {
        $this->layout = false;
        $data = Yii::$app->request->post();
        $data_comment = Comment::find()->where(['task_id' => $data['id']])->all();
        $data_task = Task::find()->where(['id' => $data['id']])->one();

        return $this->render('comment',array(
            'id' => $data['id'],
            'data_comment' => $data_comment,
            'data_task' => $data_task,
        ));
    }

    public function actionSubmitcomment(){
        $this->layout = false;
        $session = Yii::$app->session;
        $session->open();

        $model = new Comment();
        $data = Yii::$app->request->post();
//        print_r($data);
//        print_r($_FILES);

        $model->user_comment = $session['user']['username'];
        $model->task_id = $data['id'];
        $model->comments = $data['comment'];
//        $model->attachments = '';
        $model->created_at = date('m-d-Y H:i:s');
        $file = UploadedFile::getInstanceByName('attach');

        if(isset($file)) {
            $path = Yii::getAlias('@webroot').'/uploads/' . $session['user']['username'] . $file->baseName.'.'.$file->extension;
            if (file_exists($path)) {
                $new_name = Yii::getAlias('@webroot').'/uploads/' . $session['user']['username'] . $file->baseName.'.'.$file->extension;

                $counter = 1;
                while(file_exists($new_name)) {
                    $new_name = Yii::getAlias('@webroot').'/uploads/' . $session['user']['username'] . $counter . $file->baseName . '.' . $file->extension;
                    $real_name = $session['user']['username'] . $counter . $file->baseName . '.' . $file->extension;
                    $counter++;
                };
            }
            else {
                $real_name = $session['user']['username'] . $file->baseName . '.' . $file->extension;
            }

            $model->attachments = $real_name;

            if($model->save()){
                $file->saveAs('uploads/' . $real_name);
            }
        }

        else {
            $model->save();
        }

        $data_comment = Comment::find()->where(['task_id' => $data['id']])->all();
        $data_task = Task::find()->where(['id' => $data['id']])->one();
        return $this->render('comment',array(
            'id' => $data['id'],
            'data_comment' => $data_comment,
            'data_task' => $data_task,
        ));

    }

    public function actionUnduh($id)
    {
        $download = Comment::findOne($id);
        $path = Yii::getAlias('@webroot').'/uploads/'.$download->attachments;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }
    }
}