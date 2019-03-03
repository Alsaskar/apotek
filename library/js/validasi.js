// validasi form login
$("#form_login").validate({
	rules:{
		username: { required: true},
		password: { required: true}
	},

	messages:{
		username: { required: "masih kosong."},
		password: { required: "masih kosong." }
	}
});

// Validasi menambah data obat
$("#tambah_dataobat").validate({
	rules:{
		nama_obat: { required: true },
		harga_modal: { required: true},
		harga_jual: { required: true},
		stok: { required: true},
		expire: { required: true},
		no_faktur: { required: true},
		tgl_faktur: { required: true},
		jatuh_tempo: { required: true},
		suplier: { required: true},
		keterangan: { maxlength: 250}
	},

	messages:{
		nama_obat: { required: "tidak boleh kosong.", remote: "sudah digunakan."},
		harga_modal: { required: "tidak boleh kosong."},
		harga_jual: { required: "tidak boleh kosong."},
		stok: { required: "tidak boleh kosong."},
		expire: { required: "tidak boleh kosong."},
		no_faktur: { required: "tidak boleh kosong."},
		tgl_faktur: { required: "tidak boleh kosong."},
		jatuh_tempo: { required: "tidak boleh kosong."},
		suplier: { required: "tidak boleh kosong."},
		keterangan: { maxlength: "terlalu panjang."}
	}
});

// validasi form ganti password
$("#form_gantipassword").validate({
	rules:{
		pass_lama: { 
			required: true,
			remote: {
		 		url: "/apotek/cek/cek_password.php",
		 		type: "POST"
		 	}
		},
		pass_baru: { required: true, minlength: 8},
		repeat_pass_baru: { required: true, minlength: 8, equalTo: "#pass_baru"}
	},

	messages:{
		pass_lama: { required: "tidak boleh kosong.", remote: "tidak cocok."},
		pass_baru: { required: "tidak boleh kosong.", minlength: "terlalu pendek."},
		repeat_pass_baru: { required: "tidak boleh kosong.", minlength: "terlalu pendek.", equalTo: "tidak cocok dengan password baru"}
	}
});

// validasi form tambah data petugas
$("#form_addPetugas").validate({
	rules:{
		nama: { required: true },
		no_telepon: { required: true, digits: true, maxlength: 12 },
		username: { required: true },
		password: { required: true, minlength: 8 },
		status: { required: true }
	},

	messages:{
		nama: { required: "tidak boleh kosong." },
		no_telepon: { required: "tidak boleh kosong.", digits: "harus nomor.", maxlength: "terlalu panjang." },
		username: { required: "tidak boleh kosong." },
		password: { required: "tidak boleh kosong.", minlength: "terlalu pendek." },
		status: { required: "tidak boleh kosong." }
	}
});