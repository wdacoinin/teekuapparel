<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BahanBakuSoT */

$this->title = 'Create Bahan Baku So T';
$this->params['breadcrumbs'][] = ['label' => 'Bahan Baku So Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bahan-baku-so-t-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
