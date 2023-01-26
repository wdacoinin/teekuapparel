<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
//helper number input
$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
$today = date('Y-m-d');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'bahan-insert', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'satuan')->textInput(['maxlength' => true]) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'harga')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'suffix' => '',        
            'groupSeparator' => '.',
            'radixPoint' => '',
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'panjang_bahan')->textInput(['type' => 'hidden', 'value' => 0])->label(false) ?>

    <?= $form->field($model, 'timestamp')->textInput(['type' => 'hidden', 'value' => $today])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
