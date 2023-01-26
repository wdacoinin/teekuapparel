<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuSo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bahan-baku-so-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'bahan_baku_so') ?>

    <?= $form->field($model, 'bahan_baku') ?>

    <?= $form->field($model, 'pembelian_bahan') ?>

    <?= $form->field($model, 'jml') ?>

    <?= $form->field($model, 'berat') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'us') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
