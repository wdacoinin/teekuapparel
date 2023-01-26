<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = 'Update Order: ' . $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['order/index']];
/* if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 3){
    $this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['order/index']];
}else{
    $this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['index']];
} */
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
        'modPenjualanProduk' => $modPenjualanProduk,
        'PenjualanProduk' => $PenjualanProduk,
        'DocPenjualanProduk' => $DocPenjualanProduk,
        'DocPenjualanProdukD' => $DocPenjualanProdukD,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
