<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Akun Transaksi Bank';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    'akun_nama',
    'akun_ref',
    'an', 
    [
        'class'=>'kartik\grid\ActionColumn',
        'dropdown'=>false,
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'akun' => $model->akun]; },
        'viewOptions'=>['title'=>'Detail', 'data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['title'=>'Hapus', 'data-toggle'=>'tooltip'], 
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
        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Akun Transaksi Bank</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Akun Transaksi Bank</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Akun Bank']) . ' ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['akun'=>'dynagrid-1'] // a unique identifier is important
]);
?>
