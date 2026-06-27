Enter password: 
-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: laravel_sp
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
mysqldump: Error: 'Access denied; you need (at least one of) the PROCESS privilege(s) for this operation' when trying to dump tablespaces

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dilakukan_oleh` bigint unsigned DEFAULT NULL,
  `nama_pelaku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_pelaku` enum('Admin','Mahasiswa','System') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modul` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aksi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_record` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_sebelum` json DEFAULT NULL,
  `data_sesudah` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,'2026-06-27 23:18:14',4,'Admin SmartLab','Admin','Tools','Create','3','[]','{\"id\": 3, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 1.\", \"kode_alat\": \"AL-001\", \"nama_alat\": \"Alat Praktikum 1\", \"created_at\": \"2026-06-27T23:18:14.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:14.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:14','2026-06-27 23:18:14'),(2,'2026-06-27 23:18:14',4,'Admin SmartLab','Admin','Tools','Create','4','[]','{\"id\": 4, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 2.\", \"kode_alat\": \"AL-002\", \"nama_alat\": \"Alat Praktikum 2\", \"created_at\": \"2026-06-27T23:18:14.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:14.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:14','2026-06-27 23:18:14'),(3,'2026-06-27 23:18:14',4,'Admin SmartLab','Admin','Tools','Create','5','[]','{\"id\": 5, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 3.\", \"kode_alat\": \"AL-003\", \"nama_alat\": \"Alat Praktikum 3\", \"created_at\": \"2026-06-27T23:18:14.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:14.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:14','2026-06-27 23:18:14'),(4,'2026-06-27 23:18:14',4,'Admin SmartLab','Admin','Tools','Create','6','[]','{\"id\": 6, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 4.\", \"kode_alat\": \"AL-004\", \"nama_alat\": \"Alat Praktikum 4\", \"created_at\": \"2026-06-27T23:18:14.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:14.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:14','2026-06-27 23:18:14'),(5,'2026-06-27 23:18:15',4,'Admin SmartLab','Admin','Tools','Create','7','[]','{\"id\": 7, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 5.\", \"kode_alat\": \"AL-005\", \"nama_alat\": \"Alat Praktikum 5\", \"created_at\": \"2026-06-27T23:18:15.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:15.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:15','2026-06-27 23:18:15'),(6,'2026-06-27 23:18:15',4,'Admin SmartLab','Admin','Tools','Create','8','[]','{\"id\": 8, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 6.\", \"kode_alat\": \"AL-006\", \"nama_alat\": \"Alat Praktikum 6\", \"created_at\": \"2026-06-27T23:18:15.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:15.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:15','2026-06-27 23:18:15'),(7,'2026-06-27 23:18:15',4,'Admin SmartLab','Admin','Tools','Create','9','[]','{\"id\": 9, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 7.\", \"kode_alat\": \"AL-007\", \"nama_alat\": \"Alat Praktikum 7\", \"created_at\": \"2026-06-27T23:18:15.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:15.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:15','2026-06-27 23:18:15'),(8,'2026-06-27 23:18:15',4,'Admin SmartLab','Admin','Tools','Create','10','[]','{\"id\": 10, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 8.\", \"kode_alat\": \"AL-008\", \"nama_alat\": \"Alat Praktikum 8\", \"created_at\": \"2026-06-27T23:18:15.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:15.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:15','2026-06-27 23:18:15'),(9,'2026-06-27 23:18:16',4,'Admin SmartLab','Admin','Tools','Create','11','[]','{\"id\": 11, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 9.\", \"kode_alat\": \"AL-009\", \"nama_alat\": \"Alat Praktikum 9\", \"created_at\": \"2026-06-27T23:18:16.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:16.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:16','2026-06-27 23:18:16'),(10,'2026-06-27 23:18:16',4,'Admin SmartLab','Admin','Tools','Create','12','[]','{\"id\": 12, \"lokasi\": \"Lab Biologi Dasar\", \"kategori\": \"Alat Optik\", \"deskripsi\": \"Deskripsi untuk Alat Praktikum 10.\", \"kode_alat\": \"AL-010\", \"nama_alat\": \"Alat Praktikum 10\", \"created_at\": \"2026-06-27T23:18:16.000000Z\", \"stok_total\": 10, \"updated_at\": \"2026-06-27T23:18:16.000000Z\", \"status_alat\": \"Tersedia\", \"stok_tersedia\": 10}','127.0.0.1','2026-06-27 23:18:16','2026-06-27 23:18:16');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowing_items`
--

DROP TABLE IF EXISTS `borrowing_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrowing_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `borrowing_id` bigint unsigned NOT NULL,
  `tool_id` bigint unsigned NOT NULL,
  `jumlah_unit` int NOT NULL DEFAULT '1',
  `kondisi_saat_kembali` enum('Baik','Rusak Ringan','Rusak Berat') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_pengembalian` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borrowing_items_borrowing_id_foreign` (`borrowing_id`),
  KEY `borrowing_items_tool_id_foreign` (`tool_id`),
  CONSTRAINT `borrowing_items_borrowing_id_foreign` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `borrowing_items_tool_id_foreign` FOREIGN KEY (`tool_id`) REFERENCES `tools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowing_items`
