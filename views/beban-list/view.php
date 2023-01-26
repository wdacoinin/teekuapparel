<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BebanListT */

$this->title = $model->beban_list;
$this->params['breadcrumbs'][] = ['label' => 'Beban List Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="beban-list-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'beban_list' => $model->beban_list], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'beban_list' => $model->beban_list], [
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
            'beban_list',
            'beban_owner',
            'akun',
            'beban',
            'jumlah',
            'detail:ntext',
            'tgl',
            'nama_foto',
            'type',
            'url:url',
        ],
    ]) ?>

</div>
