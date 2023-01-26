<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\BackendUser;
use app\models\Supplier;
use app\models\BahanBaku;
use app\models\Pembelian;
use kartik\number\NumberControl;

$modBahanBaku = ArrayHelper::map(BahanBaku::find()->select(['bahan_baku', 'CONCAT(nama, ", satuan:", satuan) AS nama'])->orderBy('bahan_baku')->asArray()->all(), 'bahan_baku', 'nama');
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

    <?php $form = ActiveForm::begin(['id' => 'pembelian-bahan-insert', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'pembelian')->textInput(['type' => 'hidden'])->label(false) ?>


    <?= // Usage with ActiveForm and model
    $form->field($model, 'bahan_baku')->widget(Select2::classname(), [
        'data' => $modBahanBaku,
        'options' => ['placeholder' => 'Pilih Bahan Baku'],
        'disabled' => true,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'jml_now')->textInput(['type' => 'number', 'min' => 0, 'step' => 0.01]) ?>

    <?= $form->field($model, 'pembelian_jml')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'pembelian_berat')->textInput(['type' => 'hidden'])->label(false) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'pembelian_harga')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'suffix' => '',        
            'groupSeparator' => '.',
            'radixPoint' => '',
            'allowMinus' => false
        ],
        'disabled' => true,
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

    <?= $form->field($model, 'pembelian_bahan_status')->textInput(['type' => 'hidden', 'value' => 1])->label(false) ?>

    <?= $form->field($model, 'harga_jual')->textInput(['type' => 'hidden', 'value' => 0])->label(false) ?>

    <?= $form->field($model, 'pembelian_bahan_date')->textInput(['type' => 'hidden', 'value' => $today])->label(false) ?>

    <?= $form->field($model, 'timestamp')->textInput(['type' => 'hidden', 'value' => $today])->label(false) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'item_bonus')->widget(Select2::classname(), [
        'data' => ['0' => 'Tidak', '1' => 'Ya'],
        'options' => ['placeholder' => 'Set sebagai item bonus?'],
        'disabled' => true,
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
