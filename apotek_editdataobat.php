<?php

$title = "Edit Obat";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// proses menambahkan data obat
if (isset($_POST['simpan'])) {
	$kode_obat   = $_POST['kode_obat'];
	$nama_obat 	 = ucwords($_POST['nama_obat']);
	$harga_modal = $_POST['harga_modal'];
	$harga_jual  = $_POST['harga_jual'];
	$stok        = $_POST['stok'];
	$expire      = $_POST['expire'];
	$no_faktur   = $_POST['no_faktur'];
	$tgl_faktur  = $_POST['tgl_faktur'];
	$jatuh_tempo = $_POST['jatuh_tempo'];
	$suplier     = htmlspecialchars($_POST['suplier']);
	$no_batch  = htmlspecialchars($_POST['no_batch']);

	$column = array("kode_obat", "nama_obat", "harga_modal", "harga_jual", "stok", "expire", "no_faktur", "tgl_faktur", "jatuh_tempo", "suplier", "no_batch");

	$data = array($kode_obat, $nama_obat, $harga_modal, $harga_jual, $stok, $expire, $no_faktur, $tgl_faktur, $jatuh_tempo, $suplier, $no_batch);
	
	$db->update("obat", $column, $data, array("id", $_GET['id']));

	header("Location: /apotek/data-obat");
	setcookie('edit_dataobat', 'berhasil', time() + 4, '/');
}

$query = $db->select("obat", "id", $_GET['id']);
$row = $query->fetch();

?>

<div class="container" style="margin-top: 2%;">
	<a href="/apotek/data-obat" class="btn btn-danger btn-sm">Kembali</a><hr>
	<h3>Edit Data Obat</h3><hr>
	
	<form id="tambah_dataobat" method="post" action="">
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="kode_obat">Kode Obat</label>
					<input type="text" name="kode_obat" class="input" id="kode_obat" readonly="readonly" value="<?php echo $row['kode_obat'] ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="no_batch">No Batch</label>
					<input type="text" name="no_batch" class="input" id="no_batch" value="<?php echo $row['no_batch'] ?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="nama_obat">Nama Obat</label>
			<input type="text" name="nama_obat" class="input" id="nama_obat" placeholder="Nama Obat" value="<?php echo $row['nama_obat'] ?>">
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="harga_modal">Harga Modal</label>
					<input type="text" name="harga_modal" class="input" id="harga_modal" placeholder="Contoh : 5000" value="<?php echo $row['harga_modal'] ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="harga_jual">Harga Jual</label>
					<input type="text" name="harga_jual" class="input" id="harga_jual" placeholder="Contoh : 5000" value="<?php echo $row['harga_jual'] ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="stok">Stok</label>
					<input type="text" name="stok" class="input" id="stok" placeholder="Contoh : 2" value="<?php echo $row['stok'] ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="expire">Expire</label>
					<input type="date" name="expire" class="input" id="expire" value="<?php echo $row['expire'] ?>">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="no_faktur">Nomor Faktur</label>
					<input type="text" name="no_faktur" class="input" id="no_faktur" placeholder="Nomor Faktur" value="<?php echo $row['no_faktur'] ?>">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="tgl_faktur">Tanggal Faktur</label>
					<input type="date" name="tgl_faktur" class="input" id="tgl_faktur" value="<?php echo $row['tgl_faktur'] ?>">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="jatuh_tempo">Jatuh Tempo</label>
					<input type="date" name="jatuh_tempo" class="input" id="jatuh_tempo" value="<?php echo $row['jatuh_tempo'] ?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="suplier">Suplier</label>
			<input type="text" name="suplier" class="input" id="suplier" placeholder="Suplier" value="<?php echo $row['suplier'] ?>">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
			<button type="button" class="btn btn-danger" id="reset">Reset</button>
		</div>
	</form>
</div>

<?php include("template/footer/footer_dashboard.php");  ?>
<script>
	// reset semua data obat
	$("#reset").click(function(){
		$("#nama_obat").val("");
		$("#harga_modal").val("");
		$("#harga_jual").val("");
		$("#stok").val("");
		$("#expire").val("");
		$("#no_faktur").val("");
		$("#tgl_faktur").val("");
		$("#jatuh_tempo").val("");
		$("#suplier").val("");
		$("#keterangan").val("");
	});
</script>

</body>
</html>