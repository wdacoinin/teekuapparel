<?php

use yii\helpers\Html;
use app\models\BackendUser;
use app\models\Pembelian;
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
        'value'=>'idref',
        'vAlign'=>'middle',
        'width'=>'250px',
        'value'=>function ($model, $key, $index, $widget) { 
            return Html::a($model->faktur, ['pembelian/update', 'pembelian' => $model->idref], [
                'title'=>'Lihat detail pembelian', 
            ]);
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Pembelian::find()->orderBy('faktur')->asArray()->all(), 'pembelian', 'faktur'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Faktur'],
        'format'=>'raw'
    ],
    'akun_nama',
    [
        'attribute'=>'inorout', 
        'value'=>'inorout',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['Cicil' => 'Cicil', 'Pembelian' => 'Pembelian'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'admin', 
        'value'=>'admin',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where('4 > divisi AND divisi > 1')->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter by Admin'],
        'format'=>'raw'
    ],
    [
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
    ],
    [
        'attribute'=>'jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    /* [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}',
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'akun_log' => $model->akun_log]; },
        'dropdown'=>true,
        'order'=>DynaGrid::ORDER_FIX_RIGHT
    ], */
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Transaksi pembelian/Cicil pembelian</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Histori Transaksi pengeluaran by akun rekening Bank</em></div>',
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
    'options'=>['akun_log'=>'dynagrid-1'] // a unique identifier is important
]);
?>