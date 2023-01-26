<?php

use app\models\DivisiT;
use app\models\PenjualanStepT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Ordertrackv */
/* @var $form yii\widgets\ActiveForm */
$modDD = PenjualanStepT::find()->select('GROUP_CONCAT(divisi) AS divisi')->where(['penjualan' => $model->penjualan])->asArray()->one();

if($modDD != null){
    $divisi = ArrayHelper::map(DivisiT::find()->where('divisi NOT IN('.$modDD['divisi'].')')->andWhere('divisi > 5')->orderBy('divisi ASC')->asArray()->all(), 'divisi', 'nama');
}else{
    $divisi = ArrayHelper::map(DivisiT::find()->where('divisi > 4')->orderBy('divisi ASC')->asArray()->all(), 'divisi', 'nama');
}

?>


<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'upd-ordertrack', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'jml')->textInput(['type' => 'number', 'min' => 1, 'max' => $model->jml, 'step' => 1 ]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $divisi,
        'options' => ['placeholder' => 'Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
