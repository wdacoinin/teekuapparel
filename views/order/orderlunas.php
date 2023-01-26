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
$this->title = 'Order Lunas';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 3){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'dropdown'=>false,
    'header'=>'Batal Order',
    'width'=>'20px',
    'template' => '{delete}',
    'urlCreator'=>function($action, $model, $key, $index) { 
                $modP = PenjualanT::findOne($model->penjualan);
                if($modP->hprint == 0){
                    if($modP->penjualan_status == 'Piutang'){
                        return [$action, 'penjualan' => $model->penjualan];
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
    },
    'deleteOptions'=>['title'=>'Hapus', 'data-toggle'=>'tooltip', 'data-confirm'=>'Batalkan order ini?'], 
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
}else{
    $act = [];
}
if(Yii::$app->user->identity->divisi <= 5){
    $st = [
        'label'=>'Desain', 
        'value'=>function ($model, $key, $index, $widget) { 
            $modDP = DocPenjualanProdukT::find()
            ->join("LEFT JOIN", "user", "doc_penjualan_produk.user=user.id")
            ->where(['doc_penjualan_produk.penjualan' => $model->penjualan])
            ->andWhere('user.divisi IN(1, 2, 5)')
            ->asArray()->count();
            $modp = PenjualanT::findOne($model->penjualan);
            if($modDP > 0 && $modp->acc_desain == 0){
                return '<i class="fas fa-image"></i> Wait Acc';
            /* }elseif($modDP == 0 && $modp->acc_desain == 0){
                return '<i class="fas fa-image"></i> Wait Desain'; */
            }elseif($modDP > 0 && $modp->acc_desain > 0){
                if($modp->penjualan_status == 'Lunas'){
                    return '<i class="fas fa-image"></i> <i class="fas fa-check-double ml-1 text-success"></i> Acc';
                }else{
                    return '<i class="fas fa-image"></i><br> <i class="fas fa-check-double ml-1 text-success"></i> '.$modp->acc_date.' Acc';
                }
            }else{
                return '<i class="far fa-clock"></i> Wait Desain';
            }
        },
        'contentOptions' => ['style' => 'font-size:7px;!important'],
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'filter'=>false,
        'format'=>'raw'
    ];
    $rev = [
        'label'=>'Revisi', 
        'value'=>function ($model, $key, $index, $widget) { 
            $modDP = RevT::find()->select('rev_st')
            //->where(['rev_st' => 0, 'penjualan' => $model->penjualan])
            ->where(['penjualan' => $model->penjualan])
            ->orderBy('rev DESC')->limit(1)
            ->asArray()->one();
            $modStep = PenjualanStepT::find()->where(['penjualan' => $model->penjualan])->orderBy('penjualan_step DESC')->limit(1)->asArray()->one();
            if($modDP != null){
                if((int) $modDP['rev_st'] > 0){
                    if($modStep != null && Yii::$app->user->identity->divisi < 4){
                        $modDiv = DivisiT::findOne($modStep['divisi']);
                        $ud = 'index.php?r=order/updatetrack&penjualan=' . $model->penjualan . '&penjualan_step=' . $modStep['penjualan_step'];
                        return '<i class="fas fa-image"></i> <i class="fas fa-check-double ml-1 text-success"></i> Done <br>
                        <div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '">'.$modDiv->nama.'</a></div>';
                    }else if($modStep != null && Yii::$app->user->identity->divisi == 4){
                        $modDiv = DivisiT::findOne($modStep['divisi']);
                        return '<i class="fas fa-image"></i> <i class="fas fa-check-double ml-1 text-success"></i> Done <br><a class="btn btn-light">'.$modDiv->nama.'</a>';
                    }else{
                        return '<i class="fas fa-image"></i> <i class="fas fa-check-double ml-1 text-success"></i> Done';
                    }
                }else{
                    if($modStep != null && Yii::$app->user->identity->divisi < 4){
                        $modDiv = DivisiT::findOne($modStep['divisi']);
                        $ud = 'index.php?r=order/updatetrack&penjualan=' . $model->penjualan . '&penjualan_step=' . $modStep['penjualan_step'];
                        return '<i class="far fa-clock"></i> Wait Desain <br>
                        <div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '">'.$modDiv->nama.'</a></div>';
                    }else if($modStep != null && Yii::$app->user->identity->divisi == 4){
                        $modDiv = DivisiT::findOne($modStep['divisi']);
                        return '<i class="far fa-clock"></i> Wait Desain <br><a class="btn btn-light">'.$modDiv->nama.'</a>';
                    }else{
                        return '<i class="far fa-clock"></i> Wait Desain';
                    }
                }
            }else{
                if($modStep != null && Yii::$app->user->identity->divisi < 4){
                    $modDiv = DivisiT::findOne($modStep['divisi']);
                    $ud = 'index.php?r=order/updatetrack&penjualan=' . $model->penjualan . '&penjualan_step=' . $modStep['penjualan_step'];
                    return '- <br>
                    <div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '">'.$modDiv->nama.'</a></div>';
                }else if($modStep != null && Yii::$app->user->identity->divisi == 4){
                    $modDiv = DivisiT::findOne($modStep['divisi']);
                    return '- <br><a class="btn btn-light">'.$modDiv->nama.'</a>';
                }else{
                    return '-';
                }
            }
        },
        'contentOptions' => ['style' => 'font-size:7px;!important'],
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'filter'=>false,
        'format'=>'raw'
    ];
}else{
    $st = [];
    $rev = [];
}
if(Yii::$app->user->identity->divisi <= 3){
    $pst = [
        'label'=>'Status', 
        'attribute' => 'penjualan_status',
        'value'=>function ($model, $key, $index, $widget) { 
            if(Yii::$app->user->identity->divisi <= 3){
                if($model->penjualan_status == 'Lunas'){
                    return '<div class="btn btn-sm btn-success"> Lunas</div>';
                }else if($model->penjualan_status == 'Batal Order'){
                    return '<div class="btn btn-sm btn-danger"> Batal</div>';
                }else{
                    return '<a class="btn btn-sm btn-light modalButton" value="'.Url::to(['akun-log/create', 'penjualan'=> $model->penjualan, 'fromorder' => true]).'"><i class="fas fa-plus"></i> Bayar</a>';
                }
            }
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['Lunas' => 'Lunas', 'Piutang' => 'Piutang'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Status'],
        'contentOptions' => ['style' => 'font-size:7px;!important'],
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'filter'=>false,
        'format'=>'raw'
    ];
}else{
    $pst = [];
}
$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'faktur', 
        //'value'=>'penjualan',
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
        'filter'=>ArrayHelper::map(Order::find()->andWhere('penjualan_status != "Lunas"')->orderBy('faktur')->asArray()->all(), 'faktur', 'faktur'), 
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
    /* [
        'attribute'=>'divisi', 
        'value'=>'divisi',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Divisi::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Divisi'],
        'format'=>'raw'
    ], */
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
    /* [
        'attribute'=>'penjualan_diskon', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ], */
    /* [
        'attribute'=>'penjualan_ongkir', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ], */
    /* [
        'attribute'=>'fee', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ], */
    /* [
        'attribute'=>'GT', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ], */
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
    $st,
    $pst,
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i> '.$this->title.'</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat Order</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
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