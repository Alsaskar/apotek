<?php

session_start();
session_destroy();

if (isset($_COOKIE['ubah_password'])) { // jika user mengubah password, maka
	// user berhasil keluar 
	header("Location: /apotek");
}elseif (!isset($_COOKIE['ubah_password'])) { // jika user tidak mengubah password, maka
	// user berhasil keluar dan akan memberikan pesan bahwa user berhasil keluar
	header("Location: /apotek");
	setcookie('logout', 'logout_berhasil', time() + 3, '/');
}

?>