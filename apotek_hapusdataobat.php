<?php

include("config/koneksi.php");
include("config/class_db.php");

$db = new Database($connect);

$query = $db->select("obat", "id", $_GET['id']);
$row = $query->fetch();

if (isset($_GET['id'])) {

	if ($_GET['id'] == $row['id']) { // jika get id sama dengan id pada tabel obat, maka
		// data akan terhapus sesuai id
		$db->delete("obat", "id", $_GET['id']);
		header("Location: /apotek/data-obat");
		setcookie('hapus_dataobat', 'berhasil', time() + 4, '/');
	}elseif ($_GET['id'] != $row['id']) { // jika get id tidak sama dengan id pada tabel obat, maka
		// halaman akan di redirect
		header("Location: /apotek/data-obat");
	}
	
}

?>