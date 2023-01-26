<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'penjualan' => $model->penjualan], [
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
            'penjualan',
            'penjualan_tgl',
            'penjualan_tempo',
            [                                                  // the owner name of the model
                'label' => 'Konsumen',
                'value' => $model->konsumen0->konsumen_nama,            
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip'],  // HTML attributes to customize label tag
            ],
            'faktur',
            'surat_jalan',
            [                                                  // the owner name of the model
                'label' => 'Alamat',
                'value' => $model->konsumen0->alamat,            
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip'],  // HTML attributes to customize label tag
            ],
            'keterangan:ntext',
            'penjualan_ongkir',
            'fee',
            'fee_date',
            'sales',
            'penjualan_diskon',
            [                                                  // the owner name of the model
                'label' => 'Admin User',
                'value' => $model->user0->nama,            
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip'],  // HTML attributes to customize label tag
            ],
            'penjualan_status',
            'akun',
        ],
    ]) ?>

</div>