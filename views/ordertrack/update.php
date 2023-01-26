<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ordertrackv */

$this->title = 'Update Ordertrackv: ' . $model->penjualan;
$this->params['breadcrumbs'][] = ['label' => 'Ordertrackvs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->penjualan, 'url' => ['view', 'penjualan' => $model->penjualan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ordertrackv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
