<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
use app\models\Produk;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukT */
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

$modProduk = ArrayHelper::map(Produk::find()->select(['produk', 'CONCAT(nama, ", @harga:", harga_jual) AS nama'])->orderBy('nama')->asArray()->all(), 'produk', 'nama');
?>

<div class="penjualan-produk-t-form">

    <?php $form = ActiveForm::begin(['id' => 'produk-insert', 'enableAjaxValidation' => true]); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'produk')->widget(Select2::classname(), [
        'data' => $modProduk,
        'options' => ['placeholder' => 'Pilih Produk'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'penjualan_jml')->textInput() ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'penjualan_harga')->widget(NumberControl::classname(), [
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
