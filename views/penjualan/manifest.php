<?php

use app\models\BackendUser;
use app\models\DocPenjualanProdukT;
use app\models\PenjualanProdukDetailv;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
include 'qrcode-gen.php';
/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = 'Order '.$model->faktur.' Manifest';
$this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h4 class="text-center py-3" style="background:#eeeeee;font-weight:700;"><b><?= Html::encode($this->title) ?></b></h4>

    <div class="offset-md-2 col-md-8 mx-auto" style="border:2px dotted #dedede;">
        
        <table width="100%">
        <tbody>
        <tr>
        <?php 
        
        // File Produk
        $rows = (new \yii\db\Query())
        ->select([
            'doc_penjualan_produk.url', 
            'doc_penjualan_produk.keterangan',
            ])
        ->from('doc_penjualan_produk')
        ->join("LEFT JOIN", "user", "doc_penjualan_produk.user=user.id")
        ->join('LEFT JOIN', 'penjualan', 'doc_penjualan_produk.penjualan = penjualan.penjualan')
        ->where(['penjualan.penjualan' => $model->penjualan])
        ->andWhere('user.divisi IN(1, 2, 5)')
        ->orderBy('doc_penjualan_produk.id_img DESC')
        ->limit(1)
        ->all();
        $img=[];
        if($rows !== null){
            
            $no = 0;
            foreach ($rows as $i => $row) {
                $no++;
                $leng = count($rows);
                $endtr = [2,4,6,8,10,12,14,16,18,20];
                if(in_array($no, $endtr) == ''){
                    echo'<tr>';
                }
                echo '<td width="50%"><figure class="figure"><img src="'.$row['url'].'" style="height:250px;" class="img-thumbnail" alt="..."><figcaption class="figure-caption">Ket: '.$row['keterangan'].'</figcaption>
                </figure></td>';
                
                if(in_array($no, $endtr) > 0){
                    echo '</tr>';
                }
                if($leng === $no && in_array($no, $endtr) == ''){
                    echo '<td width="50%">  </td></tr>';
                }
            }
        }
        ?>
        </tr>
        </tbody>
        </table>

    </div>

    <div class="offset-md-2 col-md-8 mx-auto p-2" style="border:2px dotted #dedede;">
        
        <table class="table table-bordered "width="100%" style="font-size:10px;padding:11;white-space: pre-wrap !important; ">
        <thead>
            <tr>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $model->keterangan; ?></td>
            </tr>
        </tbody>
        </table>
        
        <table class="table table-bordered "width="100%" style="font-size:11px;padding:17">
        <thead>
            <tr>
                <th>Item</th>
                <th>Detail</th>
                <th>Qty</th>
                <th>Nickname</th>
                <th>Agen</th>
                <th>Desainer</th>
            </tr>
        </thead>
        <tbody>
       
        <?php 
        
        // Produk
        /* $rows = (new \yii\db\Query())
        ->select([
            'penjualan_produk.penjualan_produk', 
            'produk.nama',
            'penjualan_produk.penjualan_jml', 
            'user.nama AS sales',
            'penjualan.followup_team'
            ])
        ->from('penjualan_produk')
        ->join('LEFT JOIN', 'produk', 'penjualan_produk.produk = produk.produk')
        ->join('LEFT JOIN', 'penjualan', 'penjualan_produk.penjualan = penjualan.penjualan')
        ->join('LEFT JOIN', 'user', 'penjualan.sales = user.id')
        ->where(['penjualan.penjualan' => $model->penjualan])
        ->all(); */
        $rows = PenjualanProdukDetailv::find()->where(['penjualan' => $model->penjualan])->asArray()->all();
        $img=[];
        
        if($rows !== null){
        foreach ($rows as $i => $row) {
            $modDP = DocPenjualanProdukT::find()
            ->join("LEFT JOIN", "user", "doc_penjualan_produk.user=user.id")
            ->where(['doc_penjualan_produk.penjualan' => $row['penjualan']])
            ->andWhere('user.divisi IN(1, 2, 5)')
            ->orderBy('doc_penjualan_produk.id_img DESC')
            ->limit(1)
            ->asArray()->one();
            $moddes = BackendUser::findOne($modDP['user']);
            if($modDP['user'] != null){
                echo ' <tr>
                <td>'.$row['nama'].'</td>
                <td>'.$row['item'].'</td>
                <td>'.$row['penjualan_jml'].'</td>
                <td>'.nl2br($row['nick']).'</td>
                <td>'.$row['agen'].'</td>
                <td>'.$moddes->nama.'</td>
                </tr>';
            }else{
                echo ' <tr>
                <td>'.$row['nama'].'</td>
                <td>'.$row['item'].'</td>
                <td>'.$row['penjualan_jml'].'</td>
                <td>'.nl2br($row['nick']).'</td>
                <td>'.$row['agen'].'</td>
                <td></td>
                </tr>';
            }
        }
        }
        ?>
        </tbody>
        </table>
        
    </div>
    <!-- <pagebreak /> -->
    <table width="100%">
        <tbody>
    <?php 
    // QRcode Produk
    $rowse = (new \yii\db\Query())
    ->select([
        'penjualan.faktur',
        'penjualan.penjualan_tgl',
        'penjualan_produk.penjualan_produk', 
        'sku.sku_kode', 
        'produk.nama',
        'penjualan_produk.penjualan_jml', 
        'user.nama AS sales',
        'penjualan.followup_team'
        ])
    ->from('penjualan_produk')
    ->join('LEFT JOIN', 'produk', 'penjualan_produk.produk = produk.produk')
    ->join('LEFT JOIN', 'penjualan', 'penjualan_produk.penjualan = penjualan.penjualan')
    ->join('LEFT JOIN', 'user', 'penjualan.sales = user.id')
    ->join('LEFT JOIN', 'sku', 'sku.sku = penjualan_produk.sku')
    ->where(['penjualan.penjualan' => $model->penjualan])
    ->all();
    $img=[];
    
    if($rowse !== null){
        $no = 0;
        foreach ($rowse as $i => $row) {
            $no++;
            $leng = count($rowse);
            $endtr = [2,4,6,8,10,12,14,16,18,20];
            if(in_array($no, $endtr) == ''){
                echo'<tr>';
            }
            $fak = $row['faktur'] . '-' . $row['penjualan_produk'];
            $modDet = PenjualanProdukDetailv::findOne($row['penjualan_produk']);

            echo '
            <td width="50%">
            <table class="table table-bordered" width="100%" style="font-size:11px;padding:7px;margin:10px;"> 
            <tr>
                <th rowspan="4" style="padding:5px;width:40%"><img style="height:100px;" src="'.qrrs($row['penjualan_produk'], $fak).'"></th>
                <td style="padding:5px;color:#666666;">Item: '.$row['nama'].'</td>
            </tr>
            <tr>
                <td style="padding:5px;color:#666666;">SKU: '.$row['sku_kode'].' <br> Det: '.$modDet->item.' <br> Nick: '.$modDet->nick.'</td>
            </tr>
            <tr>
                <td style="padding:5px;color:#666666;">Qty: '.$row['penjualan_jml'].'</td>
            </tr>
            <tr>
                <td style="font-size:8px;padding:5px;color:#666666;">Teekuapparel-'.$row['penjualan_tgl'].'</td>
            </tr>
            </table>
            </td>';
            if(in_array($no, $endtr) > 0){
                echo '</tr>';
            }
            if($leng === $no && in_array($no, $endtr) == ''){

                echo '<td width="50%">
                <table class="table" width="100%" style="font-size:11px;padding:7px;margin:10px;"> 
                <tr>
                    <th rowspan="4" style="padding:5px;width:40%"></th>
                    <td style="padding:5px;color:#666666;"></td>
                </tr>
                <tr>
                    <td style="padding:5px;color:#666666;"></td>
                </tr>
                <tr>
                    <td style="padding:5px;color:#666666;"></td>
                </tr>
                <tr>
                    <td style="font-size:8px;padding:5px;color:#666666;"></td>
                </tr>
                </table>
                </td></tr>';
            }

        }
    }
    ?>
        </tbody>
    </table>

</div>
