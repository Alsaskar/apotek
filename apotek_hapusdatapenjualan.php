<?php

include("config/koneksi.php");
include("config/class_db.php");

$db = new Database($connect);

$query = $db->select("penjualan", "no_penjualan", $_GET['kode_penjualan']);
$row = $query->fetch();

if (isset($_GET['kode_penjualan'])) {

	if ($_GET['kode_penjualan'] == $row['no_penjualan']) { // jika get id sama dengan id pada tabel obat, maka

		// data akan terhapus sesuai id
		$db->delete("penjualan", "no_penjualan", $_GET['kode_penjualan']);

		// mengambil data dari tabel penjualan_item
		$get_item = $db->select("penjualan_item", "no_penjualan", $_GET['kode_penjualan']);
		
		while($row_item = $get_item->fetch()){
			$KodeObat	= $row_item['kd_obat'];
			$jumlah		= $row_item['jumlah'];

			// kembalikan stok obat
			$edit = $connect->prepare("UPDATE obat SET stok = stok + $jumlah WHERE kode_obat = :kd_obat");
			$edit->execute(array(":kd_obat" => $KodeObat));
		}

		// Hapus data pada tabel anak (penjualan_item)
		$db->delete("penjualan_item", "no_penjualan", $_GET['kode_penjualan']);

		header("Location: /apotek/data-penjualan");
		setcookie('hapus_datapenjualan', 'berhasil', time() + 4, '/');

	}elseif ($_GET['kode_penjualan'] != $row['no_penjualan']) { // jika get id tidak sama dengan id pada tabel obat, maka
		// halaman akan di redirect
		header("Location: /apotek/data-penjualan");
	}
	
}

?>