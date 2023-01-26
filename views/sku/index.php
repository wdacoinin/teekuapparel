<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'SKU';

$act = 
[
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'100px',
    'hAlign'=>'center', 
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{update}{delete}',
    'buttons'=>[
        'update' => function($url, $model) { 
            $ud = 'index.php?r=sku/update&sku=' . $model->sku;
            return '<div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a></div>';
        },
        'delete' => function($url, $model){
            $controller = Yii::$app->controller;
            return '<a class="dropdown-item" href="'.Url::to(['sku/delete', 'sku' => $model->sku]).'" title="Delete" aria-label="Delete" data-pjax="0" data-method="post" data-confirm="Are you sure to delete this item?" tabindex="-1"><i class="align-middle" data-feather="trash-2"></i> Delete</a>';
        },
    ],
    'dropdown'=>true,
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
    'sku_kode',
    [
        'attribute'=>'user0.nama', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>false
    ],
    $act,
];
if(Yii::$app->user->identity->divisi <= 2){
    $inp = '<a class="btn btn-sm btn-primary modalButton" value="'.Url::to(['sku/create']).'"><i class="fas fa-plus"></i> Input SKU</a>  ' ;
}else{
    $inp = null;
}
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  SKU</h3>' ,
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat SKU</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                $inp .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['id'=>'sku-tabel'] // a unique identifier is important
]);
?>

<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton').click( function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2>PO Form</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->