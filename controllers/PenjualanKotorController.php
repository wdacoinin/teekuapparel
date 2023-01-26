<?php

namespace app\controllers;
use app\models\PenjualanKotor;

class PenjualanKotorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PenjualanKotor();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
