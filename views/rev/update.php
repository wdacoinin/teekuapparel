<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RevT */

$this->title = 'Update Rev T: ' . $model->rev;
$this->params['breadcrumbs'][] = ['label' => 'Rev Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rev, 'url' => ['view', 'rev' => $model->rev]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rev-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
