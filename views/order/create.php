<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ordertrackv */

$this->title = 'Update Order Track';
//$this->params['breadcrumbs'][] = ['label' => 'Ordertrackvs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <?= $this->render('_form', [
        'model' => $model,
        'selectedStep' => $selectedStep,
    ]) ?>

</div>
