<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\MyFormatter;
use app\models\PenjualanProdukDetailv;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = 'NO Purchase Order '.$model->faktur.'';
$this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

    <h5 class="text-center py-1 m-0" style="background:#f84e4e;font-weight:700;"><b><?= Html::encode($this->title) ?></b></h5>

    <div class="col-md-12">
        <table width="100%">
                <tbody>
                    <tr>
                <td width="50%">
                    <table width="100%">
                    <tbody>
                    <tr style="padding:2px;">
                        <td><img src="../assets/images/fprint.png" style="width:35px;"> <?php echo $nama[0]->detail; ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:11px;color:#666666;text-align:left;">Address: <?php echo $alamat[0]->detail; ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:11px;color:#666666;text-align:left;">Phone: <?php echo $telp[0]->detail; ?></td>
                    </tr>
                    </tbody>
                    </table>
                </td>

                <td width="50%">
                    <table width="100%">
                    <tbody>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Tgl.PO: <?php echo MyFormatter::formatDateTimeId($model->penjualan_tgl); ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Konsumen: <?php echo $Konsumen[0]->konsumen_nama; ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Admin: <?php echo Yii::$app->user->identity->nama; ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Agen: <?php echo $Sales[0]->nama; ?></td>
                    </tr>
                    </tbody>
                    </table>
                </td>
                </tr>
                </tbody>
        </table>
    </div>

    <!-- <div class="col-md-12 mx-auto" style="border:2px dotted #dedede;"> -->
        
        <table class="table table-bordered" width="100%" style="font-size:11px;">
        <thead>
            <tr style="border-bottom: 1px solid;">
                <th width="5%">#</th>
                <th width="20%">Item</th>
                <th width="20%">Nickname</th>
                <th width="5%">Qty</th>
                <th width="20%">@Harga</th>
                <th width="20%">Subtotal</th>
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
            'penjualan_produk.penjualan_harga'
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
            $no = 0;
            $gt = 0;
            $tq = 0;
        foreach ($rows as $i => $row) {
            $no++;
            $harga = (int)($row['penjualan_harga'] + $row['subtotal_detail']);
            $subtotal = (int)($row['subtotal'] + $row['total_detail']);
            $gt += $subtotal;
            $tq += (int)($row['penjualan_jml']);
            echo ' <tr style="padding:2px;">
            <td style="padding:2px;text-align:center;">'.$no.'</td>
            <td style="padding:2px;">'.$row['nama'].' <br> '.$row['item'].'</td>
            <td style="padding:2px;">'.$row['nick'].'</td>
            <td style="padding:2px;text-align:right;">'.$row['penjualan_jml'].'</td>
            <td style="padding:2px;text-align:right;">'.MyFormatter::formatUang($harga).'</td>
            <td style="padding:2px;text-align:right;">'.MyFormatter::formatUang($subtotal).'</td>
            </tr>';
        }
        }
        ?>
        <tfoot>
        <!-- <tr style="padding:2px;border-top: 1px solid;font-weight:700">
            <th style="padding:2px;">Disc.</th>
            <th style="padding:2px;"></th>
            <th style="padding:2px;text-align:right;"></th>
            <th style="padding:2px;text-align:right;"></th>
            <th style="padding:2px;text-align:right;"><?php //echo MyFormatter::formatUang($model->penjualan_diskon); ?></th>
        </tr> -->
        <tr style="padding:2px;border-top: 1px solid #dedede;font-weight:700">
            <th style="padding:2px;">Total</th>
            <th style="padding:2px;"></th>
            <th style="padding:2px;"></th>
            <th style="padding:2px;text-align:right;"><?php echo $tq; ?></th>
            <th style="padding:2px;text-align:right;"></th>
            <th style="padding:2px;text-align:right;"><?php echo MyFormatter::formatUang($gt-$model->penjualan_diskon); ?></th>
        </tr>
        <tr style="padding:2px;border-top: 1px solid #dedede;font-weight:200;">
            <th style="padding:2px;background:#dedede;">Terbilang</th>
            <td style="padding:2px;text-align:center;background:#dedede;" colspan="5"><?php echo ucfirst(MyFormatter::formatNumberTerbilang($gt-$model->penjualan_diskon)); ?></td>
        </tr>
        </tfoot>
        </tbody>
        </table>
        
    <!-- </div> -->

</div>
