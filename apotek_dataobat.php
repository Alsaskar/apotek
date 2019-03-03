<?php

$title = "Data Obat";
include("template/head/head_dashboard.php");
include("template/header/header.php");

// jika data obat berhasil di tambahkan
if (isset($_COOKIE['tambah_dataobat'])) {
	echo '<script>sweetAlert("", "Obat berhasil di tambahkan.", "success");</script>';
}

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
	<a href="/apotek/tambah/data-obat" class="btn btn-outline-primary btn-sm">Tambah Data</a>
	<a href="/apotek/data-obat/expire" class="btn btn-outline-elegant btn-sm">Data obat expire</a><hr>
	<h2 class="text-center">Data Obat</h2><hr>
	<div class="table-responsive">
		<table id="example" class="table table-striped table-bordered table-sm">
	        <thead>
	            <tr>
	                <th>No</th>
	                <th>Kode Obat</th>
	                <th>No Batch</th>
	                <th>Nama Obat</th>
	                <th>Stok</th>
	                <th>Kadaluarsa</th>
	                <th>Suplier</th>
	                <th>Opsi</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php

	        $query = $connect->prepare("SELECT * FROM obat ORDER BY id DESC");
	        $query->execute();

	        $no = 1;

	        while ($row = $query->fetch()) {

	        	$awal  = date_create($row['expire']);
				$akhir = date_create(); // waktu sekarang
				$diff  = date_diff($awal, $akhir);

	        ?>
	            <tr>
	                <td>
	                	<?php

	                	if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                		echo '<font color="red">'.$no++.'</font>';
	                	}else{
	                		echo $no++;
	                	}

	                	?>
	                </td>
	                <td>

	                	<?php

	                	if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                		echo '<font color="red">'.$row['kode_obat'].'</font>';
	                	}else{
	                		echo $row['kode_obat'];
	                	}

	                	?>
	                		
	                </td>
	                <td>

	                	<?php

	                	if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                		echo '<font color="red">'.$row['no_batch'].'</font>';
	                	}else{
	                		echo $row['no_batch'];
	                	}

	                	?>
	                		
	                </td>
	                <td>
	                	<?php

	                	if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                		echo '<font color="red">'.$row['nama_obat'].'</font>';
	                	}else{
	                		echo $row['nama_obat'];
	                	}

	                	?>
	                </td>
	                <td>
	                	<?php

	                	if ($row['stok'] > 0) {
	                		if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                			echo '<font color="red">'.$row['stok'].'</font>';
		                	}else{
		                		echo $row['stok'];
		                	}
	                	}else{
	                		if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                			echo '<font color="red">sudah habis.</font>';
		                	}else{
		                		echo 'sudah habis.';
		                	}
	                	}

	                	?>
	                </td>
	                <td>
	                	<?php

	                	if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                		if ($row['status_expire'] == "sudah") {
	                			echo '<font color="red">Expire.</font>';
		                	}elseif ($row['status_expire'] == "belum") {
								echo '<font color="red">'.$fungsi->selisiWaktu($diff).' lagi akan Expire.</font>';
		                	}
	                	}else{
	                		if ($row['status_expire'] == "sudah") {
		                		echo '<font color="red">Expire.</font>';
		                	}elseif ($row['status_expire'] == "belum") {
								echo $fungsi->selisiWaktu($diff).' lagi akan Expire.';
		                	}
	                	}

	                	?>
	                </td>
	                <td>
	                	<?php

	                	if ($fungsi->selisiWaktu($diff) == '1 bulan') {
	                		echo '<font color="red">'.$row['suplier'].'</font>';
	                	}else{
	                		echo $row['suplier'];
	                	}

	                	?>
	                </td>
	                <td>
	                <?php if($getuser['level'] == 'Admin'){ ?>
	                	<a href="/apotek/edit/data-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
	                	<a href="/apotek/detail/data-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-default" title="Detail"><i class="far fa-caret-square-down"></i></a>
	                	<a href="/apotek/hapus-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus ?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
	                <?php }elseif($getuser['level'] == "Kasir"){ ?>
	                	<a href="/apotek/detail/data-obat/<?php echo $row['id'] ?>" class="btn btn-sm btn-default" title="Detail"><i class="far fa-caret-square-down"></i></a>
	                <?php } ?>
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