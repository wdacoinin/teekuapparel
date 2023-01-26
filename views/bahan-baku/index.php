<?php

use app\models\BackendUser;
use app\models\Supplier;
use app\models\PembelianView;
use app\models\BahanBaku;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\bootstrap5\Modal;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Bahan Baku';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'dropdown'=>false,
    'header'=>'Hapus',
    'template' => '{delete}',
    'urlCreator'=>function($action, $model, $key, $index) { 
            return [$action, 'bahan_baku' => $model->bahan_baku]; 
    },
    'deleteOptions'=>['title'=>'Hapus', 'data-toggle'=>'tooltip'], 
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
}else{
    $act = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'bahan_baku', 
        'value'=>'nama',
        'vAlign'=>'middle',
        'width'=>'150px',
        'value'=>function ($model, $key, $index, $widget) { 
            return Html::a('<i class="fas fa-edit"></i> ' . $model->nama, ['bahan-baku/update', 'bahan_baku' => $model->bahan_baku], ['class' => 'btn btn-sm btn-outline-primary'], [
                'title'=>'Lihat detail Bahan Baku', 
            ]);
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BahanBaku::find()->orderBy('bahan_baku')->asArray()->all(), 'bahan_baku', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Bahan'],
        'format'=>'raw'
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
        'filterInputOptions'=>['placeholder'=>'Satuan'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'harga', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'kode', 
        'value'=>'kode',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BahanBaku::find()->groupBy('kode')->orderBy('kode')->asArray()->all(), 'kode', 'kode'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Kode'],
        'format'=>'raw'
    ],
    $act,
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Bahan</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat Bahan</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['bahan-baku/create']).'"><i class="fas fa-plus"></i> Input Bahan</a>  ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['bahan-baku'=>'dynagrid-1'] // a unique identifier is important
]);
?>

<!-- <h3>Selamat datang <?php //echo Yii::$app->user->identity->nama ?> di aplikasi Teekuapparel</h3> -->

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
        'title' => '<h2>Bahan Form</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->

<script type='text/javascript'>
    $('.modal-dialog').draggable({
        "handle":".modal-header"
      });
    $( document ).ready( function () {

	$('#collapseDetail .collapse').slideToggle('show')
	//$('#collapseDetail').slideToggle('show');

    $('.minimized').on('click', function(){
        $(this).addClass('hide');
        $('.maximized').removeClass('hide');
	    $('#collapseDetail').slideToggle("slow");
    });

    $('.maximized').on('click', function(){
        $(this).addClass('hide');
        $('.minimized').removeClass('hide');
	    $('#collapseDetail').slideToggle("slow");
    });

    } );
</script>
<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .35rem;
	}
</style>