<?php

use yii\helpers\Html;
use app\models\BackendUser;
use app\models\Penjualan;
use app\models\Konsumen;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Transaksi Akun Bank';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'faktur', 
        'value'=>'faktur',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Penjualan::find()->orderBy('faktur')->asArray()->all(), 'faktur', 'faktur'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Faktur'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'konsumen_nama', 
        'value'=>'konsumen_nama',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Konsumen::find()->orderBy('konsumen_nama')->asArray()->all(), 'konsumen_nama', 'konsumen_nama'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'penjualan_tgl',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'penjualan_tgl',
          'presetDropdown' => true,
          'convertFormat' => false,
          'pluginOptions' => [
            'separator' => ' - ',
            'format' => 'YYYY-MM-DD',
            'locale' => [
                  'format' => 'YYYY-MM-DD'
              ],
          ],
          'pluginEvents' => [
            "apply.daterangepicker" => "function() { apply_filter('penjualan_tgl') }",
          ],
        ])
    ],
    [
        'attribute'=>'subtotal', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_bahan', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_kotor', 
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
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Report Penjualan Kotor</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Penjualan</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['penjualan'=>'dynagrid-1'] // a unique identifier is important
]);
?>