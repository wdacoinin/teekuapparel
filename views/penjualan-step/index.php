<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PenjualanStep */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penjualan Step Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-step-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Penjualan Step T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'penjualan_step',
            'penjualan',
            'jml',
            'divisi',
            'start',
            //'end',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
