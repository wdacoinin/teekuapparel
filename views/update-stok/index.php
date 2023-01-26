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




/* echo json_encode($params);
die; */

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'pembelian0.faktur', 
        'value'=>'pembelian0.faktur',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'100px',
    ],
    [
        'attribute'=>'bahan_baku', 
        'value'=>'bahanBaku.nama',
        'vAlign'=>'middle',
        'width'=>'250px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BahanBaku::find()->orderBy('nama')->asArray()->all(), 'bahan_baku', 'nama'), 
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
        'attribute'=>'jml_now', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'bahanBaku.satuan', 
        'value'=>'bahanBaku.satuan',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BahanBaku::find()->groupBy('satuan')->orderBy('satuan')->asArray()->all(), 'satuan', 'satuan'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter by satuan'],
        'format'=>'raw'
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}',
        'buttons'=>[
           'update' => function($url, $model) { 
                if($model->pembelian_bahan !== null){

                    
                //diffrent controller
                $controller = Yii::$app->controller;
                $arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
                //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                $ud = 'index.php?r=' . $controller->id . '/update&pembelian_bahan=' . $model->pembelian_bahan;

                    return '<a class="btn btn-light modalButton" value="'. $ud . '"><i class="fas fa-long-arrow-alt-right"></i> Update Stok</a>';
                }else{
                    return null;
                }
            },

        ],
        
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
        'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i> Stok Bahan By Pembelian</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>*Update Stok Sekarang(sisa)</em></div>',
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
    'options'=>['pembelian_bahan'=>'dynagrid-1'] // a unique identifier is important
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
        'title' => '<h2>Update Stok</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->

<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .35rem;
	}
</style>