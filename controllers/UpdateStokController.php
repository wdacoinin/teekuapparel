<?php

namespace app\controllers;

use yii;
use app\models\PembelianBahan;
use app\models\PembelianBahanT;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

class UpdateStokController extends \yii\web\Controller
{
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
     * Updates an existing PembelianBahanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pembelian_bahan Pembelian Bahan
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pembelian_bahan)
    {
        $this->layout = 'kosong';
        //$pembelian_bahan = $id;
        $model = $this->findModel($pembelian_bahan);

        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $model->jml_now = $model->jml_now;
            $check = PembelianBahanT::find()->select('pembelian_jml')->where(['pembelian_bahan' => $pembelian_bahan])->asArray()->one();
                if($check['pembelian_jml'] >= $model->jml_now){
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Data berhasil disimpan!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di input');
                    }
                }else{
                    Yii::$app->session->setFlash('warning', 'Qty update melebihi qty pembelian!');
                }
            return $this->redirect(['index']);
        } else {
            
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
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
