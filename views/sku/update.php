<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SkuT */

$this->title = 'Update Sku: ' . $model->sku_kode;
$this->params['breadcrumbs'][] = ['label' => 'Sku', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->sku, 'url' => ['view', 'sku' => $model->sku]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
        'UpForm' => $UpForm,
    ]) ?>

</div>
