<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
use app\models\Produk;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;

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

<div class="col-md-6">

    <?php $form = ActiveForm::begin(['id' => 'produk-insert', 'enableAjaxValidation' => true]); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'produk')->widget(Select2::classname(), [
        'data' => $modProduk,
        'options' => ['placeholder' => 'Pilih Produk'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
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
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="col-md-6">
 <!---TABEL ITEM--->
 <?= $this->render('_tabeldetail', [
    'penjualan_produk' => $model->penjualan_produk, 
    'searchModel' => $searchModel, 
    'dataProvider' => $dataProvider
]) ?>
</div>

<div class="col-md-12">
 <!---TABEL DETAIL--->
 <?= $this->render('_produkdetail', [
    'penjualan_produk' => $model->penjualan_produk, 
    'searchModel' => $searchModel1, 
    'dataProvider' => $dataProvider1
]) ?>
</div>


<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton').click( function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2>Form</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->