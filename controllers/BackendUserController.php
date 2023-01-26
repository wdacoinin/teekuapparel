<?php

namespace app\controllers;

use yii;
use app\models\BackendUser;
use app\models\SBackendUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\widgets\ActiveForm;

/**
 * BackendUserController implements the CRUD actions for BackendUser model.
 */
class BackendUserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new SBackendUser();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BackendUser model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single $username $password.
     */
    public function actionViewmobile()
    {
        $model = new BackendUser();

            if (isset($_POST['username']) &&  $_POST['username'] !== '' && $_POST['password'] !== '') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                //return ActiveForm::validate($model);

                $model = (new \yii\db\Query())
                ->select([
                'user.id', 
                'user.password', 
                'user.divisi', 
                'user.nama', 
                'divisi.nama AS nama_divisi'])
                ->from('user')
                ->join('LEFT JOIN', 'divisi', 'user.divisi = divisi.divisi')
                ->where(['user.username' => $username])
                ->all();
                $hash = $model[0]['password'];
                //echo json_encode($model);
                
                if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {
                    // password is good
                    return $this->renderAjax('viewmobile', [
                        'model' => $model,
                    ]);
                }else{
                    $model = null;
                    return $this->renderAjax('viewmobile', [
                        'model' => $model,
                    ]);
                }
            }else{
                $model = null;
                return $this->renderAjax('viewmobile', [
                    'model' => $model,
                ]);
            }
        
    }

    /**
     * Creates a new BackendUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new BackendUser();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $checkname = BackendUser::find()->where(['username' => $model->username])->count();

                if($checkname > 0){
                    Yii::$app->session->setFlash('warning', 'Username sudah ada di database, beri pembeda!');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }else{
                    //$model->password = setPassword($model->password);
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                    $model->save();
                
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing BackendUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChange($id)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($id);
        $model->password = '';
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                    $model->save();
            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->renderAjax('change', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing BackendUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BackendUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BackendUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return BackendUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BackendUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /*public function beforeAction($action){

        if (Yii::$app->user->isGuest){
            return $this->redirect(['site/login'])->send();  // login path
        }
    }*/
}
