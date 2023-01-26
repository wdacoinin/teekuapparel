<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AkunLogT */

$this->title = $model->akun_log;
$this->params['breadcrumbs'][] = ['label' => 'Akun Log Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akun-log-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'akun_log' => $model->akun_log], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'akun_log' => $model->akun_log], [
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
            'akun_log',
            'inorout',
            'idref',
            'akun',
            'jml',
            'tgl',
            'user',
            'id_img',
        ],
    ]) ?>

</div>
