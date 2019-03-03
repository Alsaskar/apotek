<?php

include("config/koneksi.php");
include("config/class_db.php");
include("config/class_fungsi.php");

$db = new Database($connect);
$fungsi = new Fungsi();

if (!isset($_SESSION['user'])) { // jika user belum login
	header("Location: /apotek/");
}

$get = $db->select("petugas", "username", $_SESSION['user']);
$getuser = $get->fetch();

if(isset($_GET['noNota'])){
    $noNota = $_GET['noNota'];
    
    // Perintah untuk mendapatkan data dari tabel penjualan
    $query = $connect->prepare("SELECT penjualan.*, petugas.nm_petugas FROM penjualan LEFT JOIN petugas ON penjualan.id_petugas = petugas.id WHERE no_penjualan = :no_penjualan");
    $query->execute(array(":no_penjualan" => $noNota));
    $kolomData = $query->fetch();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="/apotek/library/font-awesome/css/fontawesome.min.css">
  <link href="/apotek/library/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/apotek/library/sweetalert/dist/sweetalert.css">
	<script src="/apotek/library/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="shortcut icon" href="/apotek/library/image/logo.jpeg">
  <link rel="stylesheet" type="text/css" href="/apotek/library/datatables/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="/apotek/library/select2/dist/css/select2.min.css">
  <title>Cetak Nota Penjualan Obat</title>
  <script type="text/javascript">
      window.print();
      window.onfocus = function(){ window.close();}
  </script>
</head>
<body onLoad="window.print()">

    <table class="table-list" width="430" border="0" cellspacing="0" cellpadding="2" style="margin-top: 2%;">
      <tr>
        <td height="87" colspan="5" align="center">
            <strong>APOTEK PNIEL FARMA</strong><br>
            <strong>Alamat : </strong> Jalan Raya Tomohon Kakaskasen II<br> Lingkungan 2 Kota Tomohon, Sulawesi Utara<br>
            <strong>NPWP/ PKP : </strong>84.745.484.0-821.000<br>
            Kota Tomohon, SULUT </td>
      </tr>
      <tr>
        <td colspan="2"><strong>No Nota :</strong> <?php echo $kolomData['no_penjualan']; ?></td>
        <td colspan="3"> <?php echo $fungsi->IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
      </tr>
      <tr>
        <td width="32" bgcolor="#F5F5F5"><strong>No</strong></td>
        <td width="100" bgcolor="#F5F5F5"><strong>Daftar Obat </strong></td>
        <td width="55" bgcolor="#F5F5F5"><strong>Harga@</strong></td>
        <td width="3" bgcolor="#F5F5F5"><strong>Qty</strong></td>
        <td width="97" bgcolor="#F5F5F5"><strong>Subtotal(Rp) </strong></td>
      </tr>
        <?php
        # Baca variabel
        $totalBayar = 0; 
        $jumlahObat = 0;  
        $uangKembali=0;

        # Menampilkan List Item obat yang dibeli untuk Nomor Transaksi Terpilih
        $notaSql = $connect->prepare("SELECT penjualan_item.*, obat.nama_obat FROM penjualan_item LEFT JOIN obat ON penjualan_item.kd_obat = obat.kode_obat WHERE penjualan_item.no_penjualan = :no_penjualan ORDER BY obat.kode_obat ASC");
        $notaSql->execute(array(":no_penjualan" => $noNota));
        $nomor  = 0;
        while ($notaData = $notaSql->fetch()) {
        $nomor++;
            $subSotal   = $notaData['jumlah'] * $notaData['harga_jual'];
            $totalBayar = $totalBayar + $subSotal;
            $jumlahObat = $jumlahObat + $notaData['jumlah'];
            $uangKembali= $kolomData['uang_bayar'] - $totalBayar;
        ?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $notaData['kd_obat']; ?>/  <?php echo $notaData['nama_obat']; ?></td>
        <td align="right"><?php echo $fungsi->format_angka($notaData['harga_jual']); ?></td>
        <td align="right"><?php echo $notaData['jumlah']; ?></td>
        <td><?php echo $fungsi->format_angka($subSotal); ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="2"><strong>Total Belanja (Rp) : </strong></td>
        <td colspan="3" bgcolor="#F5F5F5"><?php echo $fungsi->format_angka($totalBayar); ?></td>
      </tr>
      <tr>
        <td colspan="2"><strong> Uang Bayar (Rp) : </strong></td>
        <td colspan="3"><?php echo $fungsi->format_angka($kolomData['uang_bayar']); ?></td>
      </tr>
      <tr>
        <td colspan="2"><strong>Uang Kembali (Rp) : </strong></td>
        <td colspan="3"><?php echo $fungsi->format_angka($uangKembali); ?></td>
      </tr>
      <tr>
        <td colspan="5"><strong>Petugas :</strong> <?php echo $kolomData['nm_petugas']; ?></td>
      </tr>
    </table>

</body>
</html>