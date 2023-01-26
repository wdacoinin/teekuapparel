<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\BackendUser;
use app\models\Akun;
use app\models\Konsumen;
use app\models\Penjualan;
use app\models\PenjualanT;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */
/* @var $form yii\widgets\ActiveForm */
$modUser = ArrayHelper::map(BackendUser::find()->where('6 > divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama');
//$modSales = ArrayHelper::map(BackendUser::find()->where(['divisi' => 5])->orderBy('nama')->asArray()->all(), 'id', 'nama');
$modSales = ArrayHelper::map(BackendUser::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama');
$modAkun = ArrayHelper::map(Akun::find()->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
$modKonsumen = ArrayHelper::map(Konsumen::find()->orderBy('konsumen_nama')->asArray()->all(), 'konsumen', 'konsumen_nama');
$m = date('Y-m-d');
$count_pj = PenjualanT::find()->where(["DATE_FORMAT(penjualan_tgl,'%Y-%m-%d')" => $m])->count();
//var_dump($count_pj);die;
if($count_pj > 0){
    $max= PenjualanT::find()->select('faktur')->where(["DATE_FORMAT(penjualan_tgl,'%Y-%m-%d')" => $m])->orderBy('penjualan DESC')->limit(1)->asArray()->one();  
    $nmax = substr($max['faktur'], strpos($max['faktur'], "-") + 1);
    //var_dump($nmax);die;
    $newfaktur = 'P' . date('Ymd') . '-' .  ((int) $nmax + 1);
}else{
    $newfaktur = 'P' . date('Ymd') . '-' .  ($count_pj + 1);
}
$today = date('Y-m-d');
//echo 'Jml: ' . $today;
?>


<?php $form = ActiveForm::begin(['id' => 'penjualan-insert', 'enableAjaxValidation' => true]); ?>
<!---- FORM ORDER ----->
<div class="container-flex d-print-none">
    <div class="card">
        <div class="card-header p-2 d-flex bg-info">
            <div class="mr-auto">
                <div class="d-flex">
                <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                <span class="align-self-center mr-2">
                    <h5 class="card-title mb-0 text-white">Detail Penjualan</b>
                    </h5>
                </span>
                </div>
            </div>
            <div class="float-right">
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center maximized hide" data-feather="maximize" data-toggle="collapse" aria-expanded="false" href="#collapseDetail" aria-controls="collapseDetail"></i>
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center minimized" data-feather="minimize" data-toggle="collapse" aria-expanded="true" href="#collapseDetail" aria-controls="collapseDetail"></i> 
            </div>
        </div>
        <div class="card-body p-3" id="collapseDetail" class="collapse show">
            <div class="row">
            <small><i>* harus diisi.</i></small>
    
            <div class="col-md-4">
            <?=  
            $form->field($model, 'penjualan_tgl')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl Order', 'value' => $today],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>

            <?= $form->field($model, 'faktur')->textInput(['value' => $newfaktur, 'maxlength' => true, 'readonly' => true]) ?>

            <?= $form->field($model, 'sales')->textInput(['value' => Yii::$app->user->identity->id, 'maxlength' => true, 'hidden' => true])->label(false) ?>

            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'surat_jalan')->textInput(['maxlength' => true, 'type' => 'hidden', 'readonly' => true])->label(false) ?>
            
            </div>
            <div class="col-md-4">

            <?= $form->field($model, 'konsumen_nama')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'penjualan_ongkir')->textInput(['type' => 'hidden', 'readonly' => true])->label(false) ?>

            <?= $form->field($model, 'fee')->textInput(['type' => 'hidden', 'readonly' => true])->label(false) ?>

            <?= $form->field($model, 'fee_date')->textInput(['type' => 'hidden', 'readonly' => true])->label(false) ?>

            </div>
            <div class="col-md-4">

            <?=  
            $form->field($model, 'penjualan_tempo')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl Jatuh Tempo', 'value' => $today],
                'value' => $today,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?= $form->field($model, 'penjualan_status')->textInput(['type' => 'hidden', 'readonly' => true])->label(false) ?>

            <?= $form->field($model, 'penjualan_diskon')->textInput(['type' => 'hidden', 'readonly' => true])->label(false) ?>

            <?= $form->field($model, 'user')->textInput(['value' => Yii::$app->user->identity->id, 'type' => 'hidden'])->label(false) ?>

            </div>
        </div>

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    </div>
</div>
</div>
<!---- END FORM PENJUALAN ----->

<?php ActiveForm::end(); ?>

<script type='text/javascript'>
    /* $( document ).ready( function () {
	$('.collapse').collapse()
	$('#collapseDetail').collapse('show');

    $('.minimized').on('click', function(){
        $(this).addClass('hide');
        $('.maximized').removeClass('hide');
	    $('#collapseDetail').collapse('hide');
    });

    $('.maximized').on('click', function(){
        $(this).addClass('hide');
        $('.minimized').removeClass('hide');
	    $('#collapseDetail').collapse('show');
    });

    } ); */
</script>

<style>	
	.hide {
		display: none;
	}
</style>