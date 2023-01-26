<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Pembelian */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pembelian Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pembelian T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pembelian',
            'pembelian_tgl',
            'supplier',
            'pembelian_status',
            'us',
            //'faktur',
            //'pembelian_tempo',
            //'no_sj',
            //'keterangan:ntext',
            //'pembelian_diskon',
            //'akun',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
