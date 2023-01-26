<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PenjualanProduk */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penjualan Produk Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-produk-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Penjualan Produk T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'penjualan_produk',
            'penjualan',
            'produk',
            'bahan_baku',
            'penjualan_jml',
            //'penjualan_hpp',
            //'penjualan_harga',
            //'penjualan_produksi_status',
            //'retur_qty',
            //'retur_date',
            //'item_from_retur',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
