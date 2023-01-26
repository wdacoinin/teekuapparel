<?php

namespace app\controllers;

use yii;
use app\models\GlobalStok;

class GlobalStokController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new GlobalStok();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
