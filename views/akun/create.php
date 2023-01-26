<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunT */

$this->title = 'Create Akun Bank';
$this->params['breadcrumbs'][] = ['label' => 'Akun Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
