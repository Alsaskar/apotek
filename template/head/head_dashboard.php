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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="/apotek/library/font-awesome/css/fontawesome.min.css">
    <link href="/apotek/library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/apotek/library/bootstrap/css/mdb.min.css" rel="stylesheet">
    <link href="/apotek/library/css/style.css" rel="stylesheet">
    <link href="/apotek/library/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/apotek/library/sweetalert/dist/sweetalert.css">
	<script src="/apotek/library/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="/apotek/library/image/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="/apotek/library/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/apotek/library/select2/dist/css/select2.min.css">
    <title><?php echo $title; ?></title>
</head>
<body>