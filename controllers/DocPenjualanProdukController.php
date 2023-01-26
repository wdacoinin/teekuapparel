<?php

namespace app\controllers;

use yii;
use app\models\DocPenjualanProdukT;
use app\models\DocPenjualanProduk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocPenjualanProdukController implements the CRUD actions for DocPenjualanProdukT model.
 */
class DocPenjualanProdukController extends Controller
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
     * Lists all DocPenjualanProdukT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocPenjualanProduk();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocPenjualanProdukT model.
     * @param int $id_img Id Img
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_img)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_img),
        ]);
    }

    /**
     * Creates a new DocPenjualanProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocPenjualanProdukT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_img' => $model->id_img]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocPenjualanProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_img Id Img
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_img)
    {
        $model = $this->findModel($id_img);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_img' => $model->id_img]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocPenjualanProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_img Id Img
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_img)
    {
        $this->findModel($id_img)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocPenjualanProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_img Id Img
     * @return DocPenjualanProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_img)
    {
        if (($model = DocPenjualanProdukT::findOne($id_img)) !== null) {
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
