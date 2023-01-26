<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukDetailT */

$this->title = 'Update Produk Detail T: ' . $model->produk_detail;
$this->params['breadcrumbs'][] = ['label' => 'Produk Detail Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->produk_detail, 'url' => ['view', 'produk_detail' => $model->produk_detail]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="produk-detail-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
