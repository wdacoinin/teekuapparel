<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Rev */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rev Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rev-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rev T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rev',
            'penjualan',
            'user',
            'note:ntext',
            'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
