<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocPenjT */

$this->title = 'Create Doc Penj T';
$this->params['breadcrumbs'][] = ['label' => 'Doc Penj Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-penj-t-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
