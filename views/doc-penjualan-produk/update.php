<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocPenjualanProdukT */

$this->title = 'Update Doc Penjualan Produk T: ' . $model->id_img;
$this->params['breadcrumbs'][] = ['label' => 'Doc Penjualan Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_img, 'url' => ['view', 'id_img' => $model->id_img]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doc-penjualan-produk-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
