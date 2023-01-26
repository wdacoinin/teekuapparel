<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KonsumenT */

$this->title = 'Update Konsumen: ' . $model->konsumen_nama;
$this->params['breadcrumbs'][] = ['label' => 'Konsumen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->konsumen_nama, 'url' => ['view', 'konsumen' => $model->konsumen]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
