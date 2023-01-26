<?php

namespace app\controllers;

use yii;
use app\models\KonsumenT;
use app\models\Konsumen;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KonsumenController implements the CRUD actions for KonsumenT model.
 */
class KonsumenController extends Controller
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
     * Lists all KonsumenT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Konsumen();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KonsumenT model.
     * @param int $konsumen Konsumen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($konsumen)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($konsumen),
        ]);
    }

    /**
     * Creates a new KonsumenT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new KonsumenT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $check = Konsumen::find()->where(['konsumen_nama' => $model->konsumen_nama])->count();
                if($check > 0){
                    Yii::$app->session->setFlash('warning', 'Nama konsumen sudah ada!');
                    return $this->render('create', ['model' => $model]);
                }else{
                    $model->save();
                    return $this->redirect(['view', 'konsumen' => $model->konsumen]);
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
     * Updates an existing KonsumenT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $konsumen Konsumen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($konsumen)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($konsumen);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'konsumen' => $model->konsumen]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KonsumenT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $konsumen Konsumen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($konsumen)
    {
        $this->findModel($konsumen)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KonsumenT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $konsumen Konsumen
     * @return KonsumenT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($konsumen)
    {
        if (($model = KonsumenT::findOne($konsumen)) !== null) {
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
