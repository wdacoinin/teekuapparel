<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocPenjT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-penj-t-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'penjualan')->textInput() ?>

    <?= $form->field($model, 'Nama_Foto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_nota')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
