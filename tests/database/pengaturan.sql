# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: spp_21062021
# ------------------------------------------------------
# Server version 5.5.5-10.4.11-MariaDB

#
# Source for table pengaturan
#

DROP TABLE IF EXISTS `pengaturan`;
CREATE TABLE `pengaturan` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `field` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `label` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `tipe` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `tipe_param_value` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `deskripsi` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `grup` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table pengaturan
#

LOCK TABLES `pengaturan` WRITE;
/*!40000 ALTER TABLE `pengaturan` DISABLE KEYS */;
INSERT INTO `pengaturan` VALUES (1,'KONTAK_ALAMAT','Alamat','textarea',NULL,'Kompleks Rasuna Epicentrum, Jalan Epicentrum Tengah Lot 11 B, RT.2/RW.5, Karet Kuningan, Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12940',NULL,'kontak',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (2,'KONTAK_NOMOR_TELEPON','Nomor Telepon','text',NULL,'(021) 299 12 450',NULL,'kontak',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (3,'KONTAK_NOMOR_HP','Nomor HP','text',NULL,'',NULL,'kontak',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (4,'KONTAK_FAX','Fax','text',NULL,'(021) 299 12 451',NULL,'kontak',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (5,'KONTAK_EMAIL','Email','text',NULL,'',NULL,'kontak',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (6,'WEBSITE_FOOTER','Footer','textarea',NULL,NULL,NULL,'website',0,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (7,'WEBSITE_NAMA','Nama','text',NULL,'DASHBOARD KEDEPUTIAN 4',NULL,'website',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (8,'WEBSITE_SCRIPT_GOOGLE_ANALYTIC','Script Google Analytic','textarea',NULL,NULL,NULL,'website',0,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (9,'WEBISTE_VERSI','Versi','text',NULL,'1.0.0',NULL,'website',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (10,'WEBSITE_DESKRIPSI','Deskripsi','textarea',NULL,'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type a',NULL,'website',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (11,'WEBSITE_ICON','Gambar Ikon Aplikasi','file',NULL,NULL,NULL,'website',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
INSERT INTO `pengaturan` VALUES (12,'WEBSITE_ICON_LKPP','Gambar Ikon LKPP','file',NULL,NULL,NULL,'website',1,1,'2017-12-25 09:36:58','2017-12-25 09:36:58');
/*!40000 ALTER TABLE `pengaturan` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
