<?php

include("../config/koneksi.php");
include("../config/class_db.php");
$db = new Database($connect);

$fetch = $db->select("petugas", "username", $_SESSION['user']);
$row   = $fetch->fetch();

if ($_POST['pass_lama'] == password_verify($_POST['pass_lama'], $row['password'])) {
	$valid = "true";
}else{
	$valid = "false";
}

echo $valid;

?>