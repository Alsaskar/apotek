<?php

include("config/koneksi.php");
include("config/class_db.php");

$db = new Database($connect);

require('library/fpdf/fpdf.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm' ,'A4');

// membuat halaman baru
$pdf->AddPage();

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',16);

$pdf->SetTitle('LAPORAN DATA PETUGAS');

// mencetak string 
$pdf->Cell(190, 7,'APOTEK PNIEL FARMA, TOMOHON - SULUT', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(190, 7,'DATA-DATA PETUGAS APOTEK', 0, 1, 'C');
 
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 7,'', 0, 1);
 
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 6, 'No', 1, 0);
$pdf->Cell(80, 6, 'Nama Petugas', 1, 0);
$pdf->Cell(50, 6, 'Nomor Telepon', 1, 0);
$pdf->Cell(27, 6, 'Username', 1, 0);
$pdf->Cell(25, 6, 'Level', 1, 1);
 
$pdf->SetFont('Arial', '', 10);

$petugas = $db->select('petugas');
$no = 1;

while ($row = $petugas->fetch()){
	$pdf->Cell(15, 6, $no++, 1, 0);
    $pdf->Cell(80, 6, $row['nm_petugas'], 1, 0);
    $pdf->Cell(50, 6, $row['no_telepon'], 1, 0);
    $pdf->Cell(27, 6, $row['username'], 1, 0);
    $pdf->Cell(25, 6, $row['level'], 1, 1); 
}

$pdf->Cell(40, 10,'Jumlah Petugas : '.$petugas->rowCount());
 
$pdf->Output();

?>
