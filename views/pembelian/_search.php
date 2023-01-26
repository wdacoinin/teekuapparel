<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembelian-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'pembelian') ?>

    <?= $form->field($model, 'pembelian_tgl') ?>

    <?= $form->field($model, 'supplier') ?>

    <?= $form->field($model, 'pembelian_status') ?>

    <?= $form->field($model, 'us') ?>

    <?php // echo $form->field($model, 'faktur') ?>

    <?php // echo $form->field($model, 'pembelian_tempo') ?>

    <?php // echo $form->field($model, 'no_sj') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'pembelian_diskon') ?>

    <?php // echo $form->field($model, 'akun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
