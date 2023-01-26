<?php

use yii\helpers\Html;
use app\models\BackendUser;
use app\models\BahanBaku;
use app\models\Pembelian;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Global Stok';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'nama', 
        'value'=>'nama',
        'vAlign'=>'middle',
        'width'=>'250px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BahanBaku::find()->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Nama'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'pembelian_jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'stok_out', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'jml_now', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'satuan', 
        'value'=>'satuan',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BahanBaku::find()->groupBy('satuan')->orderBy('satuan')->asArray()->all(), 'satuan', 'satuan'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter by satuan'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'harga_satuan', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>false,
        'filter'=>false
    ],
    [
        'attribute'=>'total', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Global Stok Bahan</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>*Stok Bahan</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['stok_bahan'=>'dynagrid-1'] // a unique identifier is important
]);
?>