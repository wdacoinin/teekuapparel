<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukDetailT */

$this->title = 'Input Item Tambahan';
//$this->params['breadcrumbs'][] = ['label' => 'Produk Detail Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
