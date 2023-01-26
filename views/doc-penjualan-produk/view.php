<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DocPenjualanProdukT */

$this->title = $model->id_img;
$this->params['breadcrumbs'][] = ['label' => 'Doc Penjualan Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="doc-penjualan-produk-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_img' => $model->id_img], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_img' => $model->id_img], [
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
            'id_img',
            'penjualan',
            'Nama_Foto',
            'type',
            'size',
            'url:url',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
