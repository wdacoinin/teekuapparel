<?php

namespace app\controllers;

use Yii;
use app\models\PenjualanProdukStepT;
use app\models\PenjualanProdukStep;
use app\models\PenjualanProduk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenjualanProdukStepController implements the CRUD actions for PenjualanProdukStepT model.
 */
class PenjualanProdukStepController extends Controller
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
     * Lists all PenjualanProdukStepT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PenjualanProdukStep();
        $dataProvider = $searchModel->search($this->request->queryParams, Yii::$app->user->identity->divisi);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanProdukStepT model.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan_produk_step)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan_produk_step),
        ]);
    }

    /**
     * Creates a new PenjualanProdukStepT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukStepT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Traking berhasil Diupdate!');
            }
            return $this->redirect('tracking-order/index');
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PenjualanProdukStepT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan_produk_step)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan_produk_step);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'penjualan_produk_step' => $model->penjualan_produk_step]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PenjualanProdukStepT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan_produk_step)
    {
        $this->findModel($penjualan_produk_step)->delete();

        return $this->redirect(['index']);
    }

     /**
     * Deletes an existing PenjualanProdukStepT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk Penjualan Produk Step
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCheckqty($penjualan_produk)
    {
        
        $row = PenjualanProduk::findOne($penjualan_produk);

        /* $data = array(
            'penjualan_jml' => $row->penjualan_jml
        ); */

        return json_encode($row->penjualan_jml);
    }

    /**
     * Finds the PenjualanProdukStepT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan_produk_step Penjualan Produk Step
     * @return PenjualanProdukStepT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan_produk_step)
    {
        if (($model = PenjualanProdukStepT::findOne($penjualan_produk_step)) !== null) {
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
