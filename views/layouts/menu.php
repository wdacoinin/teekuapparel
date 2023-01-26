
<?php 

function menu_list($divisi, $divisiName){ 
if( $divisi == 2 || $divisi == 1){
?>
    <li class="sidebar-item">
        <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> Data Penjualan</span>
        </a>

        <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order" style="border-top: #eaeaea;"> Order Masuk</a></li>
            
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/orderselesai" style="border-top: #eaeaea;"> Order Jalan</a></li>
            
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/ordertagihan" style="border-top: #eaeaea;"> Order Tagihan</a></li>
            
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/orderlunas" style="border-top: #eaeaea;"> Order Lunas</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/batalorder" style="border-top: #eaeaea;"> Order Batal</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=ordertrack" style="border-top: #eaeaea;"> Tracking Order</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=pembayaran-penjualan" style="border-top: #eaeaea;"> Transaksi Penjualan</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=pembelian" style="border-top: #eaeaea;"> Pembelian</a></li> -->
        </ul>

        <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> Data Pembelian</span>
        </a>

        <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=pembelian-view" style="border-top: #eaeaea;"> Pembelian</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=pembayaran-pembelian" style="border-top: #eaeaea;"> Transaksi Pembelian</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=global-stok" style="border-top: #eaeaea;"> Global Stok</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=update-stok" style="border-top: #eaeaea;"> Update Stok</a></li>
        </ul>

        <a data-target="#sb3" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> Kas</span>
        </a>

        <ul id="sb3" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=beban-list" style="border-top: #eaeaea;"> Pengeluaran Kas Kecil</a></li>
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=akun-saldo" style="border-top: #eaeaea;"> Penambahan / Pengambilan Kas</a></li>
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=penjualan-kotor" style="border-top: #eaeaea;"> Report Laba kotor</a></li>
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=neraca" style="border-top: #eaeaea;"> Neraca</a></li>
        </ul>

        <a data-target="#sb4" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb4" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=supplier" style="border-top: #eaeaea;"> Supplier</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=beban" style="border-top: #eaeaea;"> Beban</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=bahan-baku" style="border-top: #eaeaea;"> Bahan Baku</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=produk" style="border-top: #eaeaea;"> Produk</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=sku" style="border-top: #eaeaea;"> SKU</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=sku/userview" style="border-top: #eaeaea;"> SKU Desainer</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=sku/skuordersadm" style="border-top: #eaeaea;"> SKU Order</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=produk-item" style="border-top: #eaeaea;"> Produk Item</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=divisi" style="border-top: #eaeaea;"> Divisi</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=backend-user" style="border-top: #eaeaea;"> Karyawan & User</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=akun" style="border-top: #eaeaea;"> Akun Bank</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=variable" style="border-top: #eaeaea;"> Teekuapparel Setting</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=download-apk" style="border-top: #eaeaea;"> Download Apk Android</a></li> -->

        </ul>

        <!-- <a data-target="#sb3" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="trending-up"></i> <span class="align-middle"> Report</span>
        </a>

        <ul id="sb3" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="#" style="border-top: #eaeaea;"> Rugi / Laba</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="#" style="border-top: #eaeaea;"> Global Report</a></li>

        </ul> -->
    </li>
 <?php }elseif( $divisi == 3){ ?>
     <li class="sidebar-item">
         <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
             <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> <?php echo ucfirst($divisiName); ?></span>
         </a>
 
         <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
             <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order" style="border-top: #eaeaea;"> Order</a></li>
 
             <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=tracking-order" style="border-top: #eaeaea;"> Tracking Order</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=pembayaran-penjualan" style="border-top: #eaeaea;"> Transaksi Penjualan</a></li>
         </ul>
 
         <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
             <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
         </a>
 
         <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
 
             <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=akun" style="border-top: #eaeaea;"> Akun Bank</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=produk" style="border-top: #eaeaea;"> Produk</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=download-apk" style="border-top: #eaeaea;"> Download Apk Android</a></li> -->
 
         </ul>
 
     </li>
 
<?php }elseif( $divisi == 5){ ?>
    <li class="sidebar-item">
        <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order" style="border-top: #eaeaea;"> Order Masuk</a></li>
            
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/orderdesainer" style="border-top: #eaeaea;"> Order Jalan</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=tracking-order" style="border-top: #eaeaea;"> Tracking Order</a></li> -->
        </ul>

        <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=sku/userview" style="border-top: #eaeaea;"> SKU Desainer</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=sku/skuorders" style="border-top: #eaeaea;"> SKU Bulan Ini</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li> -->

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=download-apk" style="border-top: #eaeaea;"> Download Apk Android</a></li> -->

        </ul>

    </li>

<?php } else { ?> 
    <li class="sidebar-item">
        <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order" style="border-top: #eaeaea;"> Order</a></li>
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/orderagendone" style="border-top: #eaeaea;"> Order Jalan</a></li>
            
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/ordertagihan" style="border-top: #eaeaea;"> Order Tagihan</a></li>
            
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=order/orderlunas" style="border-top: #eaeaea;"> Order Lunas</a></li>
        </ul>

        <!-- <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
        </a> -->

        <!-- <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/indexphp?r=download-apk" style="border-top: #eaeaea;"> Download Apk Android</a></li>

        </ul> -->
    </li>
<?php } ?> 

<?php } ?>