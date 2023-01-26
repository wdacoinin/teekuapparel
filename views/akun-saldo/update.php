<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */

$this->title = 'Update Akun Saldo: ' . $model->akun_saldo;
$this->params['breadcrumbs'][] = ['label' => 'Akun Saldo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->akun_saldo, 'url' => ['view', 'akun_saldo' => $model->akun_saldo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akun-saldo-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modInorout' => $modInorout,
        'modAkun' => $modAkun
    ]) ?>

</div>
