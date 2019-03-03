<?php

$title = "Data Petugas";
include("template/head/head_dashboard.php");
include("template/header/header.php");

if (isset($_COOKIE['tambah_datapetugas'])) {
	echo '<script>sweetAlert("", "Data petugas berhasil di tambahkan.", "success");</script>';
}

if (isset($_COOKIE['hapus_datapetugas'])) {
	echo '<script>sweetAlert("", "Data petugas berhasil di hapus.", "success");</script>';
}

?>

<div class="container" style="margin-top: 2%;">
	<a href="/apotek/tambah/data-petugas" class="btn btn-outline-primary btn-sm">Tambah Data</a><hr>
	<h3 align="center">Data Petugas</h3><hr>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered table-sm">
	        <thead>
	            <tr>
	                <th>Nama</th>
	                <th>No. Telepon</th>
	                <th>Username</th>
	                <th>Level</th>
	                <th>Opsi</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php

	        $query = $db->select("petugas");

	        while ($row = $query->fetch()) {

	        ?>
	            <tr>
	                <td><?php echo $row['nm_petugas'] ?></td>
	                <td><?php echo $row['no_telepon'] ?></td>
	                <td><?php echo $row['username'] ?></td>
	                <td><?php echo $row['level'] ?></td>
	                <td>
	                	<a href="/apotek/hapus-petugas/<?php echo $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
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