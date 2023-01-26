<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanStepT */

$this->title = 'Create Penjualan Step T';
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Step Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-step-t-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
