<?php

$title = "Transaksi Penjualan Obat";
include("template/head/head_dashboard.php");
include("template/header/header.php");

if (isset($_COOKIE['hapus_tmp'])) { // jika data yang di tabel tmp_penjualan berhasil di hapus
	echo '<script>sweetAlert("", "Berhasil di batalkan.", "success");</script>';
}

if (isset($_COOKIE['simpan_transaksi'])) { // jika transaksi berhasil disimpan
	echo '<script>sweetAlert("", "Berhasil melakukan transaksi. Uang Kembalian : '.$fungsi->format_angka($_COOKIE['simpan_totalkembalian']).'.", "success");</script>';
}

if (isset($_GET['id'])) { // jika ingin menghapus data pada daftar obat

	// tampilkan data dari tabel tmp_penjualan
	$query = $db->select('tmp_penjualan', 'id', $_GET['id']);
	$row   = $query->fetch();

	// tampilkan data dari tabel obat
	$query2 = $db->select('obat', 'kode_obat', $row['kd_obat']);
	$row2   = $query2->fetch();

	// kembalikana stok obat
	$kembalikanStok = $row['jumlah'] + $row2['stok'];

	// update stok pada tiap obat, jika data sudah di hapus pada daftar obat
	$db->update("obat", array("stok"), array($kembalikanStok), array("kode_obat", $row['kd_obat']));

	$db->delete("tmp_penjualan", "id", $_GET['id']);
	header("Location: /apotek/penjualan/obat");
	setcookie('hapus_tmp', 'berhasil', time() + 4, '/');

}

if (isset($_POST['tambahData'])) { // jika tombol tambah obat di klik

	if($_POST['namaObat'] == ""){
		echo '<script>sweetAlert("", "Obat belum di pilih.", "error");</script>';
	}elseif ($_POST['jumlah'] == "") {
		echo '<script>sweetAlert("", "Jumlah belum di isi.", "error");</script>';
	}else{

		$get_obat = $db->select("obat", "kode_obat", $_POST['namaObat']);
		$row_obat = $get_obat->fetch();

		$get_tmp = $db->select("tmp_penjualan", "kd_obat", $_POST['namaObat']);
		$row_tmp = $get_tmp->fetch();

		if ($_POST['jumlah'] > $row_obat['stok']) { // jika jumlah melebihi dari stok obat, maka
			// muncul pesan peringatan
			echo '<script>sweetAlert("", "Jumlah yang dimasukan melebihi dari stok obat.", "error");</script>';
		}else{

			if ($_POST['namaObat'] == $row_tmp['kd_obat']) { // jika kode obat yang di pilih sama dengan kode obat yang ada di tabel tmp_penjualan, maka

				// menghitung jumlah yang di input dengan jumlah yang ada di database berdasarkan kode obat
				$jumlah_all = $_POST['jumlah'] + $row_tmp['jumlah'];
				
				// update jumlah berdasarkan kode obat
				$db->update("tmp_penjualan", array("jumlah"), array($jumlah_all), array("kd_obat", $row_obat['kode_obat']));

			}elseif($_POST['namaObat'] != $row_tmp['kd_obat']){ // jika kode obat yang di pilih tidak sama dengan kode obat yang ada di tabel tmp_penjualan, maka

				// data akan di input ke tabel tmp_penjualan
				$value = array("kd_obat" => $row_obat['kode_obat'], "jumlah" => $_POST['jumlah'], "kd_petugas" => $getuser['id']);
				$db->insert("tmp_penjualan", $value);
			}
			

			$kurangiStok = $row_obat['stok'] - $_POST['jumlah'];

			$db->update("obat", array("stok"), array($kurangiStok), array("kode_obat", $row_obat['kode_obat']));

			header("Location: /apotek/penjualan/obat#daftar_obat");
		}
	}
}

