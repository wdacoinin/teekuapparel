<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;
use app\models\DocPenjualanProduk;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'File Desain';

// File Produk
$rows = (new \yii\db\Query())
->select([
    'penjualan.penjualan',
    'doc_penjualan_produk.id_img', 
    'doc_penjualan_produk.penjualan', 
    'doc_penjualan_produk.Nama_Foto', 
    'doc_penjualan_produk.type', 
    'doc_penjualan_produk.size', 
    'doc_penjualan_produk.url', 
    'doc_penjualan_produk.keterangan',
    ])
->from('doc_penjualan_produk')
->join('LEFT JOIN', 'penjualan', 'doc_penjualan_produk.penjualan = penjualan.penjualan')
->join('LEFT JOIN', 'user', 'doc_penjualan_produk.user = user.id')
->join('LEFT JOIN', 'divisi', 'divisi.divisi = user.divisi')
->where(['penjualan.penjualan' => $model->penjualan])
->andWhere('user.divisi IN(2,5)')
->orderBy('doc_penjualan_produk.id_img DESC')
->limit(1)
->all();


$initialPreview = [];
$initialPreviewConfig = [];
if($rows){
    foreach ($rows as $i => $row) {
        $initialPreview[$i] = $row['url'];
        $initialPreviewConfig[$i] = array(
            'key' => $row['id_img'],
            'url' => 'index.php?r=penjualan/deletefiledesain',
            'caption' => 'Note: ' . $row['keterangan'],
            'size' => $row['size'],
        );
    }
}


//echo json_encode($initialPreviewConfig);
?>

<?php if($rows){ ?>
<div class="col-md-12 py-4 displyFile">

    <h4><?php echo $this->title; ?></h4>

    <?php
    // Control display of widget elements
    echo FileInput::widget([
        'name' => 'attachment_50',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview,
            'initialCaption'=>false,
            'initialPreviewConfig' => $initialPreviewConfig,
            'overwriteInitial'=>false,
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'showFileInput' => false
        ]
    ]);
    ?>

</div>

<?php } ?>

<style>	
	.displyFile .file-caption {
		display: none;
	}
    .displyNota .kv-file-remove,
    .displyNota .file-caption {
		display: none;
	}
</style>