<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianT */

$this->title = $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'Pembelian', 'url' => ['pembelian-view/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pembelian-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pembelian' => $model->pembelian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pembelian' => $model->pembelian], [
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
            'pembelian',
            'pembelian_tgl',
            'supplier',
            'pembelian_status',
            'us',
            'faktur',
            'pembelian_tempo',
            'no_sj',
            'keterangan:ntext',
            'pembelian_diskon',
            'akun',
        ],
    ]) ?>

</div>
