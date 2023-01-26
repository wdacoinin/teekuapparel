<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukStepT */
/* @var $form yii\widgets\ActiveForm */
$modPenjualanProduk = (new \yii\db\Query())
->select([
    'penjualan_produk.penjualan_produk', 
    'CONCAT(penjualan.faktur, "-", penjualan_produk.penjualan_produk, "( ", konsumen.konsumen_nama, " ) ", " produk:", produk.nama, " Jml.Order:", penjualan_produk.penjualan_jml) AS label'
    ])
->from('penjualan_produk')
->join('LEFT JOIN', 'produk', 'penjualan_produk.produk = produk.produk')
->join('LEFT JOIN', 'penjualan', 'penjualan_produk.penjualan = penjualan.penjualan')
->join('LEFT JOIN', 'akun_log', 'penjualan.akun = akun_log.akun')
->join('LEFT JOIN', 'konsumen', 'penjualan.konsumen = konsumen.konsumen')
->join('LEFT JOIN', 'penjualan_produk_step', 'penjualan_produk_step.penjualan_produk = penjualan_produk.penjualan_produk')
->where(['penjualan_produk.penjualan_produk' => $model->penjualan_produk])
->all();
//data select produk
$modPenjualanProduk = ArrayHelper::map($modPenjualanProduk, 'penjualan_produk', 'label');
$datetime = date('Y-m-d H:i');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'tracking-insert', 'enableAjaxValidation' => true]); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'penjualan_produk')->widget(Select2::classname(), [
        'data' => $modPenjualanProduk,
        'options' => ['placeholder' => 'Produk Order', 'value' => $model->penjualan_produk, 'onChange' => 'checkqty()'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'disabled' => true
    ]); 
    ?>

    <?= $form->field($model, 'jml')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'start')->textInput(['readonly' => true]) ?>

    <?php if($model->end !== null){ ?>
    <?= $form->field($model, 'end')->textInput(['readonly' => true]) ?>
    <?php }else{ ?>
    <?=  
    $form->field($model, 'end')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Tgl Keluar', 'value' => $datetime],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii',
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?php } ?>

    <?= $form->field($model, 'user')->textInput(['type' => 'hidden', 'value' => Yii::$app->user->identity->id])->label(false) ?>
    
    <?= $form->field($model, 'divisi')->textInput(['type' => 'hidden', 'value' => $model->divisi])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
