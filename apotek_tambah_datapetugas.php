<?php

$title = "Tambah Data Petugas";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// proses tambah data
if (isset($_POST['simpan'])) {
	$nama 		= htmlspecialchars($_POST['nama']);
	$no_telepon = htmlspecialchars($_POST['no_telepon']);
	$username 	= htmlspecialchars($_POST['username']);
	$password 	= password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
	$status 	= $_POST['status'];

	$value = array("nm_petugas" => $nama, "no_telepon" => $no_telepon, "username" => $username, "password" => $password, "level" => $status);
	$db->insert("petugas", $value);

	header("Location: /apotek/data-petugas");
	setcookie('tambah_datapetugas', 'berhasil', time() + 4, '/');
}

?>

<div class="container" style="margin-top: 2%;">
	<a href="/apotek/data-petugas" class="btn btn-outline-danger btn-sm">Kembali</a><hr>
	<h3>Tambah Data Petugas</h3><hr>
	<form method="post" action="" id="form_addPetugas">
		<div class="error"></div>
		<div class="form-group">
			<label for="nama">Nama</label>
			<input type="text" name="nama" id="nama" class="input" placeholder="Masukan Nama">
		</div>
		<div class="form-group">
			<label for="no_telepon">Nomor Telepon</label>
			<input type="text" name="no_telepon" id="no_telepon" class="input" placeholder="Masukan Nomor Telepon">
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="input" placeholder="Masukan Username">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="input" placeholder="Masukan Password">
		</div>
		<div class="form-group">
			<input type="checkbox" onclick="showPassword()"> Show Password
		</div>
		<div class="form-group">
			<label for="nama">Status</label>
			<select class="select-input" name="status" id="status">
				<option value="">...</option>
				<option value="Admin">Admin</option>
				<option value="Kasir">Kasir</option>
			</select>
		</div>
		<div class="form-group" style="margin-left: -0.50%;">
			<button type="submit" class="btn btn-outline-primary btn-md" name="simpan">Simpan</button>
		</div>
	</form>
	
</div>

<?php include("template/footer/footer_dashboard.php");  ?>
<script>
	function showPassword(){
		var pass = document.getElementById("password");

		if (pass.type === "password") {
	        pass.type = "text";
	    } else {
	        pass.type = "password";
	    }
	}
</script>

</body>
</html>