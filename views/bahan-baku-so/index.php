<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BahanBakuSo */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bahan Baku So Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bahan-baku-so-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bahan Baku So T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bahan_baku_so',
            'bahan_baku',
            'pembelian_bahan',
            'jml',
            'berat',
            //'date',
            //'us',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
