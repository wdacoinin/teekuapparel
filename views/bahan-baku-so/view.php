<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuSoT */

$this->title = $model->bahan_baku_so;
$this->params['breadcrumbs'][] = ['label' => 'Bahan Baku So Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bahan-baku-so-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'bahan_baku_so' => $model->bahan_baku_so], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'bahan_baku_so' => $model->bahan_baku_so], [
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
            'bahan_baku_so',
            'bahan_baku',
            'pembelian_bahan',
            'jml',
            'berat',
            'date',
            'us',
        ],
    ]) ?>

</div>
