<?php

use app\models\ProdukDetailT;
use app\models\ProdukItemT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukDetailT */
/* @var $form yii\widgets\ActiveForm */
/* $modfilter = ProdukDetailT::find()
->select('GROUP_CONCAT(produk_item.produk_item_kat) AS filter')
->join("LEFT JOIN", "produk_item", "produk_item.produk_item = produk_detail.produk_item")
->where(['penjualan_produk' => $model->penjualan_produk])
->groupBy('penjualan_produk')
->asArray()->one();
if($modfilter != null){
    //$arrr = null;
     foreach ($modfilter as $row){
        $arrr[] = array($row['produk_item_kat']);
    } 

    
    $modsel = ProdukItemT::find()
    ->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
    ->where('produk_item_kat NOT IN('.$modfilter['filter'].')')
    ->orderBy('produk_item_nama')
    ->asArray()->all();
}else{ */

    $modsel = ProdukItemT::find()
    ->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
    ->orderBy('produk_item_nama')
    ->asArray()->all();
/* } */

/* $modsel = ProdukItemT::find()
->select(['produk_item', 'CONCAT(produk_item_nama, ", @harga:", produk_item_harga) AS nama'])
->orderBy('produk_item_nama')
->asArray()->all(); */

$modProduk = ArrayHelper::map($modsel, 'produk_item', 'nama');
?>

<div class="produk-detail-t-form">

    <?php $form =  ActiveForm::begin(['id' => 'produk-detail', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'penjualan_produk')->textInput(['hidden' => true, 'value' => $model->penjualan_produk])->label(false); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'produk_item')->widget(Select2::classname(), [
        'data' => $modProduk,
        'options' => ['placeholder' => 'Pilih Produk'],
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
