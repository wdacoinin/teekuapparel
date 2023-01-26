<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AkunLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akun-log-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'akun_log') ?>

    <?= $form->field($model, 'inorout') ?>

    <?= $form->field($model, 'idref') ?>

    <?= $form->field($model, 'akun') ?>

    <?= $form->field($model, 'jml') ?>

    <?php // echo $form->field($model, 'tgl') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'id_img') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
