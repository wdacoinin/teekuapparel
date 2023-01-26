<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunLogT */

$this->title = 'Pembayaran Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Pembayaran Pembelian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akun-log-t-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'modInorout' => $modInorout,
        'modAkun' => $modAkun,
        'UpForm' => $UpForm,
    ]) ?>

</div>
