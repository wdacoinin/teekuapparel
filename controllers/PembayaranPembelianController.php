<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\Penjualan;
use app\models\AkunLogT;
use app\models\AkunLog;
use app\models\PembayaranPembelian;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class PembayaranPembelianController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PembayaranPembelian();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*public function beforeAction($action){

        if (Yii::$app->user->isGuest){
            return $this->redirect(['site/login'])->send();  // login path
        }
    }*/

}
