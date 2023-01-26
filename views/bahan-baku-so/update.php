<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuSoT */

$this->title = 'Update Bahan Baku So T: ' . $model->bahan_baku_so;
$this->params['breadcrumbs'][] = ['label' => 'Bahan Baku So Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bahan_baku_so, 'url' => ['view', 'bahan_baku_so' => $model->bahan_baku_so]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bahan-baku-so-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
