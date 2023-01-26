<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\View;
use app\models\BackendUser;
use app\models\Akun;
use app\models\Supplier;
use app\models\VariableT;
use app\models\DivisiT;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use kartik\number\NumberControl;
use yii\helpers\Url;
use kartik\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */
/* @var $form yii\widgets\ActiveForm */
$modUser = ArrayHelper::map(BackendUser::find()->where('6 > divisi AND divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama');
//$modSales = ArrayHelper::map(BackendUser::find()->where(['divisi' => 5])->orderBy('nama')->asArray()->all(), 'id', 'nama');
$modAkun = ArrayHelper::map(Akun::find()->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
$modSupplier = ArrayHelper::map(Supplier::find()->orderBy('supplier_nama')->asArray()->all(), 'supplier', 'supplier_nama');

//helper number input
$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];

//diffrent controller
$controller = Yii::$app->controller;
$arrayParams = ['pembelian' => $model->pembelian];
$params = array_merge(["{$controller->id}/bahan"], $arrayParams);

?>

<?php
if (Yii::$app->session->hasFlash('danger')) {
    echo Alert::widget([
        'type' => Alert::TYPE_DANGER,
        'title' => ' Batal Input!',
        'icon' => 'fas fa-times-circle',
        'body' => '',
        'showSeparator' => true,
        'delay' => 8000
    ]);
}
?>

<?php $form = ActiveForm::begin(); ?>
    
<div class="row bg-light">

<!---- FORM ORDER ----->
<div class="container-flex d-print-none">
    <div class="card">
        <div class="card-header p-2 d-flex bg-info">
            <div class="mr-auto">
                <div class="d-flex">
                <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                <span class="align-self-center mr-2">
                    <h5 class="card-title mb-0 text-white">Detail Pembelian</b>
                    </h5>
                </span>
                </div>
            </div>
            <div class="float-right">
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center maximized hide" data-feather="maximize" data-toggle="collapse" aria-expanded="false" href="#collapseDetail" aria-controls="collapseDetail"></i>
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center minimized" data-feather="minimize" data-toggle="collapse" aria-expanded="true" href="#collapseDetail" aria-controls="collapseDetail"></i> 
            </div>
        </div>
        <div class="card-body p-3" id="collapseDetail" class="collapse show">
            <div class="row">
            
            <div class="col-md-4">

            <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            
            <?=  
            $form->field($model, 'pembelian_tgl')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl Order'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?= // Usage with ActiveForm and model
            $form->field($model, 'supplier')->widget(Select2::classname(), [
                'data' => $modSupplier,
                'options' => ['placeholder' => 'Pilih Supplier'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); 
            ?>

            <?= $form->field($model, 'no_sj')->textInput(['maxlength' => true]) ?>
            
            </div>
            <div class="col-md-4">

            
            <?php if(Yii::$app->user->identity->divisi === 1 || Yii::$app->user->identity->divisi === 2){ ?>
                <?= // Usage with ActiveForm and model
                $form->field($model, 'us')->widget(Select2::classname(), [
                    
                    'data' => $modUser,
                    'options' => ['placeholder' => 'Pilih Admin', 'value' => $model->us],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); 
                ?>
            <?php }else{ ?>
                <?= $form->field($model, 'us')->textInput(['value' => Yii::$app->user->identity->id, 'type' => 'hidden'])->label(false) ?>
            <?php } ?>

            <?= $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

            </div>
            <div class="col-md-4">
            <?php if(Yii::$app->user->identity->divisi === 1 || Yii::$app->user->identity->divisi === 2 || Yii::$app->user->identity->divisi === 3){ ?>

            <?= // Usage with ActiveForm and model
            $form->field($model, 'pembelian_status')->widget(Select2::classname(), [
                'data' => ['Lunas' => 'Lunas', 'Hutang' => 'Hutang'],
                'options' => ['placeholder' => 'Status Order'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); 
            ?>

            <?=  
            $form->field($model, 'pembelian_tempo')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl Jatuh Tempo'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?php
            // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
            // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
            // is disallowed.
            echo $form->field($model, 'pembelian_diskon')->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => 'Rp. ',
                    'suffix' => '',        
                    'groupSeparator' => '.',
                    'radixPoint' => '',
                    'allowMinus' => false
                ],
                'options' => $saveOptions,
                'displayOptions' => $dispOptions,
                'saveInputContainer' => $saveCont
            ]);
            ?>

            <?= // Usage with ActiveForm and model
            $form->field($model, 'akun')->widget(Select2::classname(), [
                'data' => $modAkun,
                'options' => ['placeholder' => 'Akun Bank'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); 
            ?>
                
            <?php } ?>

                </div>
            </div>

        
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

            <?php if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 3){ ?>
            <?= Html::a('<i class="fa fas fa-print"></i> Print Nota', ['print', 'pembelian' => $model->pembelian], [
                'class'=>'btn btn-info', 
                'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Print Nota'
            ]); ?>
            <?php } ?>
        </div>

        </div>
    </div>
</div>
<!---- END FORM pembelian ----->

</div>
<?php ActiveForm::end(); ?>

<div class="row">
    
<div class="col-md-6">

<!---- TABEL ITEM ----->
    <div class="container-flex py-0">
        <div id="toolbars" class="container">
            <div class="row row-cols-auto g-0">
                <div class="col align-items-center">
                    <a class="btn btn-sm btn-primary modalButton" value="<?= Url::to(['pembelian-bahan/create', 'pembelian' => $modPembelianBahan->pembelian]) ?>"><i class="fas fa-plus"></i>Tambah Produk</a>
                    <!-- <button class="btn btn-sm btn-primary modalButton" data-toggle="modal" data-target="#modal"><i class="fas fa-plus"></i> Input Produk </button> -->
                </div>
            </div>
        </div>
        <table id="get_penjualan" 
                data-ajax="get_penjualan"
                data-show-export="true"
                data-toolbar="#toolbars"
                data-search="true" 
                data-show-columns="true" 
                data-pagination="true" 
                data-show-refresh="true" 
                data-mobile-responsive="true" 
                data-show-footer="true" 
                data-page-size="25" 
                data-page-list="[25, 50, 100, 200, All]" 
                class="table table-striped table-sm table-hover table-borderless" style="width:99.8%;">
                <thead class="table-light">
                    <tr>
                        <th data-field="opt" data-sortable="true" data-align="left" data-width="5" data-width-unit="%">Hapus</th>
                        <th data-field="nama" data-sortable="true" data-align="left" data-width="15" data-width-unit="%">Produk</th>
                        <th data-field="pembelian_jml" data-sortable="true" data-align="left" data-width="15" data-width-unit="%">Qty</th>
                        <th data-field="pembelian_harga" data-sortable="true" data-align="left" data-width="15" data-width-unit="%" data-formatter="priceFormatter">Harga</th>
                        <th data-field="subtotal" data-sortable="true" data-align="left" data-width="15" data-width-unit="%" data-formatter="priceFormatter" data-footer-formatter="dttl">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
        </table>
    </div>
<!---- END TABEL ITEM ----->

</div>
<div class="col-md-6">

<?php if(Yii::$app->user->identity->divisi === 1 || Yii::$app->user->identity->divisi === 2 || Yii::$app->user->identity->divisi === 3){ ?>
 <!---TABEL PEMBAYARAN--->
 <?= $this->render('_tabelPembayaran', [
    'searchModel' => $searchModel, 
    'dataProvider' => $dataProvider
]) ?>
<?php } ?>

</div>
</div>

<!---- FORM FILE ----->
<div class="container-flex d-print-none">
    <div class="card">
        <div class="card-header p-2 d-flex bg-info">
            <div class="mr-auto">
                <div class="d-flex">
                <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                <span class="align-self-center mr-2">
                    <h5 class="card-title mb-0 text-white">File Pembelian</b>
                    </h5>
                </span>
                </div>
            </div>
            <div class="float-right">
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center maximizedf hide" data-feather="maximize" data-toggle="collapse" aria-expanded="false" href="#collapseFile" aria-controls="collapseFile"></i>
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center minimizedf" data-feather="minimize" data-toggle="collapse" aria-expanded="true" href="#collapseFile" aria-controls="collapseFile"></i> 
            </div>
        </div>
        <div class="card-body p-3" id="collapseFile" class="collapse show">
                    
            <div class="row">  

            
            <!---DISPLAY FILE--->
            <?= $this->render('_displayFile', [
                'model' => $model, 
                'DocPemb' => $DocPemb, 
                'modPembelianBahan' => $modPembelianBahan
            ]) ?>


            </div>
        </div>
    </div>
</div>
<!---- END FORM pembelian ----->


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
        'title' => '<h2>Form</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->

<!----MODAL---------------->
<?php
    /* $js=<<<js
        $('.kv-file-remove').click( function () {
            $('#modal2').modal('show')
                    .find('#modalContent2')
                    .load($(this).data('url'));
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2>Hapus File?</h2>',
        'id' => 'modal2',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent2'></div>";
    Modal::end(); */
?>
<!----END MODAL-------------->

<!----SCRIPT STYLE-------------->

<script type="text/javascript">
    function get_penjualan( params ) {
        $.ajax( {
            type: "POST",
            url: window.origin + '<?php echo Yii::$app->urlManager->createUrl($params); ?>',
            dataType: "json",
            success: function ( data ) {
                //console.log(data.hasil);
                params.success( {
                    "rows": data.rows,
                    "total": data.total
                } )
            },
            error: function ( er ) {
                params.error( er );
            }
        } );
    }

    function refresh_get_penjualan( params ) {
            $( '#get_penjualan' ).bootstrapTable( 'refreshOptions', {
                sortable: true,
                formatLoadingMessage: function () {
                    return '<button class="font-italic btn btn-sm btn-success d-print-none">Loading</button>';
                }
            } );
        }

        function stotalnota() {
        return '<div class="text-right">Total: </div>'
    }

    function hapus( event ) {
        //var url = $( document ).getElementById('hapusproduk').value;
        var url = event;
        //console.log(url);
        $.ajax( {
            type: "POST",
            url: window.origin + url,
            dataType: "json",
            success: function ( data ) {
                console.log(data);
                if(data.hasil === 'success'){
                    refresh_get_penjualan();
                }else if(data.hasil === 'step'){
                    alert('Produk sudah diproses di divisi, hapus dulu semua proses untuk menghapus produk!');
                }else if(data.hasil === 'adafile'){
                    alert('Hapus dulu file produk yg diuploda dibagian upload!');
                }else{
                    alert('Gagal hapus produk');
                }
            }
        } );
    }
		
    function priceFormatter(value) {
		var formatter = new Intl.NumberFormat('id-ID', {
		style: 'currency',
		currency: 'IDR',
		minimumFractionDigits: 0,
		});
		var num = formatter.format(value);
		return num;
	}
		
	function rupiah(value) {
		var	number_string = value.toString(),
		split	= number_string.split('.'),
		sisa 	= split[0].length % 3,
		rupiah 	= split[0].substr(0, sisa),
		ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		
		return rupiah;
	}

	function dttl(data) {
		var total = 0;

		if (data.length > 0) {
		
			var field = this.field;
		
			total = data.reduce(function(sum, row) {
			return sum + (+row[field]);
			}, 0);
			var num = 'Rp. ' + total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
			
			return num;
		}
		
		return '';
	}
</script>

<script type='text/javascript'>
    $('.modal-dialog').draggable({
        "handle":".modal-header"
      });
    $( document ).ready( function () {

	$('#collapseDetail .collapse').slideToggle('show');
	$('#collapseFile .collapse').slideToggle('show');
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

    $('.minimizedf').on('click', function(){
        $(this).addClass('hide');
        $('.maximizedf').removeClass('hide');
	    $('#collapseFile').slideToggle("slow");
    });

    $('.maximizedf').on('click', function(){
        $(this).addClass('hide');
        $('.minimizedf').removeClass('hide');
	    $('#collapseFile').slideToggle("slow");
    });

	$( '#get_penjualan' ).bootstrapTable( {
		sortable: true,
		exportDataType: $(this).val(),
    	exportTypes: [
			'csv', 
			'excel', 
			'pdf'
		],
		formatLoadingMessage: function () {
			return '<div class="col" style="min-heigth:200px"><button class="font-italic btn btn-success" style="margin:2em auto;">Loading</button></div>';
		}
	} );

	//reseter
	/* $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
		$('.btn').off('click');
		$('.btn').prop('disabled', false);
		$('.alert').addClass('hide');
		$('.alert').removeClass('show');
    }); */

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