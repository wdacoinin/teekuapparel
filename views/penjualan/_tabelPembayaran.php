<?php

use yii\helpers\Html;
use app\models\BackendUser;
use app\models\Penjualan;
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
        'attribute'=>'akun_nama', 
        'vAlign'=>'middle',
        'filter'=>false,
    ],
    [
        'attribute'=>'inorout', 
        'vAlign'=>'middle',
        'filter'=>false,
    ],
    [
        'attribute'=>'admin', 
        'vAlign'=>'middle',
        'filter'=>false,
    ],
    [
        'attribute'=>'tgl', 
        'vAlign'=>'middle',
        'filter'=>false,
    ],
    /* [
        'attribute'=>'tgl',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'tgl',
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
            "apply.daterangepicker" => "function() { apply_filter('tgl') }",
          ],
        ])
    ], */
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
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{delete}',
        'urlCreator'=>function($action, $model, $key, $index) { 
            if($action === 'delete'){
                $url = Yii::$app->urlManager->createUrl(['penjualan/deletebayar', 'akun_log' => $model->akun_log, 'penjualan' => $model->idref, 'id_img' => $model->id_img]);
                return $url;
            }
             
        },
        'dropdown'=>false,
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
        //'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>false,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h4 class="panel-title"><i class="fas fa-book"></i>  Transaksi Penjualan/Dp Penjualan</h4> 
            <a class="btn btn-sm btn-light modalButton" value="'.Url::to(['akun-log/create', 'penjualan'=> $_GET['penjualan']]).'"><i class="fas fa-plus"></i> Input Pembayaran</a>' ,
            /* 'before' =>  '<div style="padding-top: 7px;"><em>* Histori Transaksi pemasukan by akun rekening Bank</em></div>', */
            'before' => false,
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-redo-alt"></i>', ['', 'penjualan'=> $_GET['penjualan']], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagrid}'],
        ]
    ],
    'options'=>['akun_log'=>'dynagrid-1'] // a unique identifier is important
]);
?>