<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukT */

$this->title = 'Update Penjualan Produk';
$this->params['breadcrumbs'][] = ['label' => $faktur, 'url' => ['penjualan/update', 'penjualan' => $model->penjualan]];
//$this->params['breadcrumbs'][] = ['label' => $model->penjualan_produk, 'url' => ['view', 'penjualan_produk' => $model->penjualan_produk]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row p-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'searchModel1' => $searchModel1,
        'dataProvider1' => $dataProvider1,
    ]) ?>

</div>
