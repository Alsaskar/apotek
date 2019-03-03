<?php

$title = "Data Obat";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// Jika data obat berhasil di edit
if (isset($_COOKIE['edit_dataobat'])) {
	echo '<script>sweetAlert("", "Obat berhasil di edit.", "success");</script>';
}

// Jika data obat berhasil di hapus
if (isset($_COOKIE['hapus_dataobat'])) {
	echo '<script>sweetAlert("", "Obat berhasil di hapus.", "success");</script>';
}

?>

<div class="container" style="margin-top: 2%;">
	<a href="/apotek/data-obat" class="btn btn-danger btn-sm">Kembali</a><hr>
	<h2 class="text-center">Data Obat Expire</h2><hr>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered table-sm">
	        <thead>
	            <tr>
	                <th>No</th>
	                <th>Kode Obat</th>
	                <th>Nama Obat</th>
	                <th>Harga</th>
	                <th>Expire</th>
	                <th>Stok</th>
	                <th>Opsi</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php

	        $query = $connect->prepare("SELECT * FROM obat WHERE status_expire = :status_expire ORDER BY id DESC");
	        $query->execute(array(":status_expire" => 'sudah'));

	        $no = 1;

	        while ($row = $query->fetch()) {

	        ?>
	            <tr>
	                <td><?php echo $no++ ?></td>
	                <td><?php echo $row['kode_obat'] ?></td>
	                <td><?php echo $row['nama_obat'] ?></td>
	                <td><?php echo $fungsi->format_angka($row['harga_jual']) ?></td>
	                <td><?php echo $row['expire'] ?></td>
	                <td>
	                	<?php

	                	if ($row['stok'] > 0) {
	                		echo $row['stok'];
	                	}else{
	                		echo 'sudah habis.';
	                	}

	                	?>
	                </td>
	                <td>
	                	<a href="/apotek/edit/data-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
	                	<a href="/apotek/detail/data-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-default" title="Detail"><i class="far fa-caret-square-down"></i></a>
	                	<a href="/apotek/hapus-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
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