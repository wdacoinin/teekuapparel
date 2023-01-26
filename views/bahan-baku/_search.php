<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBaku */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bahan-baku-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'bahan_baku') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'panjang_bahan') ?>

    <?= $form->field($model, 'satuan') ?>

    <?= $form->field($model, 'harga') ?>

    <?php // echo $form->field($model, 'kode') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
