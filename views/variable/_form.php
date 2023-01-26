<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Divisi;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VariableT */
/* @var $form yii\widgets\ActiveForm */
$modDivisi = ArrayHelper::map(Divisi::find()->where('divisi > 2')->asArray()->all(), 'divisi', 'nama');
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $modDivisi,
        'options' => ['placeholder' => 'Pilih Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'val')->textInput() ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => ['Aktif' => 'Aktif', 'Non Aktif' => 'Non Aktif'],
        'options' => ['placeholder' => 'Status Setting'],
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
