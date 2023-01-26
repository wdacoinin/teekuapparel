<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Teekuapparel Setting';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'nama',
        'filter'=>false
    ],
    [
        'attribute'=>'divisi',
        'filter'=>false
    ],
    [
        'attribute'=>'val', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'detail',
        'filter'=>false
    ],
    [
        'attribute'=>'status',
        'filter'=>false
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update} {delete}',
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'variable' => $model->variable]; },
        'dropdown'=>true,
        'order'=>DynaGrid::ORDER_FIX_RIGHT
        /* 'dropdown'=>true,
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'variable' => $model->variable]; },
        'viewOptions'=>['visible'=>false],
        'updateOptions'=>['title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['title'=>'Hapus', 'data-toggle'=>'tooltip'],  */
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Setting</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>*Setting</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Setting']) . ' ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['variable'=>'dynagrid-1'] // a unique identifier is important
]);
?>
