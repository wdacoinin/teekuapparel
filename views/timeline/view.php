<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukStepT */

$this->title = $model->penjualan_produk_step;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Produk Step Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'penjualan_produk_step' => $model->penjualan_produk_step], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'penjualan_produk_step' => $model->penjualan_produk_step], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'penjualan_produk_step',
            'penjualan_produk',
            'faktur',
            'divisi',
            'start',
            'end',
            'user',
        ],
    ]) ?>

</div>
