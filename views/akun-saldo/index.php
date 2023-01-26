<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use app\models\Beban;
use app\models\Akun;
// on your view layout file
use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);
$this->title = 'Penambahan & Penarikan Kas Besar / Kas Kecil';

$modInorout = ['Masuk Kas Besar' => 'Masuk Kas Besar', 'Keluar Kas Besar' => 'Keluar Kas Besar'];

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'akun', 
        'value'=>'akun0.akun_ref',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(Akun::find()->orderBy('akun_ref')->asArray()->all(), 'akun', 'akun_ref'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter Akun'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'inorout', 
        'value'=>'inorout',
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>$modInorout, 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Filter'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'date',
        'width'=>'250px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'date',
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
            "apply.daterangepicker" => "function() { apply_filter('date') }",
          ],
        ])
    ],
    [
        'attribute'=>'ket',
        'filter'=>false
    ],
    [
        'attribute'=>'jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Update',
        'template' => '{update}',
        'buttons'=>[
           'update' => function($url, $model) { 
                if($model->akun_saldo !== null){

                    
                //diffrent controller
                $controller = Yii::$app->controller;
                $arrayParams = ['akun_saldo' => $model->akun_saldo];
                //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                $ud = 'index.php?r=' . $controller->id . '/update&akun_saldo=' . $model->akun_saldo;

                    return '<a class="btn btn-light modalButton" value="'. $ud . '"><i class="fas fa-long-arrow-alt-right"></i> Update</a>';
                }else{
                    return null;
                }
            },

        ],
        
        'dropdown'=>false,
        'order'=>DynaGrid::ORDER_FIX_RIGHT
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'contentOptions' => [],
        'header'=>'Hapus',
        'template' => '{delete}',
        'urlCreator'=>function($action, $model, $key, $index) { return [$action, 'akun_saldo' => $model->akun_saldo]; },
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
        'responsiveWrap'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i>  Saldo</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Input</a>  ' .
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['akun_saldo'=>'dynagrid-1'] // a unique identifier is important
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
        'title' => '<h2>Saldo Form</h2>',
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