<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark danger-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="/apotek/dashboard">Apotek Pniel Farma</a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

        <!-- Links -->
        <ul class="navbar-nav mr-auto">

        <?php if($getuser['level'] == "Admin"){ ?>
            <li class="nav-item"><a class="nav-link" href="/apotek/data-petugas">Data Petugas</a></li>
            <li class="nav-item"><a class="nav-link" href="/apotek/data-obat">Data Obat</a></li>
            <li class="nav-item"><a class="nav-link" href="/apotek/data-penjualan">Data Penjualan</a></li>
            <li class="nav-item"><a class="nav-link" href="/apotek/penjualan/obat">Penjualan Apotek</a></li>

            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Laporan</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">

                    <a class="dropdown-item" href="/apotek/laporan/data-petugas" target="_blank">Data Petugas</a>
                    <a class="dropdown-item" href="/apotek/laporan/data-obat" target="_blank">Data Obat</a>
                    <a class="dropdown-item" href="/apotek/laporan/stok-obat/terjual" target="_blank">Stok Obat Terjual</a>
                    <a class="dropdown-item" href="/apotek/laporan/penjualan-obat">Penjualan Obat</a>
                    <a class="dropdown-item" href="/apotek/laporan/keuangan">Keuangan</a>
                </div>
            </li>
        <?php }elseif($getuser['level'] == "Kasir"){ ?>
            <li class="nav-item"><a class="nav-link" href="/apotek/penjualan/obat">Penjualan Apotek</a></li>
            <li class="nav-item"><a class="nav-link" href="/apotek/data-obat">Data Obat</a></li>
        <?php } ?>

        </ul>
        <!-- Links -->

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    <i class="fa fa-user"></i> <?php echo $getuser['nm_petugas'] ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item dropdown-profil" href="/apotek/ganti-password">Ganti Password</a>
                    <a class="dropdown-item dropdown-profil" href="/apotek/logout.php">Keluar</a>
                </div>
            </li>
        </ul>
    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->

<?php

// kode untuk mengedit expire obat
// bahwa obat tersebut sudah expire
$query_expire_obat = $db->select('obat');

while ($row_expire_obat = $query_expire_obat->fetch()) {
    if (date('Y-m-d') >= $row_expire_obat['expire'] ) {
        $db->update("obat", array("status_expire"), array('sudah'), array("kode_obat", $row_expire_obat['kode_obat']));
    }else{
        $db->update("obat", array("status_expire"), array('belum'), array("kode_obat", $row_expire_obat['kode_obat']));
    }
}

?>