<?php

use yii\helpers\Html;
use app\widgets\Alert;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use kartik\widgets\DateTimePicker;


//data select divisi
//$modDivisi = ArrayHelper::map(Divisi::find()->groupBy('divisi')->asArray()->all(), 'divisi', 'nama');
if($model !== null){
//filter kondisi where base on user divisi login
$where = '';

if($model->divisi == 1){
    $where = 'penjualan_produk_step.penjualan_produk_step IS NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.'';
}
elseif($model->divisi == 8){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 5 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; //proofing
}elseif($model->divisi == 9){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 8 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; //setting
}elseif($model->divisi == 10){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 9 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; //tiff
}elseif($model->divisi == 11){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 10 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; // print
}elseif($model->divisi == 17){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 11 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; // press besar
}elseif($model->divisi == 12){
    $where = "penjualan.akun > 0 AND penjualan_produk_step.divisi = 5 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk=".$model->penjualan_produk.""; // poliflex
}elseif($model->divisi == 14){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 12 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; // j celana
}elseif($model->divisi == 15){
    $where = 'penjualan.akun > 0 AND penjualan_produk_step.divisi = 17 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk='.$model->penjualan_produk.''; // j atas
}elseif($model->divisi == 13){
    $where = "penjualan.akun > 0 AND  (penjualan_produk_step.divisi=14 OR penjualan_produk_step.divisi=15) AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk =".$model->penjualan_produk.""; //QC
}elseif($model->divisi == 16){
    $where = "penjualan.akun > 0 AND penjualan_produk_step.divisi = 13 AND penjualan_produk.penjualan_produk=".$model->penjualan_produk.""; //press kicil
}elseif($model->divisi == 6){
    $where = "penjualan.akun > 0 AND penjualan_produk_step.divisi = 16 AND penjualan_produk_step.end IS NOT NULL AND penjualan_produk.penjualan_produk=".$model->penjualan_produk.""; //dilivery
}

//$modPenjualanProduk = ['' => 'Pilih'];
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
->groupBy('penjualan_produk.penjualan_produk')
->all();

/* echo count($modPenjualanProduk); */
//data select produk
$modPenjualanProduk = ArrayHelper::map($modPenjualanProduk, 'penjualan_produk', 'label');
/* if($modPenjualanProduk !== null){
    //data select produk
    $modPenjualanProduk = ArrayHelper::map($modPenjualanProduk, 'penjualan_produk', 'label');

}else{
    $modPenjualanProduk = ['' => 'Pilih'];
} */
//url ajax
$controller = Yii::$app->controller;
$params ="{$controller->id}/checkqty";
//today
$datetime = date('Y-m-d H:i');

?>

<?php if(count($modPenjualanProduk) > 0){ ?>
<div class="offset-md-2 col-md-8 offset-sm-1 col-sm-10" style="padding:15px;">

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

    <?= $form->field($model, 'jml')->textInput(['readonly' => true, 'value' => $model->jml]) ?>

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

    <?= $form->field($model, 'user')->textInput(['type' => 'hidden', 'value' => $model->user])->label(false) ?>
    
    <?= $form->field($model, 'divisi')->textInput(['type' => 'hidden', 'value' => $model->divisi])->label(false) ?>

    <div class="d-grid gap-2 py-5">
        <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-info border-radius-lg', 'style'=> 'background-color: #f84e4e !important;border-color: #f84e4e !important;color:#ffffff;border-radius:20px;box-shadow: 5px 1px 10px #888888;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="../assets/js/jquery-3.5.1.js"></script>
<script type='text/javascript'>
    checkqty ();
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
<link media="screen" rel="stylesheet" href="../assets/fontawesome5/css/all.css">

    <?php }else{ ?>
        <div class="offset-md-2 col-md-8 offset-sm-1 col-sm-10" style="padding:15px;">
            <h4 class="text-center">Masih dalam proses divisi lain</h4>
        </div>
    <?php } ?>

<?php }else{ ?>

    <div class="offset-md-2 col-md-8 offset-sm-1 col-sm-10" style="padding:15px;">

    <?= Alert::widget() ?>

    </div>

<?php } ?>
<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .55rem;
	}
</style>