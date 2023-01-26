<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianT */

$this->title = 'Update Pembelian: ' . $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'Pembelian', 'url' => ['pembelian-view/index']];
$this->params['breadcrumbs'][] = ['label' => $model->faktur, 'url' => ['view', 'pembelian' => $model->pembelian]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
            'model' => $model,
            'modPembelianBahan' => $modPembelianBahan,
            'PembelianBahan' => $PembelianBahan,
            'DocPemb' => $DocPemb,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]) ?>

</div>
