-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2018 at 08:56 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `klinik_apotekdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE IF NOT EXISTS `obat` (
`id` int(11) NOT NULL,
  `kode_obat` varchar(20) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `harga_modal` int(10) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `stok` int(10) NOT NULL,
  `expire` date NOT NULL,
  `status_expire` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `no_faktur` char(11) NOT NULL,
  `tgl_faktur` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `suplier` varchar(50) NOT NULL,
  `no_batch` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kode_obat`, `nama_obat`, `harga_modal`, `harga_jual`, `stok`, `expire`, `status_expire`, `no_faktur`, `tgl_faktur`, `jatuh_tempo`, `suplier`, `no_batch`) VALUES
(11, 'KD00004', 'Amoxilin', 7000, 9000, 13, '2019-01-16', 'belum', '323232', '2018-06-21', '2018-07-28', 'PT. Merda Tomohon Sulut', '123123'),
(8, 'KD00001', 'Panadol', 2000, 3000, 2, '2018-07-22', 'belum', '23223', '2018-06-20', '2018-06-22', 'PT. Merda Tomohon Sulut', '14342'),
(9, 'KD00002', 'Parasetamol', 8000, 10000, 2, '2018-10-24', 'belum', '234234', '2018-06-29', '2018-06-20', 'PT. Merda Tomohon Sulut', '2334'),
(10, 'KD00003', 'Paroko', 5000, 8000, 0, '2018-09-26', 'belum', '20030330', '2018-06-29', '2018-06-30', 'PT. Merda Tomohon Sulut', '124234'),
(12, 'KD00005', 'Maag', 6000, 7000, 0, '2018-06-28', 'belum', '123213', '2018-06-25', '2018-06-26', 'PT. Merda Tomohon Sulut', '202022020');

-- --------------------------------------------------------

--
-- Table structure for table `obat_laku`
--

CREATE TABLE IF NOT EXISTS `obat_laku` (
`id` int(11) NOT NULL,
  `kd_obat` varchar(20) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `no_batch` varchar(20) NOT NULL,
  `stok_laku` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obat_laku`
--

INSERT INTO `obat_laku` (`id`, `kd_obat`, `nama_obat`, `no_batch`, `stok_laku`) VALUES
(3, 'KD00002', 'Parasetamol', '2334', 5),
(4, 'KD00003', 'Paroko', '124234', 2),
(5, 'KD00004', 'Amoxilin', '123123', 2),
(6, 'KD00001', 'Panadol', '14342', 2),
(7, 'KD00002', 'Parasetamol', '2334', 1),
(8, 'KD00003', 'Paroko', '124234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE IF NOT EXISTS `pasien` (
  `nomor_rm` char(6) NOT NULL,
  `nm_pasien` varchar(100) NOT NULL,
  `no_identitas` varchar(40) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `gol_darah` enum('A','B','AB','O') NOT NULL,
  `agama` varchar(30) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `stts_nikah` enum('Menikah','Belum Nikah') NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `keluarga_status` enum('Ayah','Ibu','Suami','Istri','Saudara') NOT NULL,
  `keluarga_nama` varchar(100) NOT NULL,
  `keluarga_telepon` varchar(20) NOT NULL,
  `tgl_rekam` date NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`nomor_rm`, `nm_pasien`, `no_identitas`, `jns_kelamin`, `gol_darah`, `agama`, `tempat_lahir`, `tanggal_lahir`, `no_telepon`, `alamat`, `stts_nikah`, `pekerjaan`, `keluarga_status`, `keluarga_nama`, `keluarga_telepon`, `tgl_rekam`, `kd_petugas`) VALUES
('RM0001', 'Rana Aipasa', '2001/0000001', 'Laki-laki', 'A', 'Islam', 'pasien di isi sesuai dengan data observasi', '2000-12-01', '081918181818', 'Jl. Yogyakarta, 130', 'Belum Nikah', 'Wiraswasta', 'Ayah', 'Aipasa', '080989999', '2013-12-01', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
`id` int(11) NOT NULL,
  `no_penjualan` char(15) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `pelanggan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `no_penjualan`, `tgl_penjualan`, `pelanggan`, `keterangan`, `uang_bayar`, `id_petugas`) VALUES
(49, 'JL00007', '2018-06-25', 'Pasien', '', 50000, 14),
(48, 'JL00006', '2018-06-25', 'Pasien', '', 66000, 14),
(47, 'JL00005', '2018-06-25', 'Pasien', '', 30000, 14),
(46, 'JL00004', '2018-06-21', 'Pasien', '', 55000, 17),
(45, 'JL00003', '2018-06-21', 'Pasien', '', 50000, 16),
(44, 'JL00002', '2018-06-18', 'Pasien', '', 3000, 14),
(43, 'JL00001', '2018-06-20', 'Pasien', '', 30000, 14);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE IF NOT EXISTS `penjualan_item` (
`id` int(11) NOT NULL,
  `no_penjualan` char(7) NOT NULL,
  `kd_obat` varchar(20) NOT NULL,
  `harga_modal` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_item`
--

INSERT INTO `penjualan_item` (`id`, `no_penjualan`, `kd_obat`, `harga_modal`, `harga_jual`, `jumlah`) VALUES
(90, 'JL00005', 'KD00005', 6000, 7000, 2),
(91, 'JL00006', 'KD00002', 8000, 10000, 5),
(89, 'JL00005', 'KD00003', 5000, 8000, 2),
(88, 'JL00004', 'KD00001', 2000, 3000, 2),
(87, 'JL00004', 'KD00004', 7000, 9000, 5),
(86, 'JL00003', 'KD00003', 5000, 8000, 5),
(82, 'JL00001', 'KD00001', 2000, 3000, 2),
(83, 'JL00001', 'KD00002', 8000, 10000, 2),
(84, 'JL00002', 'KD00001', 2000, 3000, 1),
(85, 'JL00003', 'KD00001', 2000, 3000, 1),
(92, 'JL00006', 'KD00003', 5000, 8000, 2),
(93, 'JL00007', 'KD00004', 7000, 9000, 2),
(94, 'JL00007', 'KD00001', 2000, 3000, 2),
(95, 'JL00007', 'KD00002', 8000, 10000, 1),
(96, 'JL00007', 'KD00003', 5000, 8000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
`id` int(11) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('Admin','Kasir') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nm_petugas`, `no_telepon`, `username`, `password`, `level`) VALUES
(14, 'Merdi Kansil', '080989999', 'admin', '$2y$10$pe.xV/0cLi23Ms4ppuEO2euv.getMFVANqlqiXf4EnCOAeokKsfz.', 'Admin'),
(16, 'Apotek PNiel Farma', '0892922929', 'kasir', '$2y$10$gxDNQQnzGtgFPD5zZqhOae2Aet2/mN83tDLCA8wa5dLvjlJx1986O', 'Kasir'),
(17, 'Anggun Poluan', '08114385465', 'Anggun', '$2y$10$33edfkNe/SPZQQoCr3eMc.1JEsOmmq.LUv7334L.2VZP9aeOh7g.y', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE IF NOT EXISTS `tmp_penjualan` (
`id` int(10) NOT NULL,
  `kd_obat` varchar(20) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat_laku`
--
ALTER TABLE `obat_laku`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
 ADD PRIMARY KEY (`nomor_rm`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
 ADD PRIMARY KEY (`id`), ADD KEY `nomor_penjualan_tamu` (`no_penjualan`,`kd_obat`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `obat_laku`
--
ALTER TABLE `obat_laku`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=140;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
