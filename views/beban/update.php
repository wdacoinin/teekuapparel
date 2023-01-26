<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BebanT */

$this->title = 'Update Beban: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Beban', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'beban' => $model->beban]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-4">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
