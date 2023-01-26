<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BebanList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="beban-list-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'beban_list') ?>

    <?= $form->field($model, 'beban_owner') ?>

    <?= $form->field($model, 'akun') ?>

    <?= $form->field($model, 'beban') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'tgl') ?>

    <?php // echo $form->field($model, 'nama_foto') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
