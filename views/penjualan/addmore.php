<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
use app\models\Produk;
use app\models\ProdukItemT;
use app\models\SkuT;
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

$modsel = ProdukItemT::find()
->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
->where('produk_item_kat = 1')
->orderBy('produk_item_nama')
->asArray()->all();
$modSize = ArrayHelper::map($modsel, 'produk_item', 'nama');
$modsel2 = ProdukItemT::find()
->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
->where('produk_item_kat = 2')
->orderBy('produk_item_nama')
->asArray()->all();
$modNeck = ArrayHelper::map($modsel2, 'produk_item', 'nama');
$modsel3 = ProdukItemT::find()
->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
->where('produk_item_kat = 3')
->orderBy('produk_item_nama')
->asArray()->all();
$modLengan = ArrayHelper::map($modsel3, 'produk_item', 'nama');
$modsel4 = ProdukItemT::find()
->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
->where('produk_item_kat = 4')
->orderBy('produk_item_nama')
->asArray()->all();
$modVar = ArrayHelper::map($modsel4, 'produk_item', 'nama');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'produk-addmore', 'enableAjaxValidation' => true]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nick')->textInput(['autocomplete' => 'off'])->label('NickName') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'qty')->textInput(['type' => 'number', 'min' => 1, 'step' => 1, 'autocomplete' => 'off'])->label('Qty') ?>
        </div>
    </div>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'size')->widget(Select2::classname(), [
        'data' => $modSize,
        'options' => ['placeholder' => 'Pilih Size'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'neck')->widget(Select2::classname(), [
        'data' => $modNeck,
        'options' => ['placeholder' => 'Pilih Neck'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'lengan')->widget(Select2::classname(), [
        'data' => $modLengan,
        'options' => ['placeholder' => 'Pilih Lengan'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'vareasi')->widget(Select2::classname(), [
        'data' => $modVar,
        'options' => ['placeholder' => 'Pilih vareasi'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
