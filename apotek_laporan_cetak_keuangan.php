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

$pdf->SetTitle('LAPORAN KEUANGAN');

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',16);

// mencetak string 
$pdf->Cell(250, 7,'APOTEK MERDI, TOMOHON - SULUT', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 12); 
$pdf->Cell(190, 7,'DATA-DATA LAPORAN KEUANGAN PENJUALAN', 0, 1, 'L');

$query = $connect->prepare("SELECT penjualan.*, penjualan_item.*, obat.* FROM penjualan, penjualan_item, obat WHERE penjualan.tgl_penjualan BETWEEN :tglAwal AND :tglAkhir AND penjualan.no_penjualan = penjualan_item.no_penjualan AND penjualan_item.kd_obat = obat.kode_obat");
$query->execute(array(":tglAwal" => $_GET['tglAwal'], ":tglAkhir" => $_GET['tglAkhir']));
 
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 5, '', 0, 1);
 
$pdf->SetFont('Arial','B', 10);
$pdf->Cell(15, 6, 'No', 1, 0);
$pdf->Cell(50, 6, 'Tgl Penjualan', 1, 0);
$pdf->Cell(100, 6, 'Nama Obat', 1, 0);
$pdf->Cell(27, 6, 'Harga Modal', 1, 0);
$pdf->Cell(20, 6, 'Harga Jual', 1, 0);
$pdf->Cell(50, 6, 'Jumlah', 1, 1);
 
$pdf->SetFont('Arial','', 10);

$no = 1;

$total_modal = 0; $total_jual = 0;

while ($row = $query->fetch()){

    $subTotalModal = $row['harga_modal'] * $row['jumlah'];
    $total_modal = $total_modal + $subTotalModal;

    $subTotalJual = $row['harga_jual'] * $row['jumlah'];
    $total_jual = $total_jual + $subTotalJual;

    $pdf->Cell(15, 6, $no++, 1, 0);
    $pdf->Cell(50, 6, $row['tgl_penjualan'], 1, 0);
    $pdf->Cell(100, 6, $row['nama_obat'], 1, 0);
    $pdf->Cell(27, 6, $fungsi->format_angka($row['harga_modal']), 1, 0);
    $pdf->Cell(20, 6, $fungsi->format_angka($row['harga_jual']), 1, 0);    
    $pdf->Cell(50, 6, $row['jumlah'], 1, 1);
}

$pdf->Cell(250, 10,'Total Modal : '.$fungsi->format_angka($total_modal).' ', 0, 1, 'L');
$pdf->Cell(250, 4,'Total Jual : '.$fungsi->format_angka($total_jual).'', 0, 1, 'L');
 
$pdf->Output();

?>
