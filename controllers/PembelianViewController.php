<?php

namespace app\controllers;

use app\models\PembelianBahanT;
use app\models\PembelianT;
use yii;
use app\models\PembelianView;

class PembelianViewController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $sm = new PembelianView();
        $dp = $sm->search($this->request->queryParams);

        return $this->render('index', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
    }
    
    /**
     * Deletes an existing PenjualanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pembelian Pembelian
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pembelian)
    {
        $model = PembelianT::findOne($pembelian);

        $check = PembelianBahanT::find()->where(['pembelian' => $pembelian])->count();

        if($check > 0){
            Yii::$app->session->setFlash('warning', 'Hapus dulu semua data di dalam pembelian');
            return $this->redirect(['index']);
        }else{
            $model->delete();
            Yii::$app->session->setFlash('success', 'Data dihapus');
            return $this->redirect(['index']);
        }
    }

}
