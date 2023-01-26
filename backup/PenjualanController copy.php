<?php

namespace app\controllers;

use app\models\PenjualanT;
use app\models\Penjualan;
use app\models\PenjualanProdukT;
use app\models\PenjualanProduk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenjualanController implements the CRUD actions for PenjualanT model.
 */
class PenjualanController extends Controller
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
     * Lists all PenjualanT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Penjualan();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanT model.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan),
        ]);
    }

    /**
     * Creates a new PenjualanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'penjualan' => $model->penjualan]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PenjualanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan);
        $searchModel = new PenjualanProduk();
        $Penjualan = PenjualanT::findOne($model->penjualan);
        //$PenjualanProduks = $Penjualan->penjualanProduks;
        $PenjualanProduks = $Penjualan->getpenjualanProduks()->orderBy('penjualan_produk')->all();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'penjualan' => $model->penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'PenjualanProduks' => $dataProvider,
        ]);
    }

    /**
     * Tabel Penjualan Produk.
     * @return mixed
     */
    public function actionProduk($penjualan)
    {
        //$model = new PenjualanT(); 
        $model = Penjualan::findOne($penjualan);
        //$PenjualanProduks = $Penjualan->penjualanProduks;
        $PenjualanProduks = $model->penjualanProduks;
        //$searchModel = PenjualanProduk::findOne($penjualan);
        //$dataProvider = $searchModel->search($this->request->queryParams);

        
        echo var_dump($model->penjualanProduks);
    }

    /**
     * Deletes an existing PenjualanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan Penjualan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan)
    {
        $this->findModel($penjualan)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PenjualanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan Penjualan
     * @return PenjualanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan)
    {
        if (($model = PenjualanT::findOne($penjualan)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