if (isset($_POST['simpanTransaksi'])) { // jika tombol simpan transaksi di klik

	if ($_POST['tgl_penjualan'] == "") { // jika tanggal transaksi masih kosong
		echo '<script>sweetAlert("", "Tanggal transaksi masih kosong.", "error");</script>';
	}elseif ($_POST['uang_bayar'] == "") { // jika uang bayar masih kosong
		echo '<script>sweetAlert("", "Uang bayar masih kosong.", "error");</script>';
	}elseif ($_POST['uang_bayar'] < $_POST['total_bayar']) { // jika uang bayar lebih kecil dari total bayar
		echo '<script>sweetAlert("", "Uang bayar belum cukup. Total belanja '.$fungsi->format_angka($_POST['total_bayar']).' ", "error");</script>';
	}else{

		// mengambil data dari tabel tmp_penjualan
		$query = $db->select('tmp_penjualan', 'kd_petugas', $getuser['id']);

		if ($query->rowCount() > 0) { // jika data yang di tabel tmp_penjualan ada, maka

			// data akan di masukan ke tabel penjualan
			$no_penjualan = $_POST['no_penjualan'];
			$tgl_penjualan = $_POST['tgl_penjualan'];
			$pelanggan = $_POST['pelanggan'];
			$keterangan = $_POST['keterangan'];
			$uang_bayar = $_POST['uang_bayar'];

			$totalKembalian = $uang_bayar - $_POST['total_bayar'];

			$value = array("no_penjualan" => $no_penjualan, "tgl_penjualan" => $tgl_penjualan, "pelanggan" => $pelanggan, "keterangan" => $keterangan, "uang_bayar" => $uang_bayar, "id_petugas" => $getuser['id']);
			$db->insert("penjualan", $value);

			$get_dataobat = $connect->prepare("SELECT obat.*, tmp.jumlah FROM obat, tmp_penjualan AS tmp WHERE obat.kode_obat = tmp.kd_obat AND tmp.kd_petugas= :kd_petugas");
			$get_dataobat->execute(array(":kd_petugas" => $getuser['id']));

			while ($row_dataobat = $get_dataobat->fetch()) {
				// Baca data dari tabel obat dan jumlah yang dibeli dari TMP
				$dataKode 	= $row_dataobat['kode_obat'];
				$dataHargaM	= $row_dataobat['harga_modal']; // harga modal
				$dataHargaJ	= $row_dataobat['harga_jual']; // harga jual
				$dataJumlah	= $row_dataobat['jumlah'];

				// memindah data, masukkan semua data di atas dari tabel TMP ke tabel ITEM
				$value2 = array("no_penjualan" => $no_penjualan, "kd_obat" => $dataKode, "harga_modal" => $dataHargaM, "harga_jual" => $dataHargaJ, "jumlah" => $dataJumlah);
				$db->insert("penjualan_item", $value2);

				// memasukan data pada tabel obat_laku (guna untuk mengetahui jumlah stok obat berapa yang laku)
				$value3 = array("kd_obat" => $row_dataobat['kode_obat'], "nama_obat" => $row_dataobat['nama_obat'], "no_batch" => $row_dataobat['no_batch'], "stok_laku" => $dataJumlah);
				$db->insert("obat_laku", $value3);

			}

			$db->delete("tmp_penjualan", "kd_petugas", $getuser['id']);

			header("Location: /apotek/penjualan/obat");
			setcookie('simpan_transaksi', 'berhasil', time() + 4, '/');
			setcookie('simpan_totalkembalian', $totalKembalian, time() + 4, '/');

		}else{
			echo '<script>sweetAlert("", "Belum ada obat yang dimasukan. Minimal 1 obat.", "error");</script>';
		}
	}
	
}

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<div class="container" style="margin-top: 2%;">

	<div id="data_penjualan">
		<h4>DATA PENJUALAN</h4>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="no_penjualan">Nomor Penjualan</label>
						<input type="text" name="no_penjualan" class="input" id="no_penjualan" placeholder="Nomor Penjualan" value="<?php echo $db->kode_otomatis('penjualan', 'no_penjualan', 'JL') ?>" readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="tgl_penjualan">Tanggal Penjualan</label>
						<input type="date" name="tgl_penjualan" class="input" id="tgl_penjualan" value="<?php echo date('Y-m-d') ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="pelanggan">Pelanggan</label>
						<input type="text" name="pelanggan" class="input" id="pelanggan" value="Pasien" readonly="readonly">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="keterangan">Keterangan</label>
				<textarea class="input-textarea" name="keterangan" id="keterangan" placeholder="Keterangan" style="height: 50px;"></textarea>
			</div>

		<h4>INPUT OBAT</h4>

		<div class="row">
			<div class="col-md-9">
				<div class="form-group">
					<label for="select-cariobat">Cari Obat</label>
					<select id="select-cariobat" name="namaObat" class="select-input" style="width: 100%">
						<option value="" readonly="readonly">Cari disini...</option>
						<?php

						$get_namaobat = $db->select("obat");

						while ($row_namaobat = $get_namaobat->fetch()) {

							if ($row_namaobat['stok'] > 0) { // jika masing-masing stok obat masih ada

								if ($row_namaobat['status_expire'] == "sudah") {
									echo '<option value="'.$row_namaobat['kode_obat'].'" disabled>'.$row_namaobat['nama_obat'].' | Kadaluarsa.</option>';
								}else{
									echo '<option value="'.$row_namaobat['kode_obat'].'">'.$row_namaobat['nama_obat'].' | sisa '.$row_namaobat['stok'].' stok</option>';
								}
								
							}else{ // jika masing-masing stok obat sudah habis
								echo '<option value="'.$row_namaobat['kode_obat'].'" disabled>'.$row_namaobat['nama_obat'].' | stok telah habis.</option>';
							}
							
						}

						?>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="jumlah">Jumlah</label>
					<input type="text" name="jumlah" id="jumlah" class="input" placeholder="Jumlah">
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-md" name="tambahData">Tambah</button>
		</div>

		<h4>DAFTAR OBAT</h4>

		<div class="card" id="daftar_obat">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead>
							<tr>
								<td bgcolor="#CCCCCC">No</td>
								<td bgcolor="#CCCCCC">Nama Obat</td>
								<td bgcolor="#CCCCCC">Harga</td>
								<td align="right" bgcolor="#CCCCCC">Jumlah</td>
								<td align="right" bgcolor="#CCCCCC">Sub Total</td>
							</tr>
						</thead>
						<tbody>
							<?php

							$query_obat = $connect->prepare("SELECT obat.*, tmp_penjualan.* FROM obat, tmp_penjualan WHERE obat.kode_obat = tmp_penjualan.kd_obat AND tmp_penjualan.kd_petugas = :kd_petugas ORDER BY tmp_penjualan.id DESC");

							$query_obat->execute(array(":kd_petugas" => $getuser['id']));
							$no = 1;
							$nomor = 0; $hargaDiskon = 0; $totalBayar = 0;  $jumlahobat = 0;

							while ($row_dataobat = $query_obat->fetch()) {

								$subSotal = $row_dataobat['jumlah'] * $row_dataobat['harga_jual'];
								$jumlahobat	= $jumlahobat + $row_dataobat['jumlah'];
								$totalBayar	= $totalBayar + $subSotal;

							?>
							<tr style="background-color: white;">
								<td><?php echo $no++; ?></td>
								<td><?php echo $row_dataobat['nama_obat'] ?></td>
								<td><?php echo $fungsi->format_angka($row_dataobat['harga_jual']) ?></td>
								<td align="right"><?php echo $row_dataobat['jumlah'] ?></td>
								<td align="right"><?php echo $fungsi->format_angka($subSotal) ?></td>
								<td><a href="?id=<?php echo $row_dataobat['id'] ?>" style="color: blue;" onclick='return confirm("Yakin ingin batal ?")'>Batal</a></td>
							</tr>
							<?php } ?>

							<tr>
						      <td colspan="3" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
						      <td align="right" bgcolor="#F5F5F5"><strong><?php echo $jumlahobat; ?></strong></td>
						      <td align="right" bgcolor="#F5F5F5"><strong><?php echo $fungsi->format_angka($totalBayar); ?></strong></td>
						      <td bgcolor="#F5F5F5">&nbsp;</td>
						    </tr>
						    <tr>
						      <td colspan="3" align="right" bgcolor="#F5F5F5"><strong>Uang Bayar :</strong></td>
						      <td bgcolor="#F5F5F5"><input type="hidden" name="total_bayar" value="<?php echo $totalBayar; ?>"></td>
						      <td bgcolor="#F5F5F5" align="right"><input type="text" name="uang_bayar"></td>
						      <td bgcolor="#F5F5F5">&nbsp;</td>
						    </tr>
						</tbody>
					</table>
					<button type="submit" name="simpanTransaksi" class="btn btn-sm btn-primary">Simpan Transaksi</button>
				</div>
			</div>
		</div><br>
	</div>
</div>
</form>

<?php include("template/footer/footer_dashboard.php"); ?>
<script src="/apotek/library/js/search.js"></script>

</body>
</html>