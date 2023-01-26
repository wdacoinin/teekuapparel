<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\AkunLogT */
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
<div class="col-md-12">
    <?php if ($model->jml > 0){ ?>
    <?php $form = ActiveForm::begin(['id' => 'penjualan-insert', 'enableAjaxValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
        <?= // Usage with ActiveForm and model
        $form->field($model, 'inorout')->widget(Select2::classname(), [
            'data' => $modInorout,
            'options' => ['placeholder' => 'Pilih'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); 
        ?>

        <?= $form->field($model, 'idref')->textInput(['type' => 'hidden'])->label(false) ?>

        <?= $form->field($model, 'user')->textInput(['type' => 'hidden', 'value' => Yii::$app->user->identity->id])->label(false) ?>

        <?= // Usage with ActiveForm and model
        $form->field($model, 'akun')->widget(Select2::classname(), [
            'data' => $modAkun,
            'options' => ['placeholder' => 'Pilih Rekening Bank'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); 
        ?>
        </div>
        <div class="col-md-6">

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
        $form->field($model, 'tgl')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Tgl Pembayaran', 'value' => $datetime],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]);
        ?>

        </div>
        <div class="col-md-12">
        <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ],
        ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php }else{ ?>
        <div class="form-group info"> 
            *Jika Form kosong: <br>
            - Penjualan sudah terbayar lunas.<br>
            - Belum ada input produk / total transaksi penjualan 0.<br> 
            - Anda mengisi jumlah pembayaran 0.<br> 
        </div>
    <?php } ?>
</div>
