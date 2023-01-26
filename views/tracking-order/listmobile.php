<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Order Tracking';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    'label',
    [
        'attribute'=>'jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
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
                if($model->penjualan_produk_step !== null){
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
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Order Tracking</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Untuk Input Baru</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                /* '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Terima Job</a>  ' . */
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
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