<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunLogT */

$this->title = 'Update Akun Log T: ' . $model->akun_log;
$this->params['breadcrumbs'][] = ['label' => 'Akun Log Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->akun_log, 'url' => ['view', 'akun_log' => $model->akun_log]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akun-log-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
