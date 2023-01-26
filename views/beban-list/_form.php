<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;
use app\models\Akun;
use app\models\Beban;
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

/* @var $this yii\web\View */
/* @var $model app\models\BebanListT */
/* @var $form yii\widgets\ActiveForm */
$modAkun = ArrayHelper::map(Akun::find()->select(['akun', 'CONCAT(akun_nama, " ", akun_ref) AS ref'])->asArray()->all(), 'akun', 'ref');
$modBeban = ArrayHelper::map(Beban::find()->asArray()->all(), 'beban', 'nama');

//file
// File Produk
$rows = (new \yii\db\Query())
->select([
    'beban_list.beban_list',
    'beban_list.type',
    'beban_list.nama_foto',
    'beban_list.size',
    'beban_list.url'
    ])
->from('beban_list')
->where(['beban_list' => $model->beban_list])
->all();

$initialPreview = [];
$initialPreviewConfig = [];
if($rows){
    foreach ($rows as $i => $row) {
        $initialPreview[$i] = $row['url'];
        $initialPreviewConfig[$i] = array(
            'key' => $row['beban_list'],
            'url' => 'index.php?r=beban-list/deletefile',
            'caption' => $row['nama_foto'],
            'size' => $row['size'],
        );
    }
}
?>

<div class="beban-list-t-form">

    <?php $form = ActiveForm::begin(['id' => 'beban-insert', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'beban_owner')->textInput(['value' => 0, 'type' => 'hidden'])->label(false) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'akun')->widget(Select2::classname(), [
        
        'data' => $modAkun,
        'options' => ['placeholder' => 'Pilih Akun Bank'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'beban')->widget(Select2::classname(), [
        
        'data' => $modBeban,
        'options' => ['placeholder' => 'Pilih Beban'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'jumlah')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'suffix' => '',        
            'groupSeparator' => '.',
            'radixPoint' => '',
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => ['class' => 'form-control', 'readonly' => false],
        'saveInputContainer' => $saveCont
    ]);
    ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?=  
    $form->field($model, 'tgl')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Tgl'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'options'=>[
            'multiple'=>false
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview,
            'initialCaption'=>false,
            'initialPreviewConfig' => $initialPreviewConfig,
            'overwriteInitial'=>false,
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

    <?= $form->field($model, 'nama_foto')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'type')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'url')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'size')->textInput(['type' => 'hidden'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