--

LOCK TABLES `borrowing_items` WRITE;
/*!40000 ALTER TABLE `borrowing_items` DISABLE KEYS */;
INSERT INTO `borrowing_items` VALUES (1,1,3,1,NULL,NULL,NULL,NULL),(2,2,4,1,NULL,NULL,NULL,NULL),(3,3,5,1,NULL,NULL,NULL,NULL),(4,4,6,1,NULL,NULL,NULL,NULL),(5,5,7,1,NULL,NULL,NULL,NULL),(6,6,8,1,NULL,NULL,NULL,NULL),(7,7,9,1,NULL,NULL,NULL,NULL),(8,8,10,1,NULL,NULL,NULL,NULL),(9,9,11,1,NULL,NULL,NULL,NULL),(10,10,12,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `borrowing_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrowings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint unsigned NOT NULL,
  `tgl_pengajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_rencana_pinjam` date NOT NULL,
  `tgl_rencana_kembali` date NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak','Dipinjam','Dikembalikan','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `diproses_oleh` bigint unsigned DEFAULT NULL,
  `tgl_diproses` datetime DEFAULT NULL,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `tgl_pengembalian_aktual` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borrowings_mahasiswa_id_foreign` (`mahasiswa_id`),
  KEY `borrowings_diproses_oleh_foreign` (`diproses_oleh`),
  KEY `borrowings_status_index` (`status`),
  KEY `borrowings_created_at_index` (`created_at`),
  CONSTRAINT `borrowings_diproses_oleh_foreign` FOREIGN KEY (`diproses_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `borrowings_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowings`
--

LOCK TABLES `borrowings` WRITE;
/*!40000 ALTER TABLE `borrowings` DISABLE KEYS */;
INSERT INTO `borrowings` VALUES (1,5,'2026-06-27 23:18:14','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 1','Disetujui',4,'2026-06-27 23:18:14',NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14'),(2,6,'2026-06-27 23:18:14','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 2','Disetujui',4,'2026-06-27 23:18:14',NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14'),(3,7,'2026-06-27 23:18:14','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 3','Disetujui',4,'2026-06-27 23:18:14',NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14'),(4,8,'2026-06-27 23:18:14','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 4','Disetujui',4,'2026-06-27 23:18:14',NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14'),(5,9,'2026-06-27 23:18:15','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 5','Disetujui',4,'2026-06-27 23:18:15',NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15'),(6,10,'2026-06-27 23:18:15','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 6','Disetujui',4,'2026-06-27 23:18:15',NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15'),(7,11,'2026-06-27 23:18:15','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 7','Disetujui',4,'2026-06-27 23:18:15',NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15'),(8,12,'2026-06-27 23:18:15','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 8','Disetujui',4,'2026-06-27 23:18:15',NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15'),(9,13,'2026-06-27 23:18:16','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 9','Disetujui',4,'2026-06-27 23:18:16',NULL,NULL,'2026-06-27 23:18:16','2026-06-27 23:18:16'),(10,14,'2026-06-27 23:18:16','2026-06-28','2026-06-30','Praktikum Jaringan Komputer Lanjut 10','Disetujui',4,'2026-06-27 23:18:16',NULL,NULL,'2026-06-27 23:18:16','2026-06-27 23:18:16');
/*!40000 ALTER TABLE `borrowings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_mutations`
--

DROP TABLE IF EXISTS `item_mutations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_mutations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned NOT NULL,
  `tipe_mutasi` enum('Masuk','Keluar','Penyesuaian') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `stok_sebelum` int NOT NULL,
  `stok_sesudah` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `dilakukan_oleh` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_mutations_item_id_foreign` (`item_id`),
  KEY `item_mutations_dilakukan_oleh_foreign` (`dilakukan_oleh`),
  KEY `item_mutations_created_at_index` (`created_at`),
  CONSTRAINT `item_mutations_dilakukan_oleh_foreign` FOREIGN KEY (`dilakukan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `item_mutations_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_mutations`
--

LOCK TABLES `item_mutations` WRITE;
/*!40000 ALTER TABLE `item_mutations` DISABLE KEYS */;
INSERT INTO `item_mutations` VALUES (1,1,'Masuk',50,0,50,'Pengadaan barang awal 1',4,NULL,NULL),(2,2,'Masuk',50,0,50,'Pengadaan barang awal 2',4,NULL,NULL),(3,3,'Masuk',50,0,50,'Pengadaan barang awal 3',4,NULL,NULL),(4,4,'Masuk',50,0,50,'Pengadaan barang awal 4',4,NULL,NULL),(5,5,'Masuk',50,0,50,'Pengadaan barang awal 5',4,NULL,NULL),(6,6,'Masuk',50,0,50,'Pengadaan barang awal 6',4,NULL,NULL),(7,7,'Masuk',50,0,50,'Pengadaan barang awal 7',4,NULL,NULL),(8,8,'Masuk',50,0,50,'Pengadaan barang awal 8',4,NULL,NULL),(9,9,'Masuk',50,0,50,'Pengadaan barang awal 9',4,NULL,NULL),(10,10,'Masuk',50,0,50,'Pengadaan barang awal 10',4,NULL,NULL);
/*!40000 ALTER TABLE `item_mutations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `stok` int NOT NULL DEFAULT '0',
  `stok_minimum` int NOT NULL DEFAULT '0',
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat','Tidak Layak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `lokasi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pengadaan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_kode_barang_unique` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'BR-001','Barang Inventaris 1','Networking','Deskripsi barang inventaris 1.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(2,'BR-002','Barang Inventaris 2','Networking','Deskripsi barang inventaris 2.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(3,'BR-003','Barang Inventaris 3','Networking','Deskripsi barang inventaris 3.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(4,'BR-004','Barang Inventaris 4','Networking','Deskripsi barang inventaris 4.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(5,'BR-005','Barang Inventaris 5','Networking','Deskripsi barang inventaris 5.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(6,'BR-006','Barang Inventaris 6','Networking','Deskripsi barang inventaris 6.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(7,'BR-007','Barang Inventaris 7','Networking','Deskripsi barang inventaris 7.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(8,'BR-008','Barang Inventaris 8','Networking','Deskripsi barang inventaris 8.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(9,'BR-009','Barang Inventaris 9','Networking','Deskripsi barang inventaris 9.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:16','2026-06-27 23:18:16',NULL),(10,'BR-010','Barang Inventaris 10','Networking','Deskripsi barang inventaris 10.',50,10,'Meter','Baik','Gudang Lab Komputer','2026-06-27','2026-06-27 23:18:16','2026-06-27 23:18:16',NULL);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_nim_unique` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'123456789001','Dummy Mahasiswa 1','2026-06-27 23:18:14','2026-06-27 23:18:14'),(2,'123456789002','Dummy Mahasiswa 2','2026-06-27 23:18:14','2026-06-27 23:18:14'),(3,'123456789003','Dummy Mahasiswa 3','2026-06-27 23:18:14','2026-06-27 23:18:14'),(4,'123456789004','Dummy Mahasiswa 4','2026-06-27 23:18:14','2026-06-27 23:18:14'),(5,'123456789005','Dummy Mahasiswa 5','2026-06-27 23:18:15','2026-06-27 23:18:15'),(6,'123456789006','Dummy Mahasiswa 6','2026-06-27 23:18:15','2026-06-27 23:18:15'),(7,'123456789007','Dummy Mahasiswa 7','2026-06-27 23:18:15','2026-06-27 23:18:15'),(8,'123456789008','Dummy Mahasiswa 8','2026-06-27 23:18:15','2026-06-27 23:18:15'),(9,'123456789009','Dummy Mahasiswa 9','2026-06-27 23:18:16','2026-06-27 23:18:16'),(10,'123456789010','Dummy Mahasiswa 10','2026-06-27 23:18:16','2026-06-27 23:18:16');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_24_032002_create_mahasiswa_table',1),(5,'2026_06_09_001301_create_tools_table',1),(6,'2026_06_09_001302_create_items_table',1),(7,'2026_06_09_001303_create_borrowings_table',1),(8,'2026_06_09_001304_create_borrowing_items_table',1),(9,'2026_06_09_001305_create_item_mutations_table',1),(10,'2026_06_09_001306_create_audit_logs_table',1),(11,'2026_06_10_045235_create_personal_access_tokens_table',1),(12,'2026_06_22_075143_add_nonaktif_to_status_alat_enum_in_tools_table',1),(13,'2026_06_23_000001_add_stok_minimum_to_items_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tools`
--

DROP TABLE IF EXISTS `tools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tools` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_alat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_alat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `stok_total` int NOT NULL DEFAULT '0',
  `stok_tersedia` int NOT NULL DEFAULT '0',
  `status_alat` enum('Tersedia','Dipinjam','Rusak','Dalam Perbaikan','Nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `lokasi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_alat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tools_kode_alat_unique` (`kode_alat`),
  KEY `tools_status_alat_index` (`status_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools`
--

LOCK TABLES `tools` WRITE;
/*!40000 ALTER TABLE `tools` DISABLE KEYS */;
INSERT INTO `tools` VALUES (1,'BB400','Breadboard 400 Holes','Komponen Dasar',NULL,50,50,'Tersedia',NULL,NULL,'2026-06-27 23:18:13','2026-06-27 23:18:13',NULL),(2,'UNO-R3','Arduino Uno R3','Microcontroller',NULL,20,20,'Tersedia',NULL,NULL,'2026-06-27 23:18:13','2026-06-27 23:18:13',NULL),(3,'AL-001','Alat Praktikum 1','Alat Optik','Deskripsi untuk Alat Praktikum 1.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(4,'AL-002','Alat Praktikum 2','Alat Optik','Deskripsi untuk Alat Praktikum 2.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(5,'AL-003','Alat Praktikum 3','Alat Optik','Deskripsi untuk Alat Praktikum 3.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(6,'AL-004','Alat Praktikum 4','Alat Optik','Deskripsi untuk Alat Praktikum 4.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(7,'AL-005','Alat Praktikum 5','Alat Optik','Deskripsi untuk Alat Praktikum 5.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(8,'AL-006','Alat Praktikum 6','Alat Optik','Deskripsi untuk Alat Praktikum 6.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(9,'AL-007','Alat Praktikum 7','Alat Optik','Deskripsi untuk Alat Praktikum 7.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(10,'AL-008','Alat Praktikum 8','Alat Optik','Deskripsi untuk Alat Praktikum 8.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(11,'AL-009','Alat Praktikum 9','Alat Optik','Deskripsi untuk Alat Praktikum 9.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:16','2026-06-27 23:18:16',NULL),(12,'AL-010','Alat Praktikum 10','Alat Optik','Deskripsi untuk Alat Praktikum 10.',10,10,'Tersedia','Lab Biologi Dasar',NULL,'2026-06-27 23:18:16','2026-06-27 23:18:16',NULL);
/*!40000 ALTER TABLE `tools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `program_studi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nim_unique` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sandy Aryadi','Admin','admin','admin@ipwija.ac.id',NULL,'$2y$12$fJRR5QCsUR4RrNgFI3.7BusQBSbCp/iAtBbzoefOELsZZYsTGcWWO','admin',NULL,1,NULL,NULL,'2026-06-27 23:18:13','2026-06-27 23:18:13',NULL),(2,'Renaldi Sentosa','Mahasiswa','202301110011','mahasiswa@ipwija.ac.id',NULL,'$2y$12$TcUZf2nkiCOnk474LsNU4OudrLJUWbqe8EMTUwBK78Zp8ieXuSsi6','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:13','2026-06-27 23:18:13',NULL),(3,'Dr. Hermawan, M.T.','Dosen','198701012','dosen@ipwija.ac.id',NULL,'$2y$12$2v/9yYDhwUmBJrw./GjXk.pVmVp.8cr3hH9fOR06tG9kaUBtkn/Tu','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:13','2026-06-27 23:18:13',NULL),(4,'Admin SmartLab',NULL,'dummyadmin','dummyadmin@ipwija.ac.id',NULL,'$2y$12$4jzfvDu932uqbMGLoe09uOuc9RvQQI1hwmnDw0PBA20rjPTMxcwlG','admin',NULL,1,NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(5,'Dummy Mahasiswa 1',NULL,'123456789001','dummymhs1@ipwija.ac.id',NULL,'$2y$12$U4lX75e2HsE5lk6Ke9L1FePwy37BrUPLlIni2XealI/fVEyGxPsHy','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(6,'Dummy Mahasiswa 2',NULL,'123456789002','dummymhs2@ipwija.ac.id',NULL,'$2y$12$oLmKyg8k18emO5xJb8fsVOFwycF3Y/pMwXIAHNLtj9mNy6lHvoCeG','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(7,'Dummy Mahasiswa 3',NULL,'123456789003','dummymhs3@ipwija.ac.id',NULL,'$2y$12$XbtKnQVr7tmq8q.ICSy25.xUy0qDtumGIFMXzA/k7GPypp7PgIjp6','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(8,'Dummy Mahasiswa 4',NULL,'123456789004','dummymhs4@ipwija.ac.id',NULL,'$2y$12$Ms7FhkLjS6hu3BQkyBmyMeGRFTwZffrW305MGtiNpbKSBYKk2nJ3S','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:14','2026-06-27 23:18:14',NULL),(9,'Dummy Mahasiswa 5',NULL,'123456789005','dummymhs5@ipwija.ac.id',NULL,'$2y$12$jhHyTQ09vVk3WUfMeux2FeiRbFy/ymgShaQ2TSdZ5qFVhMsdFfWvW','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(10,'Dummy Mahasiswa 6',NULL,'123456789006','dummymhs6@ipwija.ac.id',NULL,'$2y$12$wMNUax2zZhEKzaLzAuVOz.3u/vTnyMVEIvT73BoEsZ6pSh5N3pVJC','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(11,'Dummy Mahasiswa 7',NULL,'123456789007','dummymhs7@ipwija.ac.id',NULL,'$2y$12$y1GhFN6mbr4fOJC3F/8NN.bm892bNvT2K4d5hGzpFqQKmZUheerw2','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(12,'Dummy Mahasiswa 8',NULL,'123456789008','dummymhs8@ipwija.ac.id',NULL,'$2y$12$9t1AisqKRwO2FpIJcyN0puQBG9ARDNQ19xahszOtnPeAvaxEWWtpK','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:15','2026-06-27 23:18:15',NULL),(13,'Dummy Mahasiswa 9',NULL,'123456789009','dummymhs9@ipwija.ac.id',NULL,'$2y$12$g1L0m1Lmdi8Yx1xiUizfQ.ST29TiQ00.vM1Vq9E0ovqvb90A7VZ3O','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:16','2026-06-27 23:18:16',NULL),(14,'Dummy Mahasiswa 10',NULL,'123456789010','dummymhs10@ipwija.ac.id',NULL,'$2y$12$ryql3WrdxpegIU0GDZBwe..y..GiIBhkHVzPo8unnqRDJDtxzIC5a','mahasiswa','Teknik Informatika',1,NULL,NULL,'2026-06-27 23:18:16','2026-06-27 23:18:16',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-27 23:32:24
