<?php

$title = "Dashboard Apotek Klinik";
include("template/head/head_dashboard.php");
include("template/header/header.php");

?>

<div class="container" style="margin-top: 2%;">

	<div class="view overlay zoom">
		<center><img src="library/image/logo.jpeg" class="img-fluid" style="height: 350px"></center>
	</div>
	<br>
	<h2 align="center">Selamat datang di Apotek PNIEL FARMA, Tomohon - SULUT!</h2>
	<h4 align="center">Anda masuk sebagai <?php echo $getuser['level'] ?></h4>
</div>

<?php include("template/footer/footer_dashboard.php");  ?>

</body>
</html>