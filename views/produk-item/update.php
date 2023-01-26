<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukItemT */

$this->title = 'Update Item: ' . $model->produk_item;
//$this->params['breadcrumbs'][] = ['label' => 'Produk Item Ts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->produk_item, 'url' => ['view', 'produk_item' => $model->produk_item]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
