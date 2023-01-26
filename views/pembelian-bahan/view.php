<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianBahanT */

$this->title = $model->pembelian_bahan;
$this->params['breadcrumbs'][] = ['label' => 'Pembelian Bahan Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pembelian-bahan-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pembelian_bahan' => $model->pembelian_bahan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pembelian_bahan' => $model->pembelian_bahan], [
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
            'pembelian_bahan',
            'pembelian',
            'bahan_baku',
            'item_bonus',
            'pembelian_jml',
            'pembelian_berat',
            'pembelian_harga',
            'harga_jual',
            'pembelian_bahan_status',
            'jml_now',
            'pembelian_bahan_date',
            'timestamp',
        ],
    ]) ?>

</div>
