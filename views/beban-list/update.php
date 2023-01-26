<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BebanListT */

$this->title = 'Update Beban: ' . $model->beban_list;
$this->params['breadcrumbs'][] = ['label' => 'Beban List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->beban_list, 'url' => ['view', 'beban_list' => $model->beban_list]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="beban-list-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'UpForm' => $UpForm,
    ]) ?>

</div>
