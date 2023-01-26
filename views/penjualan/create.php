<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = 'Create Order';
$this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
