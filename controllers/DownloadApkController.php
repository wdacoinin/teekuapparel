<?php

namespace app\controllers;

class DownloadApkController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'kosong';
        return $this->render('index');
    }

}
