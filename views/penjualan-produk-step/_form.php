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
->join('LEFT JOIN', 'konsumen', 'penjualan.konsumen = konsumen.konsumen')
->join('LEFT JOIN', 'penjualan_produk_step', 'penjualan_produk_step.penjualan_produk = penjualan_produk.penjualan_produk')
->where('penjualan_produk_step.penjualan_produk_step IS NULL')
->all();
//select produk
$modPenjualanProduk = ArrayHelper::map($modPenjualanProduk, 'penjualan_produk', 'label');
//select divisi
$modDivisi = ArrayHelper::map(Divisi::find()->groupBy('divisi')->asArray()->all(), 'divisi', 'nama');
//url ajax
$controller = Yii::$app->controller;
$params ="{$controller->id}/checkqty";
//today
$datetime = date('Y-m-d H:i');
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'penjualan_produk')->widget(Select2::classname(), [
        'data' => $modPenjualanProduk,
        'options' => ['placeholder' => 'Produk Order', 'onChange' => 'checkqty()'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'jml')->textInput(['readonly' => true]) ?>

    <?=  
    $form->field($model, 'start')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Tgl Masuk', 'value' => $datetime],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii',
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?= $form->field($model, 'user')->textInput(['type' => 'hidden', 'value' => Yii::$app->user->identity->id])->label(false) ?>
    
    <?= $form->field($model, 'divisi')->textInput(['type' => 'hidden', 'value' => Yii::$app->user->identity->divisi])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type='text/javascript'>
    function checkqty (){
        var penjualan_produk = $('#penjualanprodukstept-penjualan_produk').val();
        //var penjualan_produk = $(this).val();
        console.log('checkqty:' + penjualan_produk);
        if(penjualan_produk > 0){
            $.ajax( {
                type: "POST",
                url: window.origin + '<?php echo  Yii::$app->urlManager->createUrl($params); ?>' + '&penjualan_produk=' + penjualan_produk,
                dataType: "json",
                success: function ( data ) {
                    if(parseFloat(data) > 0){
                        $('#penjualanprodukstept-jml').val(data);
                    }else{
                        $('#penjualanprodukstept-jml').val(0);
                    }
                    
                    
                },
                error: function ( er ) {
                    params.error( er );
                }
            } );
        }else{
            $('#penjualanprodukstept-jml').val(0);
        }
        

    }
</script>
