<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BebanListT */

$this->title = 'Pengeluaran Kas Kecil';
$this->params['breadcrumbs'][] = ['label' => 'Beban Kas Kecil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'UpForm' => $UpForm,
    ]) ?>

</div>
