<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\View;
use app\models\BackendUser;
use app\models\Akun;
use app\models\Konsumen;
use app\models\PenjualanProdukT;
use app\models\VariableT;
use app\models\DivisiT;
use app\models\DocPenjualanProdukT;
use app\models\MyFormatter;
use app\models\RevT;
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
$modSales = ArrayHelper::map(BackendUser::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama');
$modAkun = ArrayHelper::map(Akun::find()->orderBy('akun_nama')->asArray()->all(), 'akun', 'akun_ref');
$modKonsumen = ArrayHelper::map(Konsumen::find()->orderBy('konsumen_nama')->asArray()->all(), 'konsumen', 'konsumen_nama');

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
$arrayParams = ['penjualan' => $model->penjualan];
$params = array_merge(["{$controller->id}/produk"], $arrayParams);
$dl = array_merge(["{$controller->id}/download"], $arrayParams);
$acc = array_merge(["{$controller->id}/acc"], $arrayParams);
$rev = array_merge(["{$controller->id}/rev"], $arrayParams);
$revdone = array_merge(["{$controller->id}/revdone"], $arrayParams);

//====================FEE==============//
//=====================================//
//get total qty penjualan
$checkCP = PenjualanProdukT::find()->where(['penjualan' => $model->penjualan])->groupBy('penjualan')->count();
$penjualan_jml = 0;
if($checkCP > 0){
$row = PenjualanProdukT::find()->select('SUM(penjualan_jml) AS penjualan_jml')->where(['penjualan' => $model->penjualan])->groupBy('penjualan')->all();
$penjualan_jml = $row[0]->penjualan_jml;

//get variable fee
$marketing_fee = 0;
$internal_fee = 0;
$mfee = VariableT::find()->select('val')->where(['nama' => 'Marketing Fee'])->all();
$intfee = VariableT::find()->select('val')->where(['nama' => 'Internal Fee'])->all();
if($mfee !== null){
    $marketing_fee = $mfee[0]->val;
}
if($intfee !== null){
    $internal_fee = $intfee[0]->val;
}
//get who made penjualan
$usermade = BackendUser::find()->select('divisi')->where(['id' => $model->sales])->all();
if(count($usermade) > 0){
    $usermade_divisi = $usermade[0]->divisi;
}
//set to model fee value
if($usermade_divisi == 5){
    $model->fee = $penjualan_jml * $marketing_fee;
}else{
    $model->fee = $penjualan_jml * $internal_fee;
}
}
//================END=FEE==============//
//=====================================//

//$fee = $row->penjualan_jml;
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
                    <h5 class="card-title mb-0 text-white">Detail Penjualan</b>
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
            <?=  
            $form->field($model, 'penjualan_tgl')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl Order'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

            <?= // Usage with ActiveForm and model
            $form->field($model, 'konsumen')->widget(Select2::classname(), [
                'data' => $modKonsumen,
                'options' => ['placeholder' => 'Pilih Konsumen'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); 
            ?>

            <?= $form->field($model->konsumen0, 'alamat')->textarea(['rows' => '2', 'readonly' => true]) ?>

            <?= $form->field($model, 'keterangan')->textarea(['rows' => 8, 'style' => 'white-space: pre-wrap']) ?>
            
            </div>
            <div class="col-md-4">

            <?= // Usage with ActiveForm and model
            $form->field($model, 'sales')->widget(Select2::classname(), [
                'data' => $modSales,
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Agen'); 
            ?>

            
            <?php if(Yii::$app->user->identity->divisi === 1 || Yii::$app->user->identity->divisi === 2){ ?>

                <?= $form->field($model, 'surat_jalan')->textInput(['maxlength' => true]) ?>

                <?php
                // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
                // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
                // is disallowed.
                echo $form->field($model, 'penjualan_ongkir')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => 'Rp. ',
                        'suffix' => '',        
                        'groupSeparator' => '.',
                        'radixPoint' => '',
                        'allowMinus' => false
                    ],
                    'options' => $saveOptions,
                    'displayOptions' => ['class' => 'form-control'],
                    'saveInputContainer' => $saveCont
                ]);
                ?>

            
                <?= $form->field($model, 'followup_team')->widget(Select2::classname(), [
                    
                    'data' => ArrayHelper::map(BackendUser::find()->where(['divisi' => 5])->orderBy('nama')->all(), 'nama', 'nama'),
                    'options' => ['placeholder' => 'Follow Up Team', 'value' => json_decode($model->followup_team), 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
                    ],
                ])->label('Desainer'); ?>

                <?php
                // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
                // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
                // is disallowed.
                echo $form->field($model, 'fee')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => 'Rp. ',
                        'suffix' => '',        
                        'groupSeparator' => '.',
                        'radixPoint' => '',
                        'allowMinus' => false
                    ],
                    'options' => $saveOptions,
                    'displayOptions' => ['class' => 'form-control'],
                    'saveInputContainer' => $saveCont
                ]);
                ?>

            <?php } ?>

            <?php if(Yii::$app->user->identity->divisi === 5){ ?>
            
                <?= $form->field($model, 'followup_team')->widget(Select2::classname(), [
                    
                    'data' => ArrayHelper::map(BackendUser::find()->where(['divisi' => 5])->orderBy('nama')->all(), 'nama', 'nama'),
                    'options' => ['placeholder' => 'Follow Up Team', 'value' => json_decode($model->followup_team), 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
                    ],
                ])->label('Desainer'); ?>

            <?php } ?>   

            </div>
            <div class="col-md-4">
            <?php if(Yii::$app->user->identity->divisi === 1 || Yii::$app->user->identity->divisi === 2 || Yii::$app->user->identity->divisi === 3){ ?>

            <?= // Usage with ActiveForm and model
            $form->field($model, 'penjualan_status')->widget(Select2::classname(), [
                'data' => ['Lunas' => 'Lunas', 'Piutang' => 'Piutang', 'Batal Order' => 'Batal Order'],
                'options' => ['placeholder' => 'Status Order'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); 
            ?>

            <?=  
            $form->field($model, 'penjualan_tempo')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl Jatuh Tempo'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
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

            <?= Html::a('<i class="fa far fa-hand-point-up"></i> Manifest', ['manifest', 'penjualan' => $model->penjualan], [
                'class'=>'btn btn-primary', 
                'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Print Manifest Order'
            ]); ?>

            <?php if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 3 || Yii::$app->user->identity->divisi == 4){ ?>
                <?php $cpp = PenjualanProdukT::find()->where(['penjualan' => $model->penjualan])->asArray()->count();
                if($cpp > 0){ ?>
                <?= Html::a('<i class="fa fas fa-print"></i> Print Nota', ['print', 'penjualan' => $model->penjualan], [
                    'class'=>'btn btn-info', 
                    'target'=>'_blank', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Print Nota'
                ]); ?>
                <?php } ?>
            <?php } ?>
        </div>

        </div>
    </div>
</div>
<!---- END FORM PENJUALAN ----->

</div>
<?php ActiveForm::end(); ?>

<div class="row">
    
<div class="col-md-12">

<!---- TABEL ITEM ----->
    <div class="container-flex py-0">
        <div id="toolbars" class="container">
            <div class="row row-cols-auto g-0">
                <div class="col align-items-center">
                    <?php $checksku = PenjualanProdukT::find()->where(['penjualan' => $model->penjualan])->asArray()->count();
                    $pp = PenjualanProdukT::find()->where(['penjualan' => $model->penjualan])->orderBy('penjualan_produk ASC')->limit(1)->asArray()->one();
                    
                    if($model->acc_desain == 0){
                        if($checksku > 0){ ?>
                            <a class="btn btn-success modalButton" value="<?= Url::to(['addmore', 'penjualan_produk' => $pp['penjualan_produk'], 'penjualan' => $modPenjualanProduk->penjualan]) ?>"><i class="fas fa-plus"></i></a>
                        <?php }else{ ?>
                            <a class="btn btn-sm btn-primary modalButton1" value="<?= Url::to(['penjualan-produk/create', 'penjualan' => $modPenjualanProduk->penjualan]) ?>"><i class="fas fa-plus"></i>Input SKU</a>
                        <?php }
                    } ?>
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
                        <?php if($model->acc_desain == 0){ ?>
                        <th data-field="opt" data-sortable="true" data-align="left" data-width="10" data-width-unit="%">Hapus</th>
                        <?php } ?>
                        <th data-field="url" data-sortable="true" data-align="left" data-width="10" data-width-unit="%">Gambar SKU</th>
                        <th data-field="sku_kode" data-sortable="true" data-align="left" data-width="5" data-width-unit="%">SKU</th>
                        <th data-field="nama" data-sortable="true" data-align="left" data-width="15" data-width-unit="%">Produk</th>
                        <th data-field="item" data-sortable="true" data-align="left" data-width="15" data-width-unit="%">Detail</th>
                        <th data-field="nick" data-sortable="true" data-align="left" data-width="15" data-width-unit="%">Nickname</th>
                        <th data-field="penjualan_jml" data-sortable="true" data-align="left" data-width="5" data-width-unit="%" data-footer-formatter="nttl">Qty</th>
                        <th data-field="subtotal" data-sortable="true" data-align="right" data-width="15" data-width-unit="%" data-formatter="priceFormatter" data-footer-formatter="dttl">Subtotal</th>
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
<div class="container-flex d-print-none mt-3">
    <div class="card">
        <div class="card-header p-2 d-flex bg-info">
            <div class="mr-auto">
                <div class="d-flex">
                <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                <span class="align-self-center mr-2">
                    <h5 class="card-title mb-0 text-white">File Order Agen</b>
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
            <?php
            if($model->acc_desain == 0 && Yii::$app->user->identity->divisi <= 2 || Yii::$app->user->identity->divisi == 4){ ?>
                <a class="btn btn-primary modalButton" value="<?= Url::to(['upload', 'penjualan' => $_GET['penjualan']]) ?>"><i class="fas fa-upload"></i> Upload File</a>
            <?php } ?>

            <?php $moddpe = DocPenjualanProdukT::find()->where(['penjualan' => $model->penjualan])->asArray()->count();
            if($moddpe > 0 && Yii::$app->user->identity->divisi <= 2 || Yii::$app->user->identity->divisi == 5){ ?>
                <button id="dzip"><i class="fas fa-cloud-download-alt"></i> Download as Zip.file</button>
            <?php } ?>

            <div class="row">  

            
            <!---DISPLAY FILE--->
            <?= $this->render('_displayFile', [
                'model' => $model, 
                'DocPenjualanProduk' => $DocPenjualanProduk, 
                'modPenjualanProduk' => $modPenjualanProduk
            ]) ?>
            

            </div>
        </div>
    </div>
</div>
<!---- END FORM PENJUALAN ----->

<!---- REV -------------------->

<div class="container-flex d-print-none">
    <div class="card">
        <div class="card-header p-2 d-flex bg-info">
            <div class="mr-auto">
                <div class="d-flex">
                <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                <span class="align-self-center mr-2">
                    <h5 class="card-title mb-0 text-white"> File Desainer & Revisi</b>
                    </h5>
                </span>
                </div>
            </div>
            <div class="float-right">
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center maximizerev hide" data-feather="maximize" data-toggle="collapse" aria-expanded="false" href="#collapseFile" aria-controls="collapseFile"></i>
                <i style="cursor:pointer;" class="mr-2 text-white align-self-center minimizerev" data-feather="minimize" data-toggle="collapse" aria-expanded="true" href="#collapseFile" aria-controls="collapseFile"></i> 
            </div>
        </div>
        <div class="card-body p-3" id="collapseRev" class="collapse show">
            

            <div class="row">  

                <!---DISPLAY FILE DESAIN--->
                <?= $this->render('_displayFileDesain', [
                    'model' => $model, 
                    'DocPenjualanProduk' => $DocPenjualanProdukD, 
                    'modPenjualanProduk' => $modPenjualanProduk
                ]) ?>

            </div>

            <div class="flex">  
            <?php
            if($model->acc_desain == 0 && Yii::$app->user->identity->divisi <= 2 || Yii::$app->user->identity->divisi == 5){ ?>
                <a class="btn btn-primary modalButton" value="<?= Url::to(['uploaddesain', 'penjualan' => $_GET['penjualan']]) ?>"><i class="fas fa-upload"></i> Upload Desain</a>
            <?php } ?>

            <?php
            $modAppr = DocPenjualanProdukT::find()
            ->join('LEFT JOIN', 'user', 'doc_penjualan_produk.user = user.id')
            ->join('LEFT JOIN', 'divisi', 'user.divisi = divisi.divisi')
            ->where(['doc_penjualan_produk.penjualan' => $model->penjualan])
            ->andWhere('user.divisi IN(2,5)')
            ->asArray()->count();
            //var_dump($modApp);die;
            if((int) $modAppr > 0 && $model->acc_desain == 0){ 
                if(Yii::$app->user->identity->divisi <= 2 || Yii::$app->user->identity->divisi == 4){
                ?>
                <button id="acc" class="btn btn-success"><i class="fas fa-check-double"></i> Approve Desain</button>
            <?php }} ?>
            </div>

            <?php if($model->acc_desain == 0){ ?>
            <textarea id="textrev" class="form-control mt-3"></textarea>

            <button id="rev" class="btn btn-success mt-3"><i class="fas fa-check-double"></i> Send Revisi</button>

            <?php } ?>

            <?php 
                $modrev = RevT::find()->where(['penjualan' => $model->penjualan])->asArray()->all();
                if($modrev != null){
                    foreach($modrev as $row){ 
                        $us = BackendUser::findOne($row['user']);
                        ?>
                        <div class="list-group-item mt-2" style="border-radius:10px;">
                            <div class="row" style="border-bottom:1px solid #dedede;">
                                <div class="col-md-2" style="border-right:1px solid #dedede;">
                                <?php if($row['rev_st'] > 0){ ?>
                                    <i class="fas fa-check-double"></i>
                                <?php }else{ 
                                    if(Yii::$app->user->identity->divisi <= 2 || Yii::$app->user->identity->divisi == 5){?>
                                    <button id="revdone" class="btn btn-sm btn-primary" data-rev="<?php echo $row['rev']; ?>"><i class="fas fa-check-double"></i> Selesai</button>
                                    <?php }else{ ?>
                                    <i class="far fa-clock"></i> Proses
                                    <?php } ?>
                            
                                <?php } ?>
                            </div>
                                <div class="col-md-10"><i class="far fa-user"></i> <?php echo $us->nama; ?> <i class="fas fa-history"></i> <?php echo MyFormatter::formatDateTimeForUser($row['timestamp']); ?></div>
                            </div>
                            <div class="row">
                            <div class="col-md-1"><i class="fas fa-comment-alt"></i></div>
                            <div class="col-md-11"><?php echo $row['note']; ?></div>
                            </div>
                        </div>
                    <?php } ?>
            <?php } ?>

        </div>
    </div>
</div>


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
    $js=<<<js
        $('.modalButton1').click( function () {
            $('#modal1').modal('show')
            .find('#modalContent1')
            .load($(this).attr('value'));
        });
        $('#modal1').modal({
            backdrop: 'static',
            keyboard: false
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2>Form</h2>',
        'id' => 'modal1',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent1'></div>";
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

    function edit( event ) {
        var url = window.origin + event;
        location.replace(url);
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

	function nttl(data) {
		var total = 0;

		if (data.length > 0) {
		
			var field = this.field;
		
			total = data.reduce(function(sum, row) {
			return sum + (+row[field]);
			}, 0);
			var num = total.toFixed(0);
			
			return num;
		}
		
		return '';
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
	$('#collapseRev .collapse').slideToggle('show');
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

    $('.minimizerev').on('click', function(){
        $(this).addClass('hide');
        $('.maximizerev').removeClass('hide');
	    $('#collapseRev').slideToggle("slow");
    });

    $('.maximizerev').on('click', function(){
        $(this).addClass('hide');
        $('.minimizerev').removeClass('hide');
	    $('#collapseRev').slideToggle("slow");
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

    //download
    $( '#dzip' ).on( 'click', function () {
        $.ajax( {
            url: window.origin + '<?php echo Yii::$app->urlManager->createUrl($dl); ?>',
            method: "POST",
            //data: {penjualan},
            success: function ( data ) {
                var json = JSON.parse(data);
                //console.log(json);
                location.replace(json['linkdl']);
            }
        } );
    });

    //acc
    $( '#acc' ).on( 'click', function () {
        $.ajax( {
            url: window.origin + '<?php echo Yii::$app->urlManager->createUrl($acc); ?>',
            method: "POST",
            //data: {penjualan},
            success: function ( data ) {
                location.reload();
            }
        } );
    });

    //rev
    $( '#rev' ).on( 'click', function () {
        var textrev = $('#textrev').val();
        $.ajax( {
            url: window.origin + '<?php echo Yii::$app->urlManager->createUrl($rev); ?>',
            method: "POST",
            data: {textrev:textrev},
            success: function ( data ) {
                location.reload();
            }
        } );
    });

    //rev
    $( '#revdone' ).on( 'click', function () {
        var rev = $(this).data("rev");
        //console.log(rev);
        $.ajax( {
            url: window.origin + '<?php echo Yii::$app->urlManager->createUrl($revdone); ?>',
            method: "POST",
            data: {rev:rev},
            success: function ( data ) {
                location.reload();
            }
        } );
    });

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