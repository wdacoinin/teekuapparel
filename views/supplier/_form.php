<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'supplier_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplier_detail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
