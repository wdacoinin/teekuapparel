<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */

$this->title = 'Akun Saldo';
$this->params['breadcrumbs'][] = ['label' => 'Akun Saldo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modInorout' => $modInorout,
        'modAkun' => $modAkun
    ]) ?>

</div>
