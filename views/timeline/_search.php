<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukStep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'penjualan_produk_step') ?>

    <?= $form->field($model, 'penjualan_produk') ?>

    <?= $form->field($model, 'jml') ?>

    <?= $form->field($model, 'divisi') ?>

    <?= $form->field($model, 'start') ?>

    <?php // echo $form->field($model, 'end') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
