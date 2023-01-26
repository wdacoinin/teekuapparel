<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'File Nota';

//File Nota
$rows2 = (new \yii\db\Query())
->select([
    'pembelian.pembelian',
    'doc_pemb.id_img', 
    'doc_pemb.pembelian', 
    'doc_pemb.Nama_Foto', 
    'doc_pemb.type', 
    'doc_pemb.size', 
    'doc_pemb.url'
    ])
->from('doc_pemb')
->join('LEFT JOIN', 'pembelian', 'doc_pemb.pembelian = pembelian.pembelian')
->where(['pembelian.pembelian' => $model->pembelian])
->all();

$initialPreview2 = [];
$initialPreviewConfig2 = [];
if($rows2){
foreach ($rows2 as $i => $row) {
    $initialPreview2[$i] = $row['url'];
    $initialPreviewConfig2[$i] = array(
        'key' => $row['id_img'],
        'url' => 'index.php?r=pembelian/deletenota',
        'caption' => $row['Nama_Foto'],
        'size' => $row['size'],
    );
}
}

?>

<?php if($rows2){ ?>

<div class="col-md-12 py-4 displyNota">

    <h4>File Nota</h4>

    <?php
    // Control display of widget elements
    echo FileInput::widget([
        'name' => 'attachment_2',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview2,
            'initialCaption'=>false,
            'initialPreviewConfig' => $initialPreviewConfig2,
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