<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanStepT */

$this->title = 'Update Penjualan Step T: ' . $model->penjualan_step;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Step Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->penjualan_step, 'url' => ['view', 'penjualan_step' => $model->penjualan_step]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualan-step-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
