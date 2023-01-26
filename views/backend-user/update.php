<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */

$this->title = 'Update Login User: ' . $model->nama;
//$this->params['breadcrumbs'][] = ['label' => 'Login Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
