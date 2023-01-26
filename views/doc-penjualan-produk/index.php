<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocPenjualanProduk */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Doc Penjualan Produk Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-penjualan-produk-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Doc Penjualan Produk T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_img',
            'penjualan_produk',
            'Nama_Foto',
            'type',
            'size',
            //'url:url',
            //'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
