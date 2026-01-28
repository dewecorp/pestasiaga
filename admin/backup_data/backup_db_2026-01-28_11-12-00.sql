SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS tb_juara;

CREATE TABLE `tb_juara` (
  `id_juara` int NOT NULL AUTO_INCREMENT,
  `id_pa` int NOT NULL,
  `id_pi` int NOT NULL,
  `id_rekap` int NOT NULL,
  `id_rekap_pi` int NOT NULL,
  `total_nilai` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_juara`),
  KEY `id_pa` (`id_pa`),
  KEY `id_pi` (`id_pi`),
  KEY `id_rekap` (`id_rekap`),
  KEY `id_rekap_pi` (`id_rekap_pi`),
  CONSTRAINT `tb_juara_ibfk_1` FOREIGN KEY (`id_pa`) REFERENCES `tb_peserta_pa` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_juara_ibfk_2` FOREIGN KEY (`id_pi`) REFERENCES `tb_peserta_pi` (`id_pi`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_juara_ibfk_3` FOREIGN KEY (`id_rekap`) REFERENCES `tb_rekap` (`id_rekap`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_juara_ibfk_4` FOREIGN KEY (`id_rekap_pi`) REFERENCES `tb_rekap_pi` (`id_rekap_pi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS tb_juri;

CREATE TABLE `tb_juri` (
  `id_juri` int NOT NULL AUTO_INCREMENT,
  `nama_juri` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkalan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pa` int DEFAULT NULL,
  `id_taman` int NOT NULL,
  `no_hp` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_juri`),
  KEY `id_taman` (`id_taman`),
  KEY `id_pa` (`id_pa`),
  CONSTRAINT `tb_juri_ibfk_1` FOREIGN KEY (`id_taman`) REFERENCES `tb_taman` (`id_taman`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_juri VALUES("3","ALIF ROHMAN SAPUTRA","SDN 3 BUGEL","2","45","08344444");
INSERT INTO tb_juri VALUES("4","DEWI ANISAH","SDN JONDANG","11","31","08977777");
INSERT INTO tb_juri VALUES("5","SANTOSO","","10","49","0823348890");
INSERT INTO tb_juri VALUES("6","DARSONO","MI UNGGULAN","","53","1234");
INSERT INTO tb_juri VALUES("7","DARSONO","MI UNGGULAN","","46","1234");



DROP TABLE IF EXISTS tb_panitia;

CREATE TABLE `tb_panitia` (
  `id_panitia` int NOT NULL AUTO_INCREMENT,
  `ketua_panitia` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketua_juri` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ka_kwarran` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` date DEFAULT NULL,
  `tempat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_panitia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_panitia VALUES("1","NUR HUDA","SYAIFULLAH","HARTONO, S.Pd., M.Pd.","logo-1724327894.png","bg-1632311162.jpg","2024-09-23","SATKORDIK KECAMATAN KEDUNG DAN SEKITARNYA");



DROP TABLE IF EXISTS tb_peserta_pa;

CREATE TABLE `tb_peserta_pa` (
  `id_pa` int NOT NULL AUTO_INCREMENT,
  `no_dada` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkalan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembina` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pa`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_peserta_pa VALUES("1","01","SDN 3 BUGEL","KHOIRUDDIN");
INSERT INTO tb_peserta_pa VALUES("2","03","SDN 2 SURODADI","JAMAL");
INSERT INTO tb_peserta_pa VALUES("3","05","SDN PANGGUNG","JOKO");
INSERT INTO tb_peserta_pa VALUES("4","07","MI SHOFA MARWAH SOWAN LOR","PAIJO");
INSERT INTO tb_peserta_pa VALUES("5","09","SDN 2 SUKOSONO","JONO");
INSERT INTO tb_peserta_pa VALUES("6","11","MI MAFATIHUL HUDA DONGOS","SITI AMINAH");
INSERT INTO tb_peserta_pa VALUES("7","13","SDN 3 MENGANTI","YANTO");
INSERT INTO tb_peserta_pa VALUES("8","15","SDN 3 SUKOSONO","ULIN");
INSERT INTO tb_peserta_pa VALUES("9","17","SDN JONDANG","FATIMAH");
INSERT INTO tb_peserta_pa VALUES("10","21","MI MIFTAHUL HUDA RAU","SUTRISNO");
INSERT INTO tb_peserta_pa VALUES("11","19","SDN 1 SUKOSONO","JUMADI");
INSERT INTO tb_peserta_pa VALUES("12","23","SDN 2 BUGEL","SUDARMI");
INSERT INTO tb_peserta_pa VALUES("13","25","SDN BULAK BARU","JONI");
INSERT INTO tb_peserta_pa VALUES("14","27","MI ROUDHOTUS SIBYAN SOWAN KIDUL","AGUS");
INSERT INTO tb_peserta_pa VALUES("15","29","MI MIFTAHUL ULUM SUKOSONO","JOKO");
INSERT INTO tb_peserta_pa VALUES("16","31","SDN 1 TEDUNAN","AMIR");
INSERT INTO tb_peserta_pa VALUES("17","33","SDN 5 SUKOSONO","HUDA");
INSERT INTO tb_peserta_pa VALUES("18","35","SDN 1 KERSO","KERSO");
INSERT INTO tb_peserta_pa VALUES("19","37","SDN WANUSOBO","YONO");
INSERT INTO tb_peserta_pa VALUES("20","39","MI MATHOLIUL HUDA BUGEL","ROKIM");
INSERT INTO tb_peserta_pa VALUES("21","41","SDN TANGGUL TLARE","SANTOSO");
INSERT INTO tb_peserta_pa VALUES("22","43","SDN 1 SOWAN LOR","JOKO");
INSERT INTO tb_peserta_pa VALUES("23","45","MI SULTAN FATTAH SUKOSONO","HUDA");
INSERT INTO tb_peserta_pa VALUES("24","47","MI INDONESIA","JOKO");



DROP TABLE IF EXISTS tb_peserta_pi;

CREATE TABLE `tb_peserta_pi` (
  `id_pi` int NOT NULL AUTO_INCREMENT,
  `no_dada` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkalan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembina` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pi`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_peserta_pi VALUES("23","02","SDN 1 SURODADI","JAMAL");
INSERT INTO tb_peserta_pi VALUES("24","04","MI SULTAN FATTAH SUKOSONO","JOKO");
INSERT INTO tb_peserta_pi VALUES("25","06","SDN 2 BUGEL","KHOIRUDDIN");
INSERT INTO tb_peserta_pi VALUES("26","08","MI KI AJI TUNGGAL KARANGAJI","JAMAL");
INSERT INTO tb_peserta_pi VALUES("27","10","MI SAFINATUL HUDA SOWAN KIDUL","KHOIRUDDIN");
INSERT INTO tb_peserta_pi VALUES("28","12","MI SALAFIYAH WANUSOBO","JONO");
INSERT INTO tb_peserta_pi VALUES("29","14","MI MIFTAHUL HUDA RAU","SITI");
INSERT INTO tb_peserta_pi VALUES("30","16","MI AL HUDA JONDANG","JAMAL");
INSERT INTO tb_peserta_pi VALUES("31","18","SDN 1 SUKOSONO","MIFTAHUL");
INSERT INTO tb_peserta_pi VALUES("32","20","SDN 2 SUKOSONO","JONO");
INSERT INTO tb_peserta_pi VALUES("33","22","MI MATHOLIUL HUDA BUGEL","JAMAL");
INSERT INTO tb_peserta_pi VALUES("34","24","MI MAFATIHUL HUDA DONGOS","SANTOSO");
INSERT INTO tb_peserta_pi VALUES("35","26","SDN 5 SUKOSONO","TUKIN");
INSERT INTO tb_peserta_pi VALUES("36","28","MI INDONESIA","KHOIRUDDIN");
INSERT INTO tb_peserta_pi VALUES("37","30","MI UNGGULAN","JOKO");
INSERT INTO tb_peserta_pi VALUES("38","32","SDN JONDANG","JOKO");
INSERT INTO tb_peserta_pi VALUES("39","34","SDN 3 BUGEL","JOKO");
INSERT INTO tb_peserta_pi VALUES("40","36","SDN 2 SURODADI","JOKO");



DROP TABLE IF EXISTS tb_prestasi_pa;

CREATE TABLE `tb_prestasi_pa` (
  `id_prestasi_pa` int NOT NULL AUTO_INCREMENT,
  `id_pa` int NOT NULL,
  `id_rekap` int NOT NULL,
  `predikat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_prestasi_pa`),
  KEY `id_pa` (`id_pa`),
  KEY `id_rekap` (`id_rekap`),
  CONSTRAINT `tb_prestasi_pa_ibfk_1` FOREIGN KEY (`id_pa`) REFERENCES `tb_peserta_pa` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_prestasi_pa_ibfk_2` FOREIGN KEY (`id_rekap`) REFERENCES `tb_rekap` (`id_rekap`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS tb_prestasi_pi;

CREATE TABLE `tb_prestasi_pi` (
  `id_prestasi_pi` int NOT NULL AUTO_INCREMENT,
  `id_pi` int NOT NULL,
  `id_rekap_pi` int NOT NULL,
  `predikat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_prestasi_pi`),
  KEY `id_pi` (`id_pi`),
  KEY `id_rekap_pi` (`id_rekap_pi`),
  CONSTRAINT `tb_prestasi_pi_ibfk_1` FOREIGN KEY (`id_pi`) REFERENCES `tb_peserta_pi` (`id_pi`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_prestasi_pi_ibfk_2` FOREIGN KEY (`id_rekap_pi`) REFERENCES `tb_rekap_pi` (`id_rekap_pi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_prestasi_pi VALUES("1","23","1","");
INSERT INTO tb_prestasi_pi VALUES("2","24","3","");



DROP TABLE IF EXISTS tb_rekap;

CREATE TABLE `tb_rekap` (
  `id_rekap` int NOT NULL AUTO_INCREMENT,
  `id_pa` int NOT NULL,
  `toleransi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_pengenal` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rangking` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kim` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scout_skill` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lbb` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kereta_bola` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seni_budaya` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bumbung` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_akhir_pa` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lempar_bola` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kerapian` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patriotisme` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ketakwaan` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_rekap`),
  KEY `id_pa` (`id_pa`),
  CONSTRAINT `tb_rekap_ibfk_1` FOREIGN KEY (`id_pa`) REFERENCES `tb_peserta_pa` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_rekap VALUES("2","2","90","78","68","78","70","86","60","76","100","806","79","","","");
INSERT INTO tb_rekap VALUES("4","4","","77","77","77","88","67","77","77","100","740","100","","","");
INSERT INTO tb_rekap VALUES("5","5","78","100","90","77","0","0","80","75","100","418","66","","","");
INSERT INTO tb_rekap VALUES("6","6","100","77","","0","0","76","80","90","0","535","92","","","");
INSERT INTO tb_rekap VALUES("7","7","","78","77","78","","","","","100","333","79","","","");
INSERT INTO tb_rekap VALUES("8","8","","","","","88","76","","86","","350","60","","","");
INSERT INTO tb_rekap VALUES("9","9","78","77","78","77","88","76","80","86","100","591","87","0","0","0");
INSERT INTO tb_rekap VALUES("10","10","","","","100","","","","","100","300","70","","","");
INSERT INTO tb_rekap VALUES("11","11","","","","","100","","90","","","290","74","","","");
INSERT INTO tb_rekap VALUES("12","1","","100","","100","50","68","100","0","100","618","100","100","100","100");
INSERT INTO tb_rekap VALUES("13","3","","100","","0","0","0","","0","0","282","82","","","");
INSERT INTO tb_rekap VALUES("14","12","","0","","0","0","0","","100","0","180","0","0","0","0");
INSERT INTO tb_rekap VALUES("15","13","","100","","0","100","0","","0","0","300","100","0","0","0");
INSERT INTO tb_rekap VALUES("16","14","","100","","0","0","0","","80","0","280","0","0","100","0");
INSERT INTO tb_rekap VALUES("17","15","","0","","0","100","0","","0","0","150","0","0","50","0");
INSERT INTO tb_rekap VALUES("18","16","","0","","0","0","0","","100","0","200","0","0","100","0");
INSERT INTO tb_rekap VALUES("19","17","","100","","0","0","0","","100","0","200","0","0","0","0");
INSERT INTO tb_rekap VALUES("20","18","","0","","0","0","0","","100","0","189","0","0","89","0");
INSERT INTO tb_rekap VALUES("21","19","","60","","0","100","0","","0","0","160","0","0","0","0");
INSERT INTO tb_rekap VALUES("22","20","","0","","59","80","0","","0","0","239","100","0","0","0");
INSERT INTO tb_rekap VALUES("23","21","","0","","0","100","0","","0","0","188","0","0","0","0");
INSERT INTO tb_rekap VALUES("24","22","","0","","0","0","0","","0","0","200","0","0","100","0");
INSERT INTO tb_rekap VALUES("25","23","","100","","100","100","67","","80","0","447","0","0","0","0");
INSERT INTO tb_rekap VALUES("26","24","","100","","0","0","0","","0","0","200","0","0","100","0");



DROP TABLE IF EXISTS tb_rekap_pi;

CREATE TABLE `tb_rekap_pi` (
  `id_rekap_pi` int NOT NULL AUTO_INCREMENT,
  `id_pi` int NOT NULL,
  `ketakwaan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toleransi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_pengenal` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rangking` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kim` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scout_skill` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lbb` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kereta_bola` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seni_budaya` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bumbung` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_akhir_pi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kerapian` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patriotisme` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lempar_bola` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_rekap_pi`),
  KEY `id_pi` (`id_pi`),
  CONSTRAINT `tb_rekap_pi_ibfk_1` FOREIGN KEY (`id_pi`) REFERENCES `tb_peserta_pi` (`id_pi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_rekap_pi VALUES("1","23","100","90","100","78","80","78","78","90","86","100","622","0","0","0");
INSERT INTO tb_rekap_pi VALUES("2","24","100","","0","78","0","88","76","","67","0","331","0","0","0");
INSERT INTO tb_rekap_pi VALUES("3","25","","78","","78","","","76","","","100","332","","","");
INSERT INTO tb_rekap_pi VALUES("4","26","0","78","0","78","0","0","0","","75","100","175","0","0","0");
INSERT INTO tb_rekap_pi VALUES("5","27","0","","0","","0","0","0","","0","0","100","0","0","0");
INSERT INTO tb_rekap_pi VALUES("6","28","0","","0","","0","0","0","","0","0","100","0","0","0");
INSERT INTO tb_rekap_pi VALUES("7","29","0","","0","","100","100","0","","0","0","200","0","0","0");
INSERT INTO tb_rekap_pi VALUES("8","30","100","","0","","0","0","0","","0","0","200","0","100","0");
INSERT INTO tb_rekap_pi VALUES("9","31","100","","0","","0","0","0","","0","0","200","0","100","0");
INSERT INTO tb_rekap_pi VALUES("10","32","0","","0","","50","0","0","","100","0","250","100","0","0");
INSERT INTO tb_rekap_pi VALUES("11","36","67","","100","","0","100","0","","100","0","467","0","100","0");
INSERT INTO tb_rekap_pi VALUES("12","35","0","","0","","0","0","0","","100","0","200","0","100","0");
INSERT INTO tb_rekap_pi VALUES("13","34","0","","0","","0","0","0","","50","0","150","0","100","");
INSERT INTO tb_rekap_pi VALUES("14","33","0","","0","","100","0","0","","88","0","188","0","0","");
INSERT INTO tb_rekap_pi VALUES("15","37","0","","100","","0","0","0","","0","0","100","0","0","0");
INSERT INTO tb_rekap_pi VALUES("16","38","0","","0","","0","0","0","","0","0","68","0","0","0");
INSERT INTO tb_rekap_pi VALUES("17","39","0","","100","","100","100","100","","0","0","500","100","0","0");
INSERT INTO tb_rekap_pi VALUES("18","40","100","","0","","0","100","100","","0","0","400","100","0","");



DROP TABLE IF EXISTS tb_taman;

CREATE TABLE `tb_taman` (
  `id_taman` int NOT NULL AUTO_INCREMENT,
  `nama_taman` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_taman`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_taman VALUES("31","TANDA PENGENAL PUTRI","");
INSERT INTO tb_taman VALUES("34","KETAKWAAN PUTRI","");
INSERT INTO tb_taman VALUES("36","PATRIOTISME PUTRA","");
INSERT INTO tb_taman VALUES("37","PATRIOTISME PUTRI","");
INSERT INTO tb_taman VALUES("38","SENI BUDAYA PUTRA","");
INSERT INTO tb_taman VALUES("39","SENI BUDAYA PUTRI","");
INSERT INTO tb_taman VALUES("40","KERAPIAN PUTRA","Pasar Depan");
INSERT INTO tb_taman VALUES("41","KERAPIAN PUTRI","");
INSERT INTO tb_taman VALUES("42","LBB PUTRA","");
INSERT INTO tb_taman VALUES("43","LBB PUTRI","");
INSERT INTO tb_taman VALUES("44","TANDA PENGENAL PUTRA","");
INSERT INTO tb_taman VALUES("45","BUMBUNG PEDULI PUTRI","Toko Sebelah");
INSERT INTO tb_taman VALUES("46","SCOUTING SKILLS PUTRA","");
INSERT INTO tb_taman VALUES("47","SCOUTING SKILLS PUTRI","");
INSERT INTO tb_taman VALUES("48","KIM PUTRA","");
INSERT INTO tb_taman VALUES("49","KIM PUTRI","");
INSERT INTO tb_taman VALUES("50","BUMBUNG PEDULI PUTRA","Pasar Samping");
INSERT INTO tb_taman VALUES("53","LEMPAR BOLA PUTRA","Kelas 6");
INSERT INTO tb_taman VALUES("54","KETAKWAAN PUTRA","Kelas 5");
INSERT INTO tb_taman VALUES("55","LEMPAR BOLA PUTRI","Pasar Samping");



DROP TABLE IF EXISTS tb_user;

CREATE TABLE `tb_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_user VALUES("1","admin","admin","NUR HUDA","admin");
INSERT INTO tb_user VALUES("2","admin2","admin2","AMIN SOFWAN","admin");



SET FOREIGN_KEY_CHECKS=1;