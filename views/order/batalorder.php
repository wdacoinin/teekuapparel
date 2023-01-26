<?php

use app\models\BackendUser;
use app\models\Konsumen;
use app\models\Order;
use app\models\Divisi;
use app\models\DivisiT;
use app\models\DocPenjualanProduk;
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
$this->title = 'Order';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'penjualan', 
        'value'=>'penjualan',
        'vAlign'=>'middle',
        'width'=>'80px',
        'value'=>function ($model, $key, $index, $widget) { 
            $im = DocPenjualanProduk::find()->where(['doc_penjualan_produk.penjualan' => $model->penjualan])
            ->join('LEFT JOIN', 'user', 'doc_penjualan_produk.user = user.id')
            ->join('LEFT JOIN', 'divisi', 'user.divisi = divisi.divisi')
            ->orderBy('doc_penjualan_produk.id_img DESC')->limit(1)->asArray()->one();
            if($im != null){
                if($model->acc_desain > 0){
                    return
                    '<img src="'.$im['url'].'" width="100%" />  <a class="btn btn-sm btn-success btn-block" target="_blank" href="'.$im['url'].'"> View</a>' . 
                    Html::a('<i class="fas fa-edit"></i> ' . $model->faktur, ['penjualan/update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-sm btn-block btn-outline-primary mt-2'], [
                        'title'=>'Lihat detail penjualan', 
                    ]);
                }else{
                    return Html::a('<i class="fas fa-edit"></i> ' . $model->faktur, ['penjualan/update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-sm btn-block btn-outline-primary'], [
                        'title'=>'Lihat detail penjualan', 
                    ]);
                }
            }else{

                return Html::a('<i class="fas fa-edit"></i> ' . $model->faktur, ['penjualan/update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-sm btn-block btn-outline-primary'], [
                    'title'=>'Lihat detail penjualan', 
                ]);
            }
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
        'attribute'=>'konsumen_nama', 
        'value'=>'konsumen_nama',
        'vAlign'=>'middle',
        'width'=>'60px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Konsumen::find()->orderBy('konsumen_nama')->asArray()->all(), 'konsumen_nama', 'konsumen_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Konsumen'],
        'format'=>'raw'
    ],
    [
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
    ],
    [
        'label' => 'Agen',
        'attribute'=>'nama_sales', 
        'value'=>'nama_sales',
        'vAlign'=>'middle',
        'width'=>'70px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where(['divisi' => 4])->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Sales'],
        'format'=>'raw'
    ],
    [
        'label' => 'Desainer',
        'attribute'=>'desainer', 
        'value'=>function ($model, $key, $index, $widget) { 
            $moDd = BackendUser::findOne((int) $model->desainer);
            if($moDd != null){
                return $moDd->nama;
            }else{
                return '-';
            }
        },
        'vAlign'=>'middle',
        'width'=>'70px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where('divisi = 5 OR id = 2')->orderBy('nama')->asArray()->all(), 'id', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Sales'],
        'format'=>'raw'
    ],
    [
        'label'=>'Total', 
        'value'=>function ($model, $key, $index, $widget) { 
            $modtambahan = PenjualanProdukDetailv::find()->select('SUM(total_detail) AS total_detail')->where(['penjualan' => $model->penjualan])->asArray()->one();
            return $model->Total + $modtambahan['total_detail'];
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Total Bayar', 
        'value'=>function ($model, $key, $index, $widget) { 
            if($model->total_bayar > 0){
                return $model->total_bayar;
            }else{
                return 0;
            }
            
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Piutang', 
        'value'=>function ($model, $key, $index, $widget) { 
            $modtambahan = PenjualanProdukDetailv::find()->select('SUM(total_detail) AS total_detail')->where(['penjualan' => $model->penjualan])->asArray()->one();
            $tot = $model->Total + $modtambahan['total_detail'];
            return $tot - $model->total_bayar;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
];
Yii::$app->getModule('dynagrid')->defaultPageSize = 100;
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
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Batal Order</h3>',
            'before' =>  false,
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['penjualan/create']).'"><i class="fas fa-plus"></i> Input Order</a>  ' .
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
        'title' => '<h2>PO Form</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
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