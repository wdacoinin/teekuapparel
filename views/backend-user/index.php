<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use app\models\Divisi;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'User';
if(Yii::$app->user->identity->divisi == 1 ||  Yii::$app->user->identity->divisi == 2){
$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    'username',
    'nama',
    [
        'attribute'=>'divisi', 
        'value'=>'divisi0.nama',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Divisi::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'divisi', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Divisi'],
        'format'=>'raw'
    ],
    'phone', 
    [
        'class'=>'kartik\grid\ActionColumn',
        'dropdown'=>false,
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'id' => $model->id]; },
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
        'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  User</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah User</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah User']) . ' ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['user'=>'dynagrid-1'] // a unique identifier is important
]);
}else{
    echo '<h4 class="text-center"> Hanya bisa akses ke profile sendiri.</h4>';
}
?>
