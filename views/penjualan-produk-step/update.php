<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukStepT */

$this->title = 'Update Order Produk Tracking: ' . $model->penjualan_produk_step;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Order Tracking', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->penjualan_produk_step, 'url' => ['view', 'penjualan_produk_step' => $model->penjualan_produk_step]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
