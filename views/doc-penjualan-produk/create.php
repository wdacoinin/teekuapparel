<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocPenjualanProdukT */

$this->title = 'Create Doc Penjualan Produk T';
$this->params['breadcrumbs'][] = ['label' => 'Doc Penjualan Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-penjualan-produk-t-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
