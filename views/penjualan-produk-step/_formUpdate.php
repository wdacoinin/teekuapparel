<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukStepT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'penjualan_produk')->textInput() ?>

    <?= $form->field($model, 'jml')->textInput() ?>

    <?= $form->field($model, 'divisi')->textInput() ?>

    <?= $form->field($model, 'start')->textInput() ?>

    <?= $form->field($model, 'end')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
