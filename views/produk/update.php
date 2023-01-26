<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukT */

$this->title = 'Update Produk: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Produk', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'produk' => $model->produk]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row p-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
