<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProdukDetail */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Produk Detail Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produk-detail-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produk Detail T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'produk_detail',
            'penjualan_produk',
            'produk_item',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
