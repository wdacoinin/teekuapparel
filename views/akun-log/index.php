<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Transaksi Akun Bank';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    'label',
    [
        'attribute'=>'jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'nama_divisi',
        'filter' => false
    ],
    [
        'attribute'=>'nama_user',
        'filter' => false
    ],
    [
        'attribute'=>'start',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'start',
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
            "apply.daterangepicker" => "function() { apply_filter('start') }",
          ],
        ])
    ],
    [
        'attribute'=>'end',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'end',
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
            "apply.daterangepicker" => "function() { apply_filter('end') }",
          ],
        ])
    ],
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Transaksi Keluar Masuk</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Untuk Input Baru</em></div>',
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
    'options'=>['penjualan_produk_step'=>'dynagrid-1'] // a unique identifier is important
]);
?>