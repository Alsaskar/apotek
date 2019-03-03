<?php

// memulai session
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "klinik_apotekdb";

try{
	$connect = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOexception $e){
	echo $e->getMessage();
}

?>