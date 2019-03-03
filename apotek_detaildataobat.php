<?php

$title = "Detail Data Obat";
include("template/head/head_dashboard.php");
include("template/header/header.php");

$query = $db->select("obat", "id", $_GET['id']);
$row = $query->fetch();

?>

<div class="container" style="margin-top: 2%;">
	<a href="/apotek/data-obat" class="btn btn-danger btn-sm">Kembali</a><hr>
	<h2 class="text-center">Detail Data Obat</h2><hr>
	
	<div class="card">
		<div class="card-body">
		<?php

		if ($row['status_expire'] == "sudah") {
    		echo '<div class="alert alert-danger">Sudah Kadaluarsa.</div>';
    	}elseif ($row['status_expire'] == "belum") {
    		echo '<div class="alert alert-info">Belum Kadaluarsa.</div>';
    	}

		?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="kode_obat">Kode Obat</label>
						<input type="text" name="kode_obat" class="input" id="kode_obat" disabled value="<?php echo $row['kode_obat'] ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="no_batch">No Batch</label>
						<input type="text" name="no_batch" class="input" id="no_batch" disabled value="<?php echo $row['no_batch'] ?>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="nama_obat">Nama Obat</label>
				<input type="text" name="nama_obat" class="input" id="nama_obat" disabled value="<?php echo $row['nama_obat'] ?>">
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="harga_modal">Harga Modal</label>
						<input type="text" name="harga_modal" class="input" id="harga_modal" disabled value="<?php echo $row['harga_modal'] ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="harga_jual">Harga Jual</label>
						<input type="text" name="harga_jual" class="input" id="harga_jual" disabled value="<?php echo $row['harga_jual'] ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="stok">Stok</label>
						<?php

	                	if ($row['stok'] > 0) {
	                		echo '<input type="text" name="stok" class="input" id="stok" disabled value="'.$row['stok'].'">';
	                	}else{
	                		echo '<input type="text" name="stok" class="input" id="stok" disabled value="sudah habis.">.';
	                	}

	                	?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="expire">Expire</label>
						<input type="date" name="expire" class="input" id="expire" disabled value="<?php echo $row['expire'] ?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="no_faktur">Nomor Faktur</label>
						<input type="text" name="no_faktur" class="input" id="no_faktur" disabled value="<?php echo $row['no_faktur'] ?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="tgl_faktur">Tanggal Faktur</label>
						<input type="date" name="tgl_faktur" class="input" id="tgl_faktur" disabled value="<?php echo $row['tgl_faktur'] ?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="jatuh_tempo">Jatuh Tempo</label>
						<input type="date" name="jatuh_tempo" class="input" id="jatuh_tempo" disabled value="<?php echo $row['jatuh_tempo'] ?>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="suplier">Suplier</label>
				<input type="text" name="suplier" class="input" id="suplier" disabled value="<?php echo $row['suplier'] ?>">
			</div>
		</div>
	</div>
</div><br>

<?php include("template/footer/footer_dashboard.php");  ?>

</body>
</html>