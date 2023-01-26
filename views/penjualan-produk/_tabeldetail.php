<?php

use app\models\ProdukItemT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'ADD ITEM TAMBAHAN';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'label' => 'Item',
        'value'=>function ($model, $key, $index, $widget) { 
            $moditem = ProdukItemT::findOne($model->produk_item);
            return $moditem->produk_item_nama;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>false
    ],
    [
        'label' => 'Harga',
        'value'=>function ($model, $key, $index, $widget) { 
            $moditem = ProdukItemT::findOne($model->produk_item);
            return $moditem->produk_item_harga;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{delete}',
        'urlCreator'=>function($action, $model, $key, $index) { 
            if($action === 'delete'){
                $url = Yii::$app->urlManager->createUrl(['penjualan-produk/deletedetail', 'produk_detail' => $model->produk_detail, 'penjualan_produk' => $model->penjualan_produk]);
                return $url;
            }
        },
        'dropdown'=>true,
        'order'=>DynaGrid::ORDER_FIX_RIGHT
        /* 'dropdown'=>true,
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'produk' => $model->produk]; },
        'viewOptions'=>['visible'=>false],
        'updateOptions'=>['title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['title'=>'Hapus', 'data-toggle'=>'tooltip'],  */
    ],
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  ADD ITEM TAMBAHAN</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-primary modalButton" value="'.Url::to(['produk-detail/create', 'penjualan_produk' => $penjualan_produk]).'"><i class="fas fa-plus"></i> Input Produk Detail</a>'
            ],
            //['content'=>'{dynagrid}'],
            //'{export}',
        ]
    ],
    'options'=>['id'=>'produk-detail'] // a unique identifier is important
]);
?>
