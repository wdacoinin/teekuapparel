<?php

namespace app\controllers;

use yii;
use app\models\Order;
use app\models\Orderagen;
use app\models\Orderagendone;
use app\models\Orderbatal;
use app\models\Orderdesainer;
use app\models\Orderlunas;
use app\models\Orderselesai;
use app\models\Ordertagihan;
use app\models\PenjualanProdukT;
use app\models\PenjualanStepT;
use app\models\PenjualanT;
use yii\widgets\ActiveForm;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';

        if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 3 || Yii::$app->user->identity->divisi == 5){
            $sm = new Order();
            $dp = $sm->search($this->request->queryParams);
            return $this->render('orderadmin', [
                'sm' => $sm,
                'dp' => $dp,
            ]);

        }else if(Yii::$app->user->identity->divisi == 4){
            $sm = new Orderagen();
            $agen = Yii::$app->user->identity->id;
            $dp = $sm->search($this->request->queryParams, $agen);
            return $this->render('orderadmin', [
                'sm' => $sm,
                'dp' => $dp,
            ]);
        }else{
            $sm = new Order();
            $dp = $sm->search($this->request->queryParams);
            return $this->render('orderproduksi', [
                'sm' => $sm,
                'dp' => $dp,
            ]);
        }
    }

    public function actionOrderselesai()
    {
        $this->layout = 'kosong';
        $sm = new Orderselesai();
        $dp = $sm->search($this->request->queryParams);
        return $this->render('orderadmin', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
    }

    public function actionOrderlunas()
    {
        $this->layout = 'kosong';
        $sm = new Orderlunas();
        $dp = $sm->search($this->request->queryParams);
        return $this->render('orderlunas', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
    }

    public function actionOrdertagihan()
    {
        $this->layout = 'kosong';
        $sm = new Ordertagihan();
        $dp = $sm->search($this->request->queryParams);
        return $this->render('ordertagihan', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
    }

    public function actionOrderagendone()
    {
        $this->layout = 'kosong';
        $agen = Yii::$app->user->identity->id;
        $sm = new Orderagendone();
        $dp = $sm->search($this->request->queryParams, $agen);
        return $this->render('orderadmin', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
    }

    public function actionOrderdesainer()
    {
        $this->layout = 'kosong';
        $desainer = Yii::$app->user->identity->id;
        $sm = new Orderdesainer();
        $dp = $sm->search($this->request->queryParams, $desainer);
        return $this->render('orderdesainer', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
    }

    public function actionBatalorder()
    {
        $this->layout = 'kosong';
        $sm = new Orderbatal();
        $dp = $sm->search($this->request->queryParams);
        return $this->render('batalorder', [
            'sm' => $sm,
            'dp' => $dp,
        ]);
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
        $model = PenjualanT::findOne($penjualan);
        $model->penjualan_status = 'Batal Order';

        if($model->save()){
            Yii::$app->session->setFlash('success', 'Order dibatalkan.');
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('warning', 'Batal order gagal!');
            return $this->redirect(['index']);

        }

        /* $check = PenjualanProdukT::find()->where(['penjualan' => $penjualan])->count();

        if($check > 0){
            Yii::$app->session->setFlash('warning', 'Hapus dulu semua data di dalam penjualan');
            return $this->redirect(['index']);
        }else{
            $model->delete();
            Yii::$app->session->setFlash('success', 'Data dihapus');
            return $this->redirect(['index']);
        } */
    }

    public function actionUpdatetrack($penjualan, $penjualan_step)
    {
        $this->layout = 'kosong';
        //$model = $this->findModel($penjualan);
        $selectedStep = PenjualanStepT::findOne($penjualan_step);

        $model = new PenjualanStepT();
        $model->penjualan = $penjualan;

        $modPP = PenjualanProdukT::find()->select('SUM(penjualan_jml) AS total')->where(['penjualan' => $penjualan])->asArray()->one();
        if($modPP != null){
            $qty = $modPP['total'];
        }else{
            $qty = 1;
        }
        $model->jml = $qty;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post())) {

                $model->user = Yii::$app->user->identity->id;
                $model->start = date('Y-m-d H:i:s');

                $selectedStep->end = date('Y-m-d H:i:s');
                if($selectedStep->save()){
                    $model->save();
                }
                return $this->redirect(['order/orderselesai']);

            }
            //return $this->redirect(Url::to(['tracking-order/index']));
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'selectedStep' => $selectedStep,
        ]);
    }

    /*public function beforeAction($action){

        if (Yii::$app->user->isGuest){
            return $this->redirect(['site/login'])->send();  // login path
        }
    }*/

}
