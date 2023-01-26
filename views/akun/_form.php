<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AkunT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'akun_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'an')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'akun_ref')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
