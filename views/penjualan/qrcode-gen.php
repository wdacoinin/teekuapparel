<?php

function qrrs($penjualan_produk, $faktur){
require_once '../assets/qr_code/qrlib.php'; 
 $tempdir = Yii::getAlias('@webroot') . "/upload/qrcode/"; //Nama folder tempat menyimpan file qrcode
   if (!file_exists($tempdir)) //Buat folder bername temp
   mkdir($tempdir);
   $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
   //ambil logo
   $logopath="../assets/images/LOGOW.png";

//isi qrcode jika di scan
$codeContents = $penjualan_produk;

$forecolor = "24, 57, 74";
$backcolor = "255, 255, 255";

//simpan file qrcode
QRcode::png($codeContents, $tempdir . $faktur . '.png', QR_ECLEVEL_H, 10, 4, 0, $forecolor, $backcolor);


// ambil file qrcode
$QR = imagecreatefrompng($tempdir . $faktur . '.png');

// memulai menggambar logo dalam file qrcode
$logo = imagecreatefromstring(file_get_contents($logopath));

imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
imagealphablending($logo , false);
imagesavealpha($logo , true);

$QR_width = imagesx($QR);
$QR_height = imagesy($QR);

$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Scale logo to fit in the QR Code
$logo_qr_width = $QR_width/8;
$scale = $logo_width/$logo_qr_width;
$logo_qr_height = $logo_height/$scale;

imagecopyresampled($QR, $logo, $QR_width/2.3, $QR_height/2.3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

// Simpan kode QR lagi, dengan logo di atasnya
imagepng($QR,$tempdir. $faktur . '.png');
$getqr = $actual_link . Yii::$app->request->baseUrl . '/upload/qrcode/' . $faktur . '.png';

return $getqr;

}
?>