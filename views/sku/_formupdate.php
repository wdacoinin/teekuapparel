<?php

use app\models\BackendUser;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

$initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->sku,
    'url' => 'index.php?r=sku/deletefilesku',
    'caption' => $model->nama_foto,
    'size' => $model->size,
);

/* @var $this yii\web\View */
/* @var $model app\models\SkuT */
/* @var $form yii\widgets\ActiveForm */
$modDesainer = ArrayHelper::map(BackendUser::find()->select(['id', 'nama'])->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'update-sku', 'enableAjaxValidation' => true]); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'user')->widget(Select2::classname(), [
        'data' => $modDesainer,
        'options' => ['placeholder' => 'Desainer'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'sku_kode')->textInput(['maxlength' => true]) ?>
    <?php if($initialPreview != null){ ?>

    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'previewFileType' => 'any',
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview,
            'initialCaption'=>true,
            'initialPreviewConfig' => $initialPreviewConfig,
            'overwriteInitial'=>false,
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'showFileInput' => false
        ],
    ]); ?>

    <?php }else{ ?>
        
    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
