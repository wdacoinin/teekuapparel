<?php

use app\models\BackendUser;
use app\models\Supplier;
use app\models\PembelianView;
use app\models\Divisi;
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
$this->title = 'Pembelian';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'dropdown'=>false,
    'header'=>'Hapus',
    'template' => '{delete}',
    'urlCreator'=>function($action, $model, $key, $index) { 
            return [$action, 'pembelian' => $model->pembelian]; 
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
        'attribute'=>'pembelian', 
        'value'=>'pembelian',
        'vAlign'=>'middle',
        'width'=>'150px',
        'value'=>function ($model, $key, $index, $widget) { 
            return Html::a('<i class="fas fa-edit"></i> ' . $model->faktur, ['pembelian/update', 'pembelian' => $model->pembelian], ['class' => 'btn btn-sm btn-outline-primary'], [
                'title'=>'Lihat detail pembelian', 
            ]);
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(PembelianView::find()->orderBy('faktur')->asArray()->all(), 'pembelian', 'faktur'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Faktur'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'supplier_nama', 
        'value'=>'supplier_nama',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Supplier::find()->orderBy('supplier_nama')->asArray()->all(), 'supplier_nama', 'supplier_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Supplier'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'pembelian_tgl',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'pembelian_tgl',
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
            "apply.daterangepicker" => "function() { apply_filter('pembelian_tgl') }",
          ],
        ])
    ],
    [
        'attribute'=>'pembelian_tempo',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'pembelian_tempo',
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
            "apply.daterangepicker" => "function() { apply_filter('pembelian_tempo') }",
          ],
        ])
    ],
    [
        'attribute'=>'nama', 
        'value'=>'nama',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where(['divisi' => 3])->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Admin'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'total', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'pembelian_diskon', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_bayar', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'hutang', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    $act,
];
    
echo DynaGrid::widget([
    'columns' => $columns,
    'theme'=>'panel-info',
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dp,
        'filterModel'=>$sm,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Pembelian</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat Pembelian</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['pembelian/create']).'"><i class="fas fa-plus"></i> Input Pembelian</a>  ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['pembelian'=>'dynagrid-1'] // a unique identifier is important
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
        'title' => '<h2>Pembelian Form</h2>',
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