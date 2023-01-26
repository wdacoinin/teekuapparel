<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akun-saldo-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'akun_saldo') ?>

    <?= $form->field($model, 'akun') ?>

    <?= $form->field($model, 'inorout') ?>

    <?= $form->field($model, 'ket') ?>

    <?= $form->field($model, 'jml') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
