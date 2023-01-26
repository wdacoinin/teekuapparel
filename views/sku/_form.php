<?php

use app\models\BackendUser;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\SkuT */
/* @var $form yii\widgets\ActiveForm */
$modDesainer = ArrayHelper::map(BackendUser::find()->select(['id', 'nama'])->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'sku', 'enableAjaxValidation' => true]); ?>

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

    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
