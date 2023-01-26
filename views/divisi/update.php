<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DivisiT */

$this->title = 'Update Divisi: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Divisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'divisi' => $model->divisi]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="divisi-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
