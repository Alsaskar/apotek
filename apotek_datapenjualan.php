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
	<h2 class="text-center">Data Penjualan</h2><hr>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered table-sm">
	        <thead>
	            <tr>
	                <th>No</th>
	                <th>No. Nota</th>
	                <th>Tgl Nota</th>
	                <th>Pelanggan</th>
	                <th>Keterangan</th>
	                <th>Petugas</th>
	                <th>Opsi</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php

	        $query = $connect->prepare("SELECT penjualan.*, petugas.nm_petugas FROM penjualan LEFT JOIN petugas ON penjualan.id_petugas = petugas.id ORDER BY penjualan.no_penjualan DESC");
	        $query->execute();

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
	                <td><?php echo $row['nm_petugas'] ?></td>
	                <td>
	                	<a href="/apotek/nota-penjualan/<?php echo $row['no_penjualan'] ?>" target="_blank" class="btn btn-sm btn-info" title="Nota"><i class="fas fa-print"></i></a>
	                	<a href="/apotek/hapus-penjualan/<?php echo $row['no_penjualan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data penjualan ini ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
	                </td>
	            </tr>
	        <?php } ?>
	        </tbody>
	    </table>
	</div>
	
</div>

<?php include("template/footer/footer_dashboard.php");  ?>

</body>
</html>