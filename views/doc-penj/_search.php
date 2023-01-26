<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocPenj */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-penj-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_img') ?>

    <?= $form->field($model, 'penjualan') ?>

    <?= $form->field($model, 'Nama_Foto') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'is_nota') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
