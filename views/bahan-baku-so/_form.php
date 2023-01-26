<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuSoT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bahan-baku-so-t-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bahan_baku')->textInput() ?>

    <?= $form->field($model, 'pembelian_bahan')->textInput() ?>

    <?= $form->field($model, 'jml')->textInput() ?>

    <?= $form->field($model, 'berat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'us')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
