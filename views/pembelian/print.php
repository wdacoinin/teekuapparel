<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\MyFormatter;
/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = 'DO Pembelian '.$model->faktur.'';
$this->params['breadcrumbs'][] = ['label' => 'Pembelian', 'url' => ['index']];
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
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Tgl.Pembelian: <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->pembelian_tgl))); ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Supplier: <?php echo $Supplier[0]->supplier_nama; ?></td>
                    </tr>
                    <tr style="padding:2px;">
                        <td style="padding:2px;font-size:10px;color:#666666;text-align:right;">Admin: <?php echo Yii::$app->user->identity->nama; ?></td>
                    </tr>
                    </tbody>
                    </table>
                </td>
                </tr>
                </tbody>
        </table>
    </div>

    <!-- <div class="col-md-12 mx-auto" style="border:2px dotted #dedede;"> -->
        
        <table class="table table-bordered "width="100%" style="font-size:11px;">
        <thead>
            <tr style="border-bottom: 1px solid;">
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>@Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
       
        <?php 
        
        // bahan_baku
        $rows = (new \yii\db\Query())
        ->select([
            'pembelian_bahan.pembelian_bahan', 
            'bahan_baku.nama',
            'pembelian_bahan.pembelian_jml', 
            'pembelian_bahan.pembelian_harga'
            ])
        ->from('pembelian_bahan')
        ->join('LEFT JOIN', 'bahan_baku', 'pembelian_bahan.bahan_baku = bahan_baku.bahan_baku')
        ->join('LEFT JOIN', 'pembelian', 'pembelian_bahan.pembelian = pembelian.pembelian')
        ->where(['pembelian.pembelian' => $model->pembelian])
        ->all();
        $img=[];
        
        if($rows !== null){
            $no = 0;
            $gt = 0;
            $tq = 0;
        foreach ($rows as $i => $row) {
            $no++;
            $harga = (int)($row['pembelian_harga']);
            $subtotal = (int)($row['pembelian_jml']*$row['pembelian_harga']);
            $gt += $subtotal;
            $tq += round($row['pembelian_jml'],2);
            echo ' <tr style="padding:2px;">
            <td style="padding:2px;text-align:center;">'.$no.'</td>
            <td style="padding:2px;">'.$row['nama'].'</td>
            <td style="padding:2px;text-align:right;">'.$row['pembelian_jml'].'</td>
            <td style="padding:2px;text-align:right;">'.MyFormatter::formatUang($harga).'</td>
            <td style="padding:2px;text-align:right;">'.MyFormatter::formatUang($subtotal).'</td>
            </tr>';
        }
        }
        ?>
        <tfoot>
        <tr style="padding:2px;border-top: 1px solid;font-weight:700">
            <th style="padding:2px;">Disc.</th>
            <th style="padding:2px;"></th>
            <th style="padding:2px;text-align:right;"></th>
            <th style="padding:2px;text-align:right;"></th>
            <th style="padding:2px;text-align:right;"><?php echo MyFormatter::formatUang($model->pembelian_diskon); ?></th>
        </tr>
        <tr style="padding:2px;border-top: 1px solid #dedede;font-weight:700">
            <th style="padding:2px;">Total</th>
            <th style="padding:2px;"></th>
            <th style="padding:2px;text-align:right;"><?php echo $tq; ?></th>
            <th style="padding:2px;text-align:right;"></th>
            <th style="padding:2px;text-align:right;"><?php echo MyFormatter::formatUang($gt-$model->pembelian_diskon); ?></th>
        </tr>
        <tr style="padding:2px;border-top: 1px solid #dedede;font-weight:200;">
            <th style="padding:2px;background:#dedede;">Terbilang</th>
            <td style="padding:2px;text-align:center;background:#dedede;" colspan="4"><?php echo ucfirst(MyFormatter::formatNumberTerbilang($gt-$model->pembelian_diskon)); ?></td>
        </tr>
        </tfoot>
        </tbody>
        </table>
        
    <!-- </div> -->

</div>
