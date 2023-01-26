<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */
$modDivisi = ArrayHelper::map(Divisi::find()->asArray()->all(), 'divisi', 'nama');
?>

<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['type' => 'hidden', 'value' => Yii::$app->user->identity->password])->label(false) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php if(Yii::$app->user->identity->divisi == 1 ||  Yii::$app->user->identity->divisi == 2){ ?>
    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $modDivisi,
        'options' => ['placeholder' => 'Pilih Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>
    <?php }else{  ?>
    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $modDivisi,
        'options' => ['placeholder' => 'Pilih Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'disabled' => true
    ]); 
    ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        <?php if(Yii::$app->user->identity->divisi == 1 ||  Yii::$app->user->identity->divisi == 2){ ?>
            <a class="btn btn-warning modalButton" value="<?= Url::to(['backend-user/change', 'id' => $model->id]) ?>"><i class="fas fa-key"></i> Ubah Password</a>
        <?php }else{ 
            if($model->id == Yii::$app->user->identity->id){?>
                <a class="btn btn-warning modalButton" value="<?= Url::to(['backend-user/change', 'id' => $model->id]) ?>"><i class="fas fa-key"></i> Ubah Password</a>
        <?php }
        } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton').click( function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2>Form</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->

<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .55rem;
	}
</style>