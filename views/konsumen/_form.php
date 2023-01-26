<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\KonsumenT */
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
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'konsumen_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'limits')->widget(NumberControl::classname(), [
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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .35rem;
	}
</style>