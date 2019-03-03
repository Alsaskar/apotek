<?php

include("config/koneksi.php");
include("config/class_db.php");
include("config/class_fungsi.php");

$db = new Database($connect);
$fungsi = new Fungsi();

require('library/fpdf/fpdf.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A3');

// membuat halaman baru
$pdf->AddPage();

$pdf->SetTitle('LAPORAN DATA OBAT');

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',16);

// mencetak string 
$pdf->Cell(250, 7,'APOTEK PNIEL FARMA, TOMOHON - SULUT', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(190, 7,'DATA-DATA OBAT', 0, 1, 'L');

$obat = $connect->prepare("SELECT * FROM obat ORDER BY nama_obat ASC");
$obat->execute();
 
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 5, '', 0, 1);
 
$pdf->SetFont('Arial','B', 10);
$pdf->Cell(15, 6, 'No', 1, 0);
$pdf->Cell(25, 6, 'Kode Obat', 1, 0);
$pdf->Cell(40, 6, 'No Batch', 1, 0);
$pdf->Cell(50, 6, 'Nama Obat', 1, 0);
$pdf->Cell(27, 6, 'Harga', 1, 0);
$pdf->Cell(20, 6, 'Stok', 1, 0);
$pdf->Cell(25, 6, 'Expire', 1, 0);
$pdf->Cell(80, 6, 'Suplier', 1, 1);
 
$pdf->SetFont('Arial','', 10);

$no = 1;

while ($row = $obat->fetch()){
    $pdf->Cell(15, 6, $no++, 1, 0);
    $pdf->Cell(25, 6, $row['kode_obat'], 1, 0);
    $pdf->Cell(40, 6, $row['no_batch'], 1, 0);
    $pdf->Cell(50, 6, $row['nama_obat'], 1, 0);
    $pdf->Cell(27, 6, $fungsi->format_angka($row['harga_jual']), 1, 0);
    if ($row['stok'] == 0) {
    	$pdf->Cell(20, 6, 'Habis.', 1, 0);
    }else{
    	$pdf->Cell(20, 6, $row['stok'], 1, 0);
    }
    $pdf->Cell(25, 6, $row['expire'], 1, 0);
    $pdf->Cell(80, 6, $row['suplier'], 1, 1);
}

// $pdf->Cell(20,8 ,'asd','','','',false, "http://www.intranet.com/mb/rprh06/final.php?folio=");
 
$pdf->Output();

?>
