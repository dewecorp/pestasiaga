-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2020 at 01:49 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pestasiaga`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_juara`
--

CREATE TABLE `tb_juara` (
  `id_juara` int(11) NOT NULL,
  `id_pa` int(11) NOT NULL,
  `id_pi` int(11) NOT NULL,
  `id_rekap` int(11) NOT NULL,
  `id_rekap_pi` int(11) NOT NULL,
  `total_nilai` varchar(30) NOT NULL,
  `juara` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_juara`
--

INSERT INTO `tb_juara` (`id_juara`, `id_pa`, `id_pi`, `id_rekap`, `id_rekap_pi`, `total_nilai`, `juara`) VALUES
(1, 1, 4, 1, 1, '', ''),
(2, 2, 2, 2, 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_juri`
--

CREATE TABLE `tb_juri` (
  `id_juri` int(11) NOT NULL,
  `nama_juri` varchar(200) NOT NULL,
  `pangkalan` varchar(200) NOT NULL,
  `id_taman` int(11) NOT NULL,
  `no_hp` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_juri`
--

INSERT INTO `tb_juri` (`id_juri`, `nama_juri`, `pangkalan`, `id_taman`, `no_hp`) VALUES
(9, 'AGUS', 'MI AL HUDA', 13, '082331'),
(11, 'ALIF ROHMAN SAPUTRA', 'MI SULTAN FATTAH SUKOSONO', 13, '082331838221'),
(12, 'DEWI ANISAH', 'SDN 1 SURODADI', 16, '08344444'),
(13, 'ALIF ROHMAN SAPUTRA', 'MI SAFINATUL HUDA SOWAN KIDUL', 19, '08977777'),
(14, 'MUHAMMAD NURROIN, S.H.I', 'MI SALAFIYAH WANUSOBO', 23, '08344444'),
(16, 'ALIF ROHMAN SAPUTRA', 'SDN 1 KERSO', 22, '082331838221'),
(17, 'JONO', 'SDN  1 BUGEL', 13, '082331838221'),
(18, 'PAIJO', 'SDN 1 KERSO', 14, '08344444');

-- --------------------------------------------------------

--
-- Table structure for table `tb_panitia`
--

CREATE TABLE `tb_panitia` (
  `id_panitia` int(11) NOT NULL,
  `ketua_panitia` varchar(100) NOT NULL,
  `ketua_juri` varchar(100) NOT NULL,
  `ka_kwarran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_panitia`
--

INSERT INTO `tb_panitia` (`id_panitia`, `ketua_panitia`, `ketua_juri`, `ka_kwarran`) VALUES
(1, 'NUR HUDA', 'SYAIFULLAH', 'HARTONO, S.Pd.'),
(2, 'AMIN', 'MASYURI', 'EKO');

-- --------------------------------------------------------

--
-- Table structure for table `tb_peserta_pa`
--

CREATE TABLE `tb_peserta_pa` (
  `id_pa` int(11) NOT NULL,
  `no_dada` varchar(50) NOT NULL,
  `pangkalan` varchar(100) NOT NULL,
  `pembina` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_peserta_pa`
--

INSERT INTO `tb_peserta_pa` (`id_pa`, `no_dada`, `pangkalan`, `pembina`) VALUES
(1, '001', 'MI SULTAN FATTAH SUKOSONO', 'KHOIRUDDIN'),
(2, '003', 'SDN 1 SURODADI', 'JAMAL'),
(3, '005', 'MI SAFINATUL HUDA SOWAN KIDUL', 'JOKO'),
(4, '007', 'SDN 2 BUGEL', 'PAIJO'),
(5, '009', 'SDN1 SUKOSONO', 'JONO'),
(6, '011', 'MI AL HUDA JONDANG', 'SITI'),
(7, '013', 'SDN 5 SUKOSONO', 'YANTO'),
(8, '015', 'MI MATHOLIUL HUDA BUGEL', 'ULIN'),
(9, '017', 'MI SHOWA MARWA SOWAN LOR', 'FATIMAH'),
(10, '021', 'MI TAMRINUTH THULLAB', 'SUTRISNO'),
(11, '019', 'SDN 2 SUKOSONO', 'JUMADI'),
(12, '023', 'SDN 1 BUGEL', 'SUDARMI');

-- --------------------------------------------------------

--
-- Table structure for table `tb_peserta_pi`
--

CREATE TABLE `tb_peserta_pi` (
  `id_pi` int(11) NOT NULL,
  `no_dada` varchar(50) NOT NULL,
  `pangkalan` varchar(100) NOT NULL,
  `pembina` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_peserta_pi`
--

INSERT INTO `tb_peserta_pi` (`id_pi`, `no_dada`, `pangkalan`, `pembina`) VALUES
(2, '004', 'SDN 1 KERSO', ''),
(3, '006', 'MI SAFINATUL HUDA SOWAN KIDUL', ''),
(4, '002', 'MI SULTAN FATTAH SUKOSONO', 'SUDARMI'),
(5, '008', 'MI SALAFIYAH WANUSOBO', 'JOKO'),
(6, '010', 'SDN 1 SURODADI', 'PAIJO'),
(7, '012', 'MI AL HUDA JONDANG', 'JAMAL'),
(8, '014', 'SDN 2 BUGEL', 'JONO'),
(9, '016', 'MI KI AJI TUNGGAL KARANGAJI', 'SANTOSO');

-- --------------------------------------------------------

--
-- Table structure for table `tb_prestasi_pa`
--

CREATE TABLE `tb_prestasi_pa` (
  `id_prestasi_pa` int(11) NOT NULL,
  `id_pa` int(11) NOT NULL,
  `id_rekap` int(11) NOT NULL,
  `predikat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_prestasi_pa`
--

INSERT INTO `tb_prestasi_pa` (`id_prestasi_pa`, `id_pa`, `id_rekap`, `predikat`) VALUES
(1, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_prestasi_pi`
--

CREATE TABLE `tb_prestasi_pi` (
  `id_prestasi_pi` int(11) NOT NULL,
  `id_pi` int(11) NOT NULL,
  `id_rekap_pi` int(11) NOT NULL,
  `predikat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_prestasi_pi`
--

INSERT INTO `tb_prestasi_pi` (`id_prestasi_pi`, `id_pi`, `id_rekap_pi`, `predikat`) VALUES
(1, 2, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekap`
--

CREATE TABLE `tb_rekap` (
  `id_rekap` int(11) NOT NULL,
  `id_pa` int(50) NOT NULL,
  `ketakwaan` varchar(30) NOT NULL,
  `toleransi` varchar(30) NOT NULL,
  `tanda_pengenal` varchar(30) NOT NULL,
  `rangking` varchar(30) NOT NULL,
  `kim` varchar(30) NOT NULL,
  `scout_skill` varchar(30) NOT NULL,
  `lbb` varchar(30) NOT NULL,
  `kereta_bola` varchar(30) NOT NULL,
  `seni_budaya` varchar(30) NOT NULL,
  `bumbung` varchar(30) NOT NULL,
  `nilai_akhir_pa` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rekap`
--

INSERT INTO `tb_rekap` (`id_rekap`, `id_pa`, `ketakwaan`, `toleransi`, `tanda_pengenal`, `rangking`, `kim`, `scout_skill`, `lbb`, `kereta_bola`, `seni_budaya`, `bumbung`, `nilai_akhir_pa`) VALUES
(1, 1, '100', '90', '78', '77', '67', '78', '77', '90', '89', '100', '376'),
(2, 2, '100', '90', '78', '67', '78', '70', '86', '50', '76', '100', '275'),
(3, 3, '', '', '', '', '', '', '', '', '', '', ''),
(4, 4, '', '', '', '', '', '', '', '', '', '', ''),
(5, 5, '', '', '', '', '', '', '', '', '', '', ''),
(6, 6, '', '', '', '', '', '', '', '', '', '', ''),
(7, 7, '', '', '', '', '', '', '', '', '', '', ''),
(8, 8, '', '', '', '', '', '', '', '', '', '', ''),
(9, 9, '', '', '', '', '', '', '', '', '', '', ''),
(11, 11, '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekap_pi`
--

CREATE TABLE `tb_rekap_pi` (
  `id_rekap_pi` int(11) NOT NULL,
  `id_pi` int(11) NOT NULL,
  `ketakwaan` varchar(30) NOT NULL,
  `toleransi` varchar(30) NOT NULL,
  `tanda_pengenal` varchar(30) NOT NULL,
  `rangking` varchar(30) NOT NULL,
  `kim` varchar(30) NOT NULL,
  `scout_skill` varchar(30) NOT NULL,
  `lbb` varchar(30) NOT NULL,
  `kereta_bola` varchar(30) NOT NULL,
  `seni_budaya` varchar(30) NOT NULL,
  `bumbung` varchar(30) NOT NULL,
  `nilai_akhir_pi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rekap_pi`
--

INSERT INTO `tb_rekap_pi` (`id_rekap_pi`, `id_pi`, `ketakwaan`, `toleransi`, `tanda_pengenal`, `rangking`, `kim`, `scout_skill`, `lbb`, `kereta_bola`, `seni_budaya`, `bumbung`, `nilai_akhir_pi`) VALUES
(1, 2, '100', '90', '78', '77', '67', '70', '77', '90', '89', '100', '876'),
(2, 3, '98', '78', '67', '77', '67', '78', '77', '90', '89', '100', '897'),
(3, 4, '98', '90', '78', '77', '67', '78', '77', '90', '89', '100', '679');

-- --------------------------------------------------------

--
-- Table structure for table `tb_taman`
--

CREATE TABLE `tb_taman` (
  `id_taman` int(11) NOT NULL,
  `nama_taman` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_taman`
--

INSERT INTO `tb_taman` (`id_taman`, `nama_taman`) VALUES
(13, 'SENI BUDAYA PUTRA'),
(14, 'PATRIOTISME PUTRA'),
(16, 'LBB PUTRA'),
(17, 'BUMBUNG PEDULI PUTRA'),
(18, 'TOLERANSI PUTRA'),
(19, 'RANKING 1 PUTRA'),
(20, 'SCOUTING SKILLS PUTRA'),
(21, 'KERAPIAN PUTRA'),
(22, 'KERETA BOLA PUTRA'),
(23, 'KETAKWAAN PUTRA'),
(24, 'SENI BUDAYA PUTRI'),
(25, 'PATRIOTISME PUTRI'),
(26, 'LBB PUTRI'),
(27, 'BUMBUNG PEDULI PUTRI'),
(28, 'TOLERANSI PUTRI'),
(29, 'RANGKING 1 PUTRI'),
(30, 'SCOUTING SKILLS PUTRI'),
(31, 'KERAPIAN PUTRI'),
(32, 'KETAKWAAN PUTRI'),
(33, 'KERETA BOLA PUTRI');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `nama`, `level`) VALUES
(1, 'admin', 'admin', 'NUR HUDA', 'admin'),
(2, 'admin2', 'admin2', 'AMIN SOFYAN', 'admin'),
(3, 'user1', 'user1', 'MI SULTAN FATTAH SUKOSONO', 'user'),
(4, 'user2', 'user2', 'MI AL HUDA JONDANG', 'user'),
(5, 'user2', 'user2', 'MI AL HUDA JONDANG', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_juara`
--
ALTER TABLE `tb_juara`
  ADD PRIMARY KEY (`id_juara`),
  ADD KEY `id_pa` (`id_pa`),
  ADD KEY `id_pi` (`id_pi`),
  ADD KEY `id_rekap` (`id_rekap`),
  ADD KEY `id_rekap_pi` (`id_rekap_pi`);

--
-- Indexes for table `tb_juri`
--
ALTER TABLE `tb_juri`
  ADD PRIMARY KEY (`id_juri`),
  ADD KEY `id_taman` (`id_taman`);

--
-- Indexes for table `tb_panitia`
--
ALTER TABLE `tb_panitia`
  ADD PRIMARY KEY (`id_panitia`);

--
-- Indexes for table `tb_peserta_pa`
--
ALTER TABLE `tb_peserta_pa`
  ADD PRIMARY KEY (`id_pa`);

--
-- Indexes for table `tb_peserta_pi`
--
ALTER TABLE `tb_peserta_pi`
  ADD PRIMARY KEY (`id_pi`);

--
-- Indexes for table `tb_prestasi_pa`
--
ALTER TABLE `tb_prestasi_pa`
  ADD PRIMARY KEY (`id_prestasi_pa`),
  ADD KEY `id_pa` (`id_pa`),
  ADD KEY `id_rekap` (`id_rekap`);

--
-- Indexes for table `tb_prestasi_pi`
--
ALTER TABLE `tb_prestasi_pi`
  ADD PRIMARY KEY (`id_prestasi_pi`),
  ADD KEY `id_pi` (`id_pi`),
  ADD KEY `id_rekap_pi` (`id_rekap_pi`);

--
-- Indexes for table `tb_rekap`
--
ALTER TABLE `tb_rekap`
  ADD PRIMARY KEY (`id_rekap`),
  ADD KEY `id_pa` (`id_pa`);

--
-- Indexes for table `tb_rekap_pi`
--
ALTER TABLE `tb_rekap_pi`
  ADD PRIMARY KEY (`id_rekap_pi`),
  ADD KEY `id_pi` (`id_pi`);

--
-- Indexes for table `tb_taman`
--
ALTER TABLE `tb_taman`
  ADD PRIMARY KEY (`id_taman`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_juara`
--
ALTER TABLE `tb_juara`
  MODIFY `id_juara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_juri`
--
ALTER TABLE `tb_juri`
  MODIFY `id_juri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_panitia`
--
ALTER TABLE `tb_panitia`
  MODIFY `id_panitia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_peserta_pa`
--
ALTER TABLE `tb_peserta_pa`
  MODIFY `id_pa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_peserta_pi`
--
ALTER TABLE `tb_peserta_pi`
  MODIFY `id_pi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_prestasi_pa`
--
ALTER TABLE `tb_prestasi_pa`
  MODIFY `id_prestasi_pa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_prestasi_pi`
--
ALTER TABLE `tb_prestasi_pi`
  MODIFY `id_prestasi_pi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_rekap`
--
ALTER TABLE `tb_rekap`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_rekap_pi`
--
ALTER TABLE `tb_rekap_pi`
  MODIFY `id_rekap_pi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_taman`
--
ALTER TABLE `tb_taman`
  MODIFY `id_taman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_juara`
--
ALTER TABLE `tb_juara`
  ADD CONSTRAINT `tb_juara_ibfk_1` FOREIGN KEY (`id_pa`) REFERENCES `tb_peserta_pa` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_juara_ibfk_2` FOREIGN KEY (`id_pi`) REFERENCES `tb_peserta_pi` (`id_pi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_juara_ibfk_3` FOREIGN KEY (`id_rekap`) REFERENCES `tb_rekap` (`id_rekap`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_juara_ibfk_4` FOREIGN KEY (`id_rekap_pi`) REFERENCES `tb_rekap_pi` (`id_rekap_pi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_juri`
--
ALTER TABLE `tb_juri`
  ADD CONSTRAINT `tb_juri_ibfk_1` FOREIGN KEY (`id_taman`) REFERENCES `tb_taman` (`id_taman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_prestasi_pa`
--
ALTER TABLE `tb_prestasi_pa`
  ADD CONSTRAINT `tb_prestasi_pa_ibfk_1` FOREIGN KEY (`id_pa`) REFERENCES `tb_peserta_pa` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_prestasi_pa_ibfk_2` FOREIGN KEY (`id_rekap`) REFERENCES `tb_rekap` (`id_rekap`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_prestasi_pi`
--
ALTER TABLE `tb_prestasi_pi`
  ADD CONSTRAINT `tb_prestasi_pi_ibfk_1` FOREIGN KEY (`id_pi`) REFERENCES `tb_peserta_pi` (`id_pi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_prestasi_pi_ibfk_2` FOREIGN KEY (`id_rekap_pi`) REFERENCES `tb_rekap_pi` (`id_rekap_pi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_rekap`
--
ALTER TABLE `tb_rekap`
  ADD CONSTRAINT `tb_rekap_ibfk_1` FOREIGN KEY (`id_pa`) REFERENCES `tb_peserta_pa` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_rekap_pi`
--
ALTER TABLE `tb_rekap_pi`
  ADD CONSTRAINT `tb_rekap_pi_ibfk_1` FOREIGN KEY (`id_pi`) REFERENCES `tb_peserta_pi` (`id_pi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
