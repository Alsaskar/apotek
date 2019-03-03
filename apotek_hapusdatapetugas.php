<?php

include("config/koneksi.php");
include("config/class_db.php");

$db = new Database($connect);

$query = $db->select("petugas", "id", $_GET['id']);
$row = $query->fetch();

if (isset($_GET['id'])) {

	if ($_GET['id'] == $row['id']) { // jika get id sama dengan id pada tabel petugas, maka
		// data akan terhapus sesuai id
		$db->delete("petugas", "id", $_GET['id']);
		header("Location: /apotek/data-petugas");
		setcookie('hapus_datapetugas', 'berhasil', time() + 4, '/');
	}elseif ($_GET['id'] != $row['id']) { // jika get id tidak sama dengan id pada tabel petugas, maka
		// halaman akan di redirect
		header("Location: /apotek/data-petugas");
	}
	
}

?>