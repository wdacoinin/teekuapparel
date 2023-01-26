<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuT */

$this->title = 'Update Bahan: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Bahan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'bahan_baku' => $model->bahan_baku]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-6">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
