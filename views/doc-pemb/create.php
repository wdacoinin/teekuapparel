<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocPembT */

$this->title = 'Create Doc Pemb T';
$this->params['breadcrumbs'][] = ['label' => 'Doc Pemb Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-pemb-t-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
