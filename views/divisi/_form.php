<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\DivisiT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'des')->textarea(['rows' => 6]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => ['1' => 'Aktif', '0' => 'Non Aktif'],
        'options' => ['placeholder' => 'Status Divisi'],
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
