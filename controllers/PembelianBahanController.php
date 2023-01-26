<?php

namespace app\controllers;

use Yii;
use app\models\PembelianBahanT;
use app\models\PembelianBahan;
use app\models\BahanBaku;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * PembelianBahanController implements the CRUD actions for PembelianBahanT model.
 */
class PembelianBahanController extends Controller
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
     * Lists all PembelianBahanT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PembelianBahan();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PembelianBahanT model.
     * @param int $pembelian_bahan Pembelian Bahan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pembelian_bahan)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($pembelian_bahan),
        ]);
    }

    /**
     * Creates a new PembelianBahanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pembelian)
    {
        $this->layout = 'kosong';
        $model = new PembelianBahanT();
        
        $model->pembelian = $pembelian;
        $model->jml_now = 0;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $model->jml_now = $model->pembelian_jml;
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan!');
            }
            else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di input');
            }
            return $this->redirect(['pembelian/update', 'pembelian' => $pembelian]);
        } else {
            
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PembelianBahanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pembelian_bahan Pembelian Bahan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pembelian_bahan)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($pembelian_bahan);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pembelian_bahan' => $model->pembelian_bahan]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PembelianBahanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pembelian_bahan Pembelian Bahan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pembelian_bahan)
    {
        $this->findModel($pembelian_bahan)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PembelianBahanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $pembelian_bahan Pembelian Bahan
     * @return PembelianBahanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pembelian_bahan)
    {
        if (($model = PembelianBahanT::findOne($pembelian_bahan)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
