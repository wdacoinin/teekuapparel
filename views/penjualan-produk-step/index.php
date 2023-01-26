<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Order Tracking';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    'produk0.nama',
    'divisi',
    'start',
    'end',
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}',
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'penjualan_produk_step' => $model->penjualan_produk_step]; },
        'dropdown'=>true,
        'order'=>DynaGrid::ORDER_FIX_RIGHT
    ],
];
    
echo DynaGrid::widget([
    'columns' => $columns,
    'theme'=>'panel-info',
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Order Tracking</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Untuk Input Baru</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah']) . ' ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['penjualan_produk_step'=>'dynagrid-1'] // a unique identifier is important
]);
?>
