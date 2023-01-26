<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierT */

$this->title = 'Update Supplier: ' . $model->supplier_nama;
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supplier_nama, 'url' => ['view', 'supplier' => $model->supplier]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
