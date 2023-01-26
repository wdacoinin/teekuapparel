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

//data select divisi
$modDivisi = ArrayHelper::map(Divisi::find()->groupBy('divisi')->asArray()->all(), 'divisi', 'nama');

//filter kondisi where base on user divisi login
$where = '';
if(Yii::$app->user->identity->divisi === 1){
    $where = 'penjualan_produk_step.penjualan_produk_step IS NULL';
}elseif(Yii::$app->user->identity->divisi === 8){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi IS NULL'; //proofing
}elseif(Yii::$app->user->identity->divisi === 9){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 8 AND penjualan_produk_step.end IS NOT NULL'; //setting
}elseif(Yii::$app->user->identity->divisi === 10){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 9 AND penjualan_produk_step.end IS NOT NULL'; //tiff
}elseif(Yii::$app->user->identity->divisi === 11){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 10 AND penjualan_produk_step.end IS NOT NULL'; // print
}elseif(Yii::$app->user->identity->divisi === 17){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 11 AND penjualan_produk_step.end IS NOT NULL'; // press besar
}elseif(Yii::$app->user->identity->divisi === 12){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi IS NULL'; // poliflex
}elseif(Yii::$app->user->identity->divisi === 14){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 12 AND penjualan_produk_step.end IS NOT NULL'; // j celana
}elseif(Yii::$app->user->identity->divisi === 15){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 11 AND penjualan_produk_step.end IS NOT NULL'; // j atas
}elseif(Yii::$app->user->identity->divisi === 13){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi IN ("14", "17") AND penjualan_produk_step.end IS NOT NULL'; //QC
}elseif(Yii::$app->user->identity->divisi === 16){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 13 AND penjualan_produk_step.end IS NOT NULL'; //press kicil
}elseif(Yii::$app->user->identity->divisi === 6){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 16 AND penjualan_produk_step.end IS NOT NULL'; //Deliveri
}

//Query kondisi where base on user divisi login
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
->where($where)
->all();

//data select produk
$modPenjualanProduk = ArrayHelper::map($modPenjualanProduk, 'penjualan_produk', 'label');
//url ajax
$controller = Yii::$app->controller;
$params ="{$controller->id}/checkqty";
//today
$datetime = date('Y-m-d H:i');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'tracking-insert', 'enableAjaxValidation' => true]); ?>

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
