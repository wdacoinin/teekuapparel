<?php

use app\models\ProdukItemT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Produk Detail';

$act = 
[
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'100px',
    'hAlign'=>'center', 
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{update}',
    'buttons'=>[
        'update' => function($url, $model) { 
            $ud = 'index.php?r=penjualan-produk/updatenick&penjualan_produk=' . $model->penjualan_produk;
            return '<div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update Nickname</a></div>';
        },
    ],
    'dropdown'=>false,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'label'=>'Img',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return '<img src="'.$model->url.'" width="100" />';
            
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'40px',
        'format'=>'raw'
    ],
    [
        'attribute'=>'sku_kode', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>false,
    ],
    [
        'attribute'=>'nama', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>false,
    ],
    [
        'attribute'=>'item', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>false
    ],
    [
        'label'=>'Nickname', 
        'value'=>function ($model, $key, $index, $widget) { 
            return nl2br($model->nick);
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>false,
        'format'=>'raw'
    ],
    [
        'label' => 'Qty',
        'attribute'=>'penjualan_jml',
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label' => 'Total',
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->total_detail + $model->subtotal;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    $act,
];
    
echo DynaGrid::widget([
    'columns' => $columns,
    'theme'=>'simple-striped',
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        //'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  ORDER DETAIL</h3>',
            'before' =>  false,
            'after' => false
        ],
        'toolbar' =>  [
            /* ['content'=>
            '<a class="btn btn-sm btn-primary modalButton" value="'.Url::to(['produk-detail/create', 'penjualan_produk' => $penjualan_produk]).'"><i class="fas fa-plus"></i> Input Produk Detail</a>'
            ], */
            //['content'=>'{dynagrid}'],
            //'{export}',
        ]
    ],
    'options'=>['id'=>'penjualan-produk-detail'] // a unique identifier is important
]);
?>
