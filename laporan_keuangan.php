<?php

$title = "Data Penjualan";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// Jika data penjualan berhasil di hapus
if (isset($_COOKIE['hapus_datapenjualan'])) {
	echo '<script>sweetAlert("", "Data penjualan berhasil di hapus.", "success");</script>';
}

?>

<div class="container" style="margin-top: 2%;margin-bottom: 2%;">
	<h2 style="font-size: 30px"><b>LAPORAN PENJUALAN KEUANGAN PER PERIODE</b></h2><hr>
	<h4 style="font-size: 15px">PERIODE PENJUALAN : </h4>
	<form method="get" action="">
		<div class="row">
			<div class="col-md-3">
				<input name="txtTglAwal" type="date" class="input" value="<?php echo date('Y-m-d') ?>" />
			</div>
			<div class="col-md-3">
				<input name="txtTglAkhir" type="date" class="input" value="<?php echo date('Y-m-d') ?>" />
			</div>
			<div id="prosesPeriode">
				<div class="col-md-3">
					<input type="submit" name="proses" class="btn btn-outline-primary btn-sm" value="Tampilkan">
				</div>
			</div>
			<div id="prosesPeriode">
			<?php if(isset($_GET['proses'])){ ?>
				<div class="col-md-3">
					<a href="/apotek/laporan/cetak/keuangan/<?php echo $_GET['txtTglAwal'] ?>/<?php echo $_GET['txtTglAkhir'] ?>" class="btn btn-outline-danger btn-sm" target="_blank">Laporan</a>
				</div>
			<?php }else{ ?>
				<div class="col-md-3">
					<a href="/apotek/laporan/cetak/keuangan/semua" class="btn btn-outline-danger btn-sm" target="_blank">Laporan</a>
				</div>
			<?php } ?>
			</div>
		</div>
	</form><hr>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered table-sm">
	        <thead>
	            <tr>
	                <th>No</th>
	                <th>Tgl Penjualan</th>
	                <th>Nama Obat</th>
	                <th>Harga Modal</th>
	                <th>Harga Jual</th>
	                <th>Jumlah</th>
	                <th>Opsi</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php

	        if (isset($_GET['proses'])) {
	        	
        	$query = $connect->prepare("SELECT penjualan.*, penjualan_item.*, obat.* FROM penjualan, penjualan_item, obat WHERE penjualan.tgl_penjualan BETWEEN :tglAwal AND :tglAkhir AND penjualan.no_penjualan = penjualan_item.no_penjualan AND penjualan_item.kd_obat = obat.kode_obat AND penjualan.id_petugas = :kd_petugas");
	        $query->execute(array(":tglAwal" => $_GET['txtTglAwal'], ":tglAkhir" => $_GET['txtTglAkhir'], ":kd_petugas" => $getuser['id']));

	        $no = 1;

	        $total_modal = 0; $total_jual = 0;

	        while ($row = $query->fetch()) {

	        	$subTotalModal = $row['harga_modal'] * $row['jumlah'];
	            $total_modal = $total_modal + $subTotalModal;

	        	$subTotalJual = $row['harga_jual'] * $row['jumlah'];
	            $total_jual = $total_jual + $subTotalJual;

	        ?>

	            <tr>
	                <td><?php echo $no++ ?></td>
	                <td><?php echo $row['tgl_penjualan'] ?></td>
	                <td><?php echo $row['nama_obat'] ?></td>
	                <td><?php echo $fungsi->format_angka($row['harga_modal']) ?></td>
	                <td><?php echo $fungsi->format_angka($row['harga_jual']) ?></td>
	                <td><?php echo $row['jumlah'] ?></td>
	                <td>
	                	<a href="/apotek/nota-penjualan/<?php echo $row['no_penjualan'] ?>" target="_blank" class="btn btn-sm btn-info" title="Nota"><i class="fas fa-print"></i></a>
	                	<a href="/apotek/hapus-penjualan/<?php echo $row['no_penjualan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data penjualan ini ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
	                </td>
	            </tr>

	        <?php }}else{ // jika url proses belum diset ?>

        	<?php

        	$query = $connect->prepare("SELECT penjualan.*, penjualan_item.*, obat.* FROM penjualan, penjualan_item, obat WHERE penjualan.no_penjualan = penjualan_item.no_penjualan AND penjualan_item.kd_obat = obat.kode_obat AND penjualan.id_petugas = :kd_petugas");
	        $query->execute(array(":kd_petugas" => $getuser['id']));

	        $no = 1;

	        $total_modal = 0; $total_jual = 0;

	        while ($row = $query->fetch()) {

        	$subTotalModal = $row['harga_modal'] * $row['jumlah'];
            $total_modal = $total_modal + $subTotalModal;

        	$subTotalJual = $row['harga_jual'] * $row['jumlah'];
            $total_jual = $total_jual + $subTotalJual;

        	?>

	        	<tr>
	                <td><?php echo $no++ ?></td>
	                <td><?php echo $row['tgl_penjualan'] ?></td>
	                <td><?php echo $row['nama_obat'] ?></td>
	                <td><?php echo $fungsi->format_angka($row['harga_modal']) ?></td>
	                <td><?php echo $fungsi->format_angka($row['harga_jual']) ?></td>
	                <td><?php echo $row['jumlah'] ?></td>
	                <td>
	                	<a href="/apotek/nota-penjualan/<?php echo $row['no_penjualan'] ?>" target="_blank" class="btn btn-sm btn-info" title="Nota"><i class="fas fa-print"></i></a>
	                	<a href="/apotek/hapus-penjualan/<?php echo $row['no_penjualan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data penjualan ini ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
	                </td>
	            </tr>

	        <?php }} ?>
	        </tbody>
	    </table>
	</div>
	
	<br><h2>Total Modal : <?php echo "Rp."." ".$fungsi->format_angka($total_modal); ?></h2>
	<h2>Total Jual : <?php echo "Rp."." ".$fungsi->format_angka($total_jual); ?></h2>
</div>

<?php include("template/footer/footer_dashboard.php");  ?>

</body>
</html>