<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianBahan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembelian-bahan-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'pembelian_bahan') ?>

    <?= $form->field($model, 'pembelian') ?>

    <?= $form->field($model, 'bahan_baku') ?>

    <?= $form->field($model, 'item_bonus') ?>

    <?= $form->field($model, 'pembelian_jml') ?>

    <?php // echo $form->field($model, 'pembelian_berat') ?>

    <?php // echo $form->field($model, 'pembelian_harga') ?>

    <?php // echo $form->field($model, 'harga_jual') ?>

    <?php // echo $form->field($model, 'pembelian_bahan_status') ?>

    <?php // echo $form->field($model, 'jml_now') ?>

    <?php // echo $form->field($model, 'pembelian_bahan_date') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
