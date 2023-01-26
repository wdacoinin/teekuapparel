<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\Penjualan;
use app\models\AkunLogT;
use app\models\AkunLog;
use app\models\PembayaranPenjualan;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class PembayaranPenjualanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PembayaranPenjualan();
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
