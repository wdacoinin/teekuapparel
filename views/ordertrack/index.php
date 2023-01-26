<?php

use app\models\BackendUser;
use app\models\Konsumen;
use app\models\Order;
use app\models\Divisi;
use app\models\DivisiT;
use app\models\DocPenjualanProdukT;
use app\models\PenjualanProdukDetailv;
use app\models\PenjualanStepT;
use app\models\PenjualanT;
use app\models\RevT;
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
$this->title = 'Order Track';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 3){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'100px',
    'hAlign'=>'center', 
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{update}',
    'buttons'=>[
        'update' => function($url, $model) { 
            $ud = 'index.php?r=ordertrack/update&penjualan=' . $model->penjualan . '&penjualan_step=' . $model->penjualan_step;
            return '<div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a></div>';
        },
    ],
    'dropdown'=>false,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
}else{
    $act = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'penjualan', 
        'value'=>'penjualan',
        'vAlign'=>'middle',
        'width'=>'80px',
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->faktur;
            /* return Html::a('<i class="fas fa-edit"></i> ' . $model->faktur, ['penjualan/update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-sm btn-block btn-outline-primary'], [
                'title'=>'Lihat detail penjualan', 
            ]); */
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Order::find()->orderBy('faktur')->asArray()->all(), 'penjualan', 'faktur'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Faktur'],
        'format'=>'raw'
    ],
    [
        'label' => 'Divisi',
        'attribute'=>'divisi', 
        'value'=>function ($model, $key, $index, $widget) { 
            $div = DivisiT::findOne($model->divisi);
            return $div->nama;
            /* return Html::a('<i class="fas fa-edit"></i> ' . $model->faktur, ['penjualan/update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-sm btn-block btn-outline-primary'], [
                'title'=>'Lihat detail penjualan', 
            ]); */
        },
        'vAlign'=>'middle',
        'width'=>'70px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(DivisiT::find()->where('divisi > 4')->orderBy('divisi ASC')->asArray()->all(), 'divisi', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Divisi'],
        'format'=>'raw'
    ],
    [
        'label' => 'User Update',
        'value'=>function ($model, $key, $index, $widget) { 
            $ps = PenjualanStepT::findOne($model->penjualan_step);
            $us = BackendUser::findOne($ps->user);
            if($us != null){
                return $us->nama;
            }else{
                return '-';
            }
        },
        'vAlign'=>'middle',
        'width'=>'60px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where('id > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'User'],
        'format'=>'raw'
    ],
    /* [
        'attribute'=>'penjualan_tgl',
        'width'=>'60px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'penjualan_tgl',
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
            "apply.daterangepicker" => "function() { apply_filter('penjualan_tgl') }",
          ],
        ])
    ], */
    [
        'attribute'=>'jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    $act,
];
Yii::$app->getModule('dynagrid')->defaultPageSize = 100;
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Order Track</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em></em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                //'<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['penjualan/create']).'"><i class="fas fa-plus"></i> Input Order</a>  ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['penjualan'=>'dynagrid-1'] // a unique identifier is important
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
        'title' => '<h2>Update Order Track</h2>',
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