<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocPembT */

$this->title = 'Update Doc Pemb T: ' . $model->id_img;
$this->params['breadcrumbs'][] = ['label' => 'Doc Pemb Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_img, 'url' => ['view', 'id_img' => $model->id_img]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doc-pemb-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
