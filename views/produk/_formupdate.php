<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use app\models\Produk;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukT */
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

$modkategori = ArrayHelper::map(Produk::find()->groupBy('kategori')->asArray()->all(), 'kategori', 'kategori');
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'kategori')->widget(Select2::classname(), [
        'data' => $modkategori,
        'options' => ['placeholder' => 'Kategori'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'harga_pokok')->widget(NumberControl::classname(), [
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

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'harga_jual')->widget(NumberControl::classname(), [
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
    $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => ['true' => 'Aktif', 'false' => 'Non Aktif'],
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

