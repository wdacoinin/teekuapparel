<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianBahanT */

/* $this->title = 'Update Pembelian Bahan: ' . $model->pembelian_bahan;
$this->params['breadcrumbs'][] = ['label' => 'Pembelian Bahan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pembelian_bahan, 'url' => ['view', 'pembelian_bahan' => $model->pembelian_bahan]];
$this->params['breadcrumbs'][] = 'Update'; */
?>
<div class="pembelian-bahan-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
