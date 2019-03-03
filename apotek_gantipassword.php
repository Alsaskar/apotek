<?php

$title = "Ganti Password";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// proses ganti password
if (isset($_POST['simpan'])) {

	// password baru
	$pass_ubah = password_hash($_POST['pass_baru'], PASSWORD_DEFAULT);
	
	$db->update("petugas", array("password"), array($pass_ubah), array("username", $_SESSION['user']));

	setcookie('ubah_password', 'berhasil', time() + 4, '/');
	header("Location: /apotek/logout.php");

}

?>

<div class="container" style="margin-top: 2%;">
	<h2 class="text-center">Ganti Password</h2><hr>
	<div class="alert alert-danger">Jika anda mengubah password, maka anda akan otomatis keluar dari aplikasi dan harus masuk kembali.<br><br> Password baru yang anda ubah jangan sampai lupa.</div><hr>
	<form id="form_gantipassword" method="post">
		<div class="form-group">
			<label for="pass_lama">Password Lama</label>
			<input type="password" name="pass_lama" class="input" id="pass_lama" placeholder="Password Lama">
		</div>
		<div class="form-group">
			<label for="pass_baru">Password Baru</label>
			<input type="password" name="pass_baru" class="input" id="pass_baru" placeholder="Password Baru">
		</div>
		<div class="form-group">
			<label for="repeat_pass_baru">Ulangi Password Baru</label>
			<input type="password" name="repeat_pass_baru" class="input" id="repeat_pass_baru" placeholder="Ulangi Password Baru">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-md" name="simpan">Simpan Perubahan</button>
		</div>
	</form>
</div>

<?php include("template/footer/footer_dashboard.php");  ?>

</body>
</html>