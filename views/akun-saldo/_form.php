<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */
/* @var $form yii\widgets\ActiveForm */
$dispOptions = ['class' => 'form-control'];
    
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
$datetime = date('Y-m-d');
?>

<div class="akun-saldo-t-form">

    <?php $form = ActiveForm::begin(['id' => 'saldo-insert', 'enableAjaxValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-md-12">
    <?= // Usage with ActiveForm and model
    $form->field($model, 'inorout')->widget(Select2::classname(), [
        'data' => $modInorout,
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model  
    $form->field($model, 'akun')->widget(Select2::classname(), [
        'data' => $modAkun,
        'options' => ['placeholder' => 'Pilih Rekening Bank'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'ket')->textarea(['rows' => 6]) ?>
    

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'jml')->widget(NumberControl::classname(), [
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

    <?=  
    $form->field($model, 'date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Tgl', 'value' => $datetime],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]);
    ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
