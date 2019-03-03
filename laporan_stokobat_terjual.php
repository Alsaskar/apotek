<?php

include("config/koneksi.php");
include("config/class_db.php");
include("config/class_fungsi.php");

$db = new Database($connect);
$fungsi = new Fungsi();

require('library/fpdf/fpdf.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');

// membuat halaman baru
$pdf->AddPage();

$pdf->SetTitle('LAPORAN DATA STOK OBAT TERJUAL');

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',16);

// mencetak string 
$pdf->Cell(190, 7,'APOTEK PNIEL FARMA, TOMOHON - SULUT', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(190, 7,'DATA STOK OBAT YANG TERJUAL', 0, 1, 'C');
 
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 7,'', 0, 1);
 
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 6, 'No', 1, 0);
$pdf->Cell(30, 6, 'Kode Obat', 1, 0);
$pdf->Cell(40, 6, 'No Batch', 1, 0);
$pdf->Cell(80, 6, 'Nama Obat', 1, 0);
$pdf->Cell(25, 6, 'Stok Terjual', 1, 1);
 
$pdf->SetFont('Arial', '', 10);

$obat = $connect->prepare("SELECT * FROM obat_laku ORDER BY nama_obat ASC");
$obat->execute();

$no = 1;

while ($row = $obat->fetch()){
    $pdf->Cell(15, 6, $no++, 1, 0);
    $pdf->Cell(30, 6, $row['kd_obat'], 1, 0);
    $pdf->Cell(40, 6, $row['no_batch'], 1, 0);
    $pdf->Cell(80, 6, $row['nama_obat'], 1, 0);
    $pdf->Cell(25, 6, $row['stok_laku'], 1, 1);
}

// $pdf->Cell(20,8 ,'asd','','','',false, "http://www.intranet.com/mb/rprh06/final.php?folio=");
 
$pdf->Output();

?>
