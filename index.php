<?php

$title = "Apotek Klinik";
include("template/head/head.php");

// $merdi="merdi";
// $pass = password_hash("merdi", PASSWORD_DEFAULT);
// $value = array("username" => $merdi, "password" => $pass);
// 	$db->insert("petugas", $value);

// proses form login
if (isset($_POST['masuk'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $fetch = $db->select("petugas", "username", $username);
    $row   = $fetch->fetch();

    if ($fetch->rowCount() > 0) { // jika email ada
            
        if (password_verify($password, $row['password'])) { // jika password input sama dengan password yang ada di database

            $_SESSION['user'] = $row['username']; // buat session dengan nama "user"
            
            header("Location: /apotek/dashboard"); // redirect halaman dashboard

        }else{ // jika password salah
            echo '<script>sweetAlert("", "Password salah.", "error");</script>';
        }

    }else{ // apabila username tidak ada
        echo '<script>sweetAlert("", "Username salah atau belum terdaftar.", "error");</script>';
    }
}

?>

<div class="container" style="margin-top: 2%;">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body" style="height: 400px">
					<?php if(isset($_COOKIE['logout'])){ // jika user berhasil logout ?>
					<div class="alert alert-success">Anda berhasil keluar !</div>
					<?php } ?>

					<?php if(isset($_COOKIE['ubah_password'])){ // jika user berhasil mengubah password ?>
					<div class="alert alert-success">Anda berhasil mengubah password. Silahkan masuk kembali dengan password baru !</div>
					<?php } ?>
					<form id="form_login" method="post">
						<div class="error"></div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" id="username" class="input" placeholder="Username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="input" placeholder="Password">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-outline-primary waves-effect" name="masuk">Masuk</button>
						</div>
					</form>
				</div>
			</div>
		<br></div>

		<div class="col-md-6">
			
			<!-- Card -->
			<div class="card card-image mb-3" style="background-image: url(library/image/logo.jpeg);background-size: cover;">

			    <!-- Content -->
			    <div class="text-white text-center d-flex align-items-center rgba-black-strong py-5 px-4">
			        <div>
			            <h3 style="font-size: 5em">Pniel Farma</h3>
			            <p>Jalan Raya Tomohon Kakaskasen II Lingkungan 2 Kota Tomohon, Sulawesi Utara.</p>
			            <p>Nomor Telpon : 08114385464</p>
			        </div>
			    </div>
			    <!-- Content -->
			</div>
			<!-- Card -->
		</div>
	</div>
</div>


<?php include("template/footer/footer.php");  ?>

</body>
</html>