<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PembelianBahan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pembelian Bahan Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-bahan-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pembelian Bahan T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pembelian_bahan',
            'pembelian',
            'bahan_baku',
            'item_bonus',
            'pembelian_jml',
            //'pembelian_berat',
            //'pembelian_harga',
            //'harga_jual',
            //'pembelian_bahan_status',
            //'jml_now',
            //'pembelian_bahan_date',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
