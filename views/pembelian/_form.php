<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\BackendUser;
use app\models\Supplier;
use app\models\Akun;
use app\models\Pembelian;
use app\models\PembelianT;
use kartik\number\NumberControl;

$modAkun = ArrayHelper::map(Akun::find()->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
$modSupplier = ArrayHelper::map(Supplier::find()->orderBy('supplier_nama')->asArray()->all(), 'supplier', 'supplier_nama');

//helper number input
$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];

$m = date('Y-m');
$count_pj = PembelianT::find()->where(["DATE_FORMAT(pembelian_tgl,'%Y-%m')" => $m])->count();
//var_dump($count_pj);die;
if($count_pj > 0){
    $max= PembelianT::find()->select('faktur')->where(["DATE_FORMAT(pembelian_tgl,'%Y-%m')" => $m])->orderBy('pembelian DESC')->limit(1)->asArray()->one();  
    $nmax = substr($max['faktur'], strpos($max['faktur'], "-") + 1);
    //var_dump($nmax);die;
    $newfaktur = 'PB' . date('Ymd') . '-' .  ((int) $nmax + 1);
}else{
    $newfaktur = 'PB' . date('Ymd') . '-' .  ($count_pj + 1);
}
$today = date('Y-m-d');
?>

<div class="pembelian-t-form">

    <?php $form = ActiveForm::begin(['id' => 'pembelian-insert', 'enableAjaxValidation' => true]); ?>

    
    <div class="col-md-12">
    <div class="row">
    <small><i>* harus diisi.</i></small>

    <div class="col-md-6">

    <?= $form->field($model, 'faktur')->textInput(['value' => $newfaktur, 'maxlength' => true, 'readonly' => true]) ?>

    <?=  
    $form->field($model, 'pembelian_tgl')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Tgl Pembelian', 'value' => $today],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?=  
    $form->field($model, 'pembelian_tempo')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Tgl Tempo', 'value' => $today],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'supplier')->widget(Select2::classname(), [
        'data' => $modSupplier,
        'options' => ['placeholder' => 'Pilih Supplier'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'pembelian_status')->widget(Select2::classname(), [
        'data' => ['Lunas' => 'Lunas', 'Hutang' => 'Hutang'],
        'options' => ['placeholder' => 'Status Pembelian'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>
    </div>


    <div class="col-md-6">

    <?= $form->field($model, 'us')->textInput(['value' => Yii::$app->user->identity->id, 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'no_sj')->textInput(['maxlength' => true]) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'pembelian_diskon')->widget(NumberControl::classname(), [
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

    <?= // Usage with ActiveForm and model
    $form->field($model, 'akun')->widget(Select2::classname(), [
        'data' => $modAkun,
        'options' => ['placeholder' => 'Akun Bank'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
    </div>

    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
