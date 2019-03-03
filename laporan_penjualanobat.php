<?php

$title = "Data Penjualan";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// Jika data penjualan berhasil di hapus
if (isset($_COOKIE['hapus_datapenjualan'])) {
	echo '<script>sweetAlert("", "Data penjualan berhasil di hapus.", "success");</script>';
}

?>

<div class="container" style="margin-top: 2%;">
	<h2 style="font-size: 30px"><b>LAPORAN PENJUALAN OBAT PER PERIODE</b></h2><hr>
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
					<input type="submit" name="proses" class="btn btn-outline-primary btn-sm" value="Tampilkan" />
				</div>
			</div>
			
		</div>
	</form><hr>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered table-sm">
	        <thead>
	            <tr>
	                <th>No</th>
	                <th>No. Nota</th>
	                <th>Tgl Nota</th>
	                <th>Pelanggan</th>
	                <th>Keterangan</th>
	                <th>Opsi</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php

	        if (isset($_GET['proses'])) {

	        $tglAwal = $_GET['txtTglAwal'];
	        $tglAkhir = $_GET['txtTglAkhir'];
	        	
	        $query = $connect->prepare("SELECT * FROM penjualan WHERE tgl_penjualan BETWEEN :tglAwal AND :tglAkhir AND id_petugas = :id_petugas");
	        $query->execute(array(":tglAwal" => $tglAwal, ":tglAkhir" => $tglAkhir, ":id_petugas" => $getuser['id']));

	        $no = 1;

	        while ($row = $query->fetch()) {

	        ?>
	            <tr>
	                <td><?php echo $no++ ?></td>
	                <td><?php echo $row['no_penjualan'] ?></td>
	                <td><?php echo $row['tgl_penjualan'] ?></td>
	                <td><?php echo $row['pelanggan'] ?></td>
	                <td>
	                	<?php

	                	if ($row['keterangan'] == "") {
	                		echo 'tidak ada keterangan.';
	                	}elseif($row['keterangan'] != ""){
	                		echo $row['keterangan'];
	                	}

	                	?>
	                		
	                </td>
	                <td>
	                	<a href="/apotek/nota-penjualan/<?php echo $row['no_penjualan'] ?>" target="_blank" class="btn btn-sm btn-info" title="Nota"><i class="fas fa-print"></i></a>
	                	<a href="/apotek/hapus-penjualan/<?php echo $row['no_penjualan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data penjualan ini ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
	                </td>
	            </tr>
	        <?php }}else{ ?>

	        <?php

	        $tglAwal = $_GET['txtTglAwal'];
	        $tglAkhir = $_GET['txtTglAkhir'];
	        	
	        $query = $connect->prepare("SELECT * FROM penjualan WHERE id_petugas = :id_petugas");
	        $query->execute(array(":id_petugas" => $getuser['id']));

	        $no = 1;

	        while ($row = $query->fetch()) {

	        ?>
	            <tr>
	                <td><?php echo $no++ ?></td>
	                <td><?php echo $row['no_penjualan'] ?></td>
	                <td><?php echo $row['tgl_penjualan'] ?></td>
	                <td><?php echo $row['pelanggan'] ?></td>
	                <td>
	                	<?php

	                	if ($row['keterangan'] == "") {
	                		echo 'tidak ada keterangan.';
	                	}elseif($row['keterangan'] != ""){
	                		echo $row['keterangan'];
	                	}

	                	?>
	                		
	                </td>
	                <td>
	                	<a href="/apotek/nota-penjualan/<?php echo $row['no_penjualan'] ?>" target="_blank" class="btn btn-sm btn-info" title="Nota"><i class="fas fa-print"></i></a>
	                	<a href="/apotek/hapus-penjualan/<?php echo $row['no_penjualan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data penjualan ini ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
	                </td>
	            </tr>

	        <?php }} ?>
	        </tbody>
	    </table>
	</div>
	
</div>

<?php include("template/footer/footer_dashboard.php");  ?>

</body>
</html>