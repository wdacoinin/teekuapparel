<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierT */

$this->title = $model->supplier_nama;
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'supplier' => $model->supplier], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'supplier' => $model->supplier], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'supplier',
            'supplier_nama',
            'supplier_detail',
        ],
    ]) ?>

</div>
