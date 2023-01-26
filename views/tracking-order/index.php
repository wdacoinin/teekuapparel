<?php

use app\models\BackendUser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Divisi;
use app\models\Penjualan;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Order Tracking';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'faktur', 
        'value'=>'faktur',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Penjualan::find()->orderBy('faktur')->asArray()->all(), 'faktur', 'faktur'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Faktur'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'label',
        'width'=>'150px',
        'filter' => false
    ],
    [
        'attribute'=>'jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>false,
        'filter'=>false
    ],
    [
        'attribute'=>'nama_divisi', 
        'value'=>'nama_divisi',
        'vAlign'=>'middle',
        'width'=>'100px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Divisi::find()->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Nama'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'nama_user', 
        'value'=>'nama_user',
        'vAlign'=>'middle',
        'width'=>'100px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Nama'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'start',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'start',
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
            "apply.daterangepicker" => "function() { apply_filter('start') }",
          ],
        ])
    ],
    [
        'attribute'=>'end',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'end',
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
            "apply.daterangepicker" => "function() { apply_filter('end') }",
          ],
        ])
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}',
        'buttons'=>[
           'update' => function($url, $model) { 
                if($model->penjualan_produk_step !== null && $model->end == null && $model->user === Yii::$app->user->identity->id){
                    //if($action === 'update'){
                        //$url = Yii::$app->urlManager->createUrl(['update', 'penjualan_produk_step' => $model->penjualan_produk_step]);
                        return '<a class="btn btn-light modalButton" value="'.$url . '&penjualan_produk_step=' .$model->penjualan_produk_step.'"><i class="fas fa-long-arrow-alt-right"></i> Keluar</a>';
        
                        //return $url;
                    //}
                    //return [$action, 'penjualan_produk_step' => $model->penjualan_produk_step];
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
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Order Tracking</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Untuk Input Baru</em></div>',
            'after' => false
        ],
        'rowOptions'=>function($model){
            $start = date_create($model->start);
            $end = date_create($model->end);
            $diff = date_diff($start, $end);
            $selisih = $diff->format("%a.");
                if($selisih > 2){
                    return ['class' => 'bg-danger text-white'];
                }
        },
        'toolbar' =>  [
            ['content'=>
                '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Terima Job</a>  ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['penjualan_produk_step'=>'dynagrid-1'] // a unique identifier is important
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
        'title' => '<h2>Produk Form</h2>',
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