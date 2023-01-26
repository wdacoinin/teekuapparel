<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
use app\models\Produk;
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

$modProduk = ArrayHelper::map(Produk::find()->select(['produk', 'CONCAT(nama, ", @harga:", harga_jual) AS nama'])->orderBy('nama')->asArray()->all(), 'produk', 'nama');
$modSku = ArrayHelper::map(SkuT::find()->select(['sku', 'sku_kode'])->orderBy('sku_kode')->asArray()->all(), 'sku', 'sku_kode');
?>

<div class="penjualan-produk-t-form">

    <?php $form = ActiveForm::begin(['id' => 'produk-insert', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'nick')->textarea(['rows' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
