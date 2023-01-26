<?php

use app\models\PenjualanProdukDetailv;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'File Produk';


/* $modPenjualanProduk = (new \yii\db\Query())
->select([
    'penjualan_produk.penjualan_produk', 
    'produk.nama'
    ])
->from('penjualan_produk')
->join('LEFT JOIN', 'produk', 'produk.produk = penjualan_produk.produk')
->where(['penjualan' => $Penjualan->penjualan])
->all(); */
$modPP = PenjualanProdukDetailv::find()->select(['penjualan_produk', 'CONCAT(nama, ", ", item) AS nama'])->where(['penjualan' => $Penjualan->penjualan])->asArray()->all();
$modPenjualanProduk = ArrayHelper::map($modPP, 'penjualan_produk', 'nama');

?>


<?php $form = ActiveForm::begin(['id' => 'file-insert', 'enableAjaxValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="col-md-12">
    
    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

    <?= $form->field($DocPenjualanProduk, 'keterangan')->textarea(['rows' => 2]) ?>


    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
