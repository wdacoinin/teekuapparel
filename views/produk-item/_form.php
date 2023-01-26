<?php

use yii\helpers\Html;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

$dispOptions = ['class' => 'form-control'];
    
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];

$saveCont = ['class' => 'kv-saved-cont'];

/* @var $this yii\web\View */
/* @var $model app\models\ProdukItemT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'produk_item_nama')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'produk_item_kat')->widget(Select2::classname(), [
        'data' => ['1' => 'Size', '2' => 'Neck', '3' => 'Lengan', '4' => 'Vareasi'],
        'options' => ['placeholder' => 'Status Produk'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'produk_item_harga')->widget(NumberControl::classname(), [
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

    <?= // Usage with ActiveForm and model
    $form->field($model, 'produk_item_status')->widget(Select2::classname(), [
        'data' => ['Aktif' => 'Aktif', 'Non Aktif' => 'Non Aktif'],
        'options' => ['placeholder' => 'Status Produk'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
