<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VariableT */

$this->title = 'Update Teekuapparel Setting: ' . $model->variable;
$this->params['breadcrumbs'][] = ['label' => 'Teekuapparel Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->variable, 'url' => ['view', 'variable' => $model->variable]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="variable-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
