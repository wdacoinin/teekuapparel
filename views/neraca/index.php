<?php
/* @var $this yii\web\View */

use kartik\date\DatePicker;
$this->title = 'Neraca';
if(isset($_GET['bulan'])){
    $m = $_GET['bulan'];
}else{
    $m = date('Y-m');
}

?>
<div class="col-md-12">
    <div class="row">
        <h1><?php echo $this->title; ?></h1>
    <?php
    echo '<label class="form-label">Pilih Bulan</label>';
    echo DatePicker::widget([
        'id' => 'bulan',
        'name' => 'bulan',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $m,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm'
        ]
    ]);
    ?>

        <table id="neraca" data-show-export="true" data-search="false" data-show-footer="true" data-show-columns="true" data-pagination="false" data-show-refresh="true" data-mobile-responsive="true" class="table table-striped table-sm table-hover" width="100%">
            <thead>
                <tr>
                    <th data-sortable="true" data-align="left" data-width="40" data-width-unit="%">Akun</th>
                    <th data-sortable="true" data-align="right" data-width="30" data-width-unit="%" data-formatter="priceFormatter" data-footer-formatter="num_ttl">Debit</th>
                    <th data-sortable="true" data-align="right" data-width="30" data-width-unit="%" data-formatter="priceFormatter" data-footer-formatter="num_ttl">Kredit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        KAS MASUK
                    </td>
                    <td>
                        <?php echo $akunsaldomasuk['total_saldo_add']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        PRIVE OWNER
                    </td>
                    <td>
                        <?php echo $akunsaldokeluar['total_saldo_keluar']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        PIUTANG
                    </td>
                    <td>
                        <?php echo $piutang; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        DISKON PENJUALAN
                    </td>
                    <td>
                        <?php echo $akunPenjualanDiskon['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        ONGKIR PENJUALAN
                    </td>
                    <td>
                        <?php echo $akunPenjualanOngkir['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        FEE PENJUALAN
                    </td>
                    <td>
                        <?php echo $akunPenjualanFee['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        STOK PEMBELIAN BERKURANG
                    </td>
                    <td>
                        <?php echo $akunPenjualanModal['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        GAJI KARYAWAN
                    </td>
                    <td>
                        <?php echo $akunGaji['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="../web/indexphp?r=beban-list">BEBAN OPERASIONAL</a>
                    </td>
                    <td>
                        <?php echo $akunBeban['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-danger">
                        MODAL
                    </td>
                    <td>
                    </td>
                    <td class="font-weight-bold text-danger">
                        <?php echo $modal; ?>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-primary">
                        PENJUALAN
                    </td>
                    <td>
                    </td>
                    <td class="font-weight-bold text-primary">
                        <?php echo $akunPenjualan['subtotal']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-danger">
                        HUTANG PEMBELIAN
                    </td>
                    <td>
                    </td>
                    <td class="font-weight-bold text-danger">
                        <?php echo $hutang; ?>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-warning">
                        MODAL PEMBELIAN
                    </td>
                    <td>
                    </td>
                    <td class="font-weight-bold text-warning">
                        <?php echo $akunPembelian['subtotal']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-success">
                        PENDAPATAN
                    </td>
                    <td>
                    </td>
                    <td class="font-weight-bold text-success">
                        <?php echo $pendapatan; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">

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

    function num_ttl(data) {
        var total = 0;

        if (data.length > 0) {

            var field = this.field;

            total = data.reduce(function(sum, row) {
                return sum + (+row[field]);
            }, 0);

            var num = rupiah(total);

            return num;
        }

        return '';
    }

    $(document).ready(function() {
        $('#neraca').bootstrapTable({
            sortable: true,
            exportDataType: $(this).val(),
            exportTypes: [
                'csv',
                'excel',
                'pdf'
            ],
            formatLoadingMessage: function() {
                return '<div class="col" style="min-heigth:200px"><button class="font-italic btn btn-success" style="margin:2em auto;">Loading</button></div>';
            }
        });
        $('#bulan').on('change', function(){
            console.log($(this).val());
            location.replace('indexphp?r=neraca&bulan=' + $(this).val());
        });
    });
</script>