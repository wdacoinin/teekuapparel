<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuT */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Bahan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="col-md-6">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'bahan_baku' => $model->bahan_baku], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'bahan_baku' => $model->bahan_baku], [
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
            'bahan_baku',
            'nama',
            'panjang_bahan',
            'satuan',
            'harga',
            'kode',
            'timestamp',
        ],
    ]) ?>

</div>
