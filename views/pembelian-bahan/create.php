<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianBahanT */

$this->title = 'Create Pembelian Bahan';
$this->params['breadcrumbs'][] = ['label' => 'Pembelian Bahan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
