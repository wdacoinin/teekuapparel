<?php

namespace app\controllers;

use app\models\AkunLog;
use yii;
use app\models\AkunSaldoT;
use app\models\AkunSaldo;
use app\models\BebanList;
use app\models\Penjualan;
use app\models\PenjualanProduk;
use app\models\PembelianBahan;
use yii\helpers\ArrayHelper;

class NeracaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(isset($_GET['bulan'])){
            $m = $_GET['bulan'];
        }else{
            $m = date('Y-m');
        }
        $this->layout = 'kosong';
        //D KAS
        $akunsaldomasuk = AkunSaldo::find()->select('SUM(jml) AS total_saldo_add')->where('inorout = "Masuk Kas Besar" AND date LIKE "%'.$m.'%"')->asArray()->one();

        //D PRIVE
        $akunsaldokeluar = AkunSaldo::find()->select('SUM(jml) AS total_saldo_keluar')->where('inorout = "Keluar Kas Besar" AND date LIKE "%'.$m.'%"')->asArray()->one();

        //D GAJI
        $akunGaji = BebanList::find()
        ->select('SUM(jumlah) AS subtotal')
        ->where('beban = 9 AND tgl LIKE "%'.$m.'%"')
        ->asArray()->one();

        //D STOK PEMBELIAN BERKURANG
        $akunPenjualanModal = Penjualan::find()
        ->select('SUM(total_bahan) AS subtotal')
        ->where('penjualan_tgl LIKE "%'.$m.'%"')
        ->asArray()->one();

        //D BEBAN
        $akunBeban = BebanList::find()
        ->select('SUM(jumlah) AS subtotal')
        ->where('beban <> 9 AND tgl LIKE "%'.$m.'%"')
        ->asArray()->one();

        //K PEMBELIAN
        $akunPembelian = PembelianBahan::find()
        ->select('SUM(pembelian_bahan.pembelian_jml*pembelian_bahan.pembelian_harga) AS subtotal')
        ->where('pembelian_bahan.pembelian_bahan_date LIKE "%'.$m.'%"')
        ->asArray()->one();

        //D HUTANG
        $akunBayarH= AkunLog::find()
        ->select('SUM(akun_log.jml) AS subtotal')
        ->where('akun_log.inorout IN ("Cicil", "Pembelian") AND akun_log.tgl LIKE "%'.$m.'%"')
        ->asArray()->one();
        $hutang = $akunPembelian['subtotal']-$akunBayarH['subtotal'];

        //K PENJUALAN
        $akunPenjualan = PenjualanProduk::find()
        ->select('SUM(penjualan_produk.penjualan_jml*penjualan_produk.penjualan_harga) AS subtotal')
        ->where('penjualan_produk.timestamp LIKE "%'.$m.'%"')
        ->asArray()->one();

        //K DISKON PENJUALAN
        $akunPenjualanDiskon = Penjualan::find()
        ->select('SUM(penjualan_diskon) AS subtotal')
        ->where('penjualan_tgl LIKE "%'.$m.'%"')
        ->asArray()->one();

        //K ONGKIR PENJUALAN
        $akunPenjualanOngkir = Penjualan::find()
        ->select('SUM(penjualan_ongkir) AS subtotal')
        ->where('penjualan_tgl LIKE "%'.$m.'%"')
        ->asArray()->one();

        //K FEE PENJUALAN
        $akunPenjualanFee = Penjualan::find()
        ->select('SUM(fee) AS subtotal')
        ->where('penjualan_tgl LIKE "%'.$m.'%"')
        ->asArray()->one();

        //K Piutang
        $akunBayar= AkunLog::find()
        ->select('SUM(akun_log.jml) AS subtotal')
        ->where('akun_log.inorout IN ("dp", "penjualan") AND akun_log.tgl LIKE "%'.$m.'%"')
        ->asArray()->one();
        $piutang = $akunPenjualan['subtotal']-$akunBayar['subtotal'];

        //K PIUTANG PENJUALAN
        /* $modPiutang = (new \yii\db\Query())
        ->select([
            'SUM(akun_log.jml) AS subtotal'
            ])
        ->from('akun_log')
        ->join('LEFT JOIN', 'produk', 'penjualan_produk.produk = produk.produk')
        ->join('LEFT JOIN', 'penjualan', 'penjualan_produk.penjualan = penjualan.penjualan')
        ->join('LEFT JOIN', 'akun_log', 'penjualan.akun = akun_log.akun')
        ->where('WHERE akun_log.inorout IN ("dp", "penjualan") AND akun_log.tgl LIKE "%'.$m.'%"')
        ->all(); */

        $total_debit =  
        $piutang + 
        $akunPenjualanDiskon['subtotal'] + 
        $akunPenjualanOngkir['subtotal'] +
        $akunPenjualanFee['subtotal'] +
        $akunsaldomasuk['total_saldo_add'] +
        $akunsaldokeluar['total_saldo_keluar'] +
        $akunPenjualanModal['subtotal'] +
        $akunGaji['subtotal'] +
        $akunBeban['subtotal'];

        $total_kredit = $akunPenjualan['subtotal']+$akunPembelian['subtotal']+$hutang;
        $res = $total_debit - $total_kredit;

        if($res > 0){
            $modal = $res;
            $pendapatan = 0;
        }else{
            $modal = 0;
            $pendapatan = abs($res);
        }

        //echo json_encode($akunPenjualan);die;

        return $this->render('index',[
            'akunsaldomasuk' => $akunsaldomasuk,
            'akunsaldokeluar' => $akunsaldokeluar,
            'akunPenjualan' => $akunPenjualan,
            'akunPembelian' => $akunPembelian,
            'akunPenjualanModal' => $akunPenjualanModal,
            'akunGaji' => $akunGaji,
            'akunBeban' => $akunBeban,
            'modal' => $modal,
            'pendapatan' => $pendapatan,
            'piutang' => $piutang,
            'hutang' => $hutang,
            'akunPenjualanDiskon' => $akunPenjualanDiskon,
            'akunPenjualanOngkir' => $akunPenjualanOngkir,
            'akunPenjualanFee' => $akunPenjualanFee
        ]);
    }

}
