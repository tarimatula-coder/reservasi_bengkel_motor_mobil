-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2025 at 03:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservasi_bengkel_motor_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(150) DEFAULT NULL,
  `object_type` varchar(100) DEFAULT NULL,
  `object_id` varchar(50) DEFAULT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `object_type`, `object_id`, `message`) VALUES
(NULL, NULL, 'update', 'pembayaran', '11', 'saya kendala motor');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int NOT NULL,
  `pelanggan_id` int DEFAULT NULL,
  `jenis` enum('motor','mobil') DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `plat_nomor` varchar(30) DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `catatan` text,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `pelanggan_id`, `jenis`, `merk`, `model`, `plat_nomor`, `tahun`, `catatan`, `image`) VALUES
(1, 1, 'motor', 'Honda', 'Beat', 'DK 9087 AB', 2024, 'motor dengan keadaan mulus', '1764079408_kendaraan.jpg'),
(2, 4, 'motor', 'Yamaha', 'Aerox', 'AD 7812 GF', 2023, 'Mesin responsif, tarikan halus.', '1764079340_kendaraan.jpg'),
(3, 3, 'mobil', 'Honda', 'HR-V', 'B 1234 CD', 2025, 'Kelistrikan normal', '1764079299_kendaraan.jpg'),
(4, 3, 'mobil', 'Toyota', 'Veloz', 'L 1122 KA', 2025, 'Kondisi mesin baik', '1764079267_kendaraan.jpg'),
(28, 7, 'motor', 'Suzuki', 'NEX II', 'E 1111 ZZ', 2019, 'Perlu ganti aki, susah starter.', '1764079048_kendaraan.jpg'),
(29, 9, 'motor', 'Kawasaki', 'KLX 150', 'AB 8080 FG', 2021, 'Rantai kendor dan ban luar mulai tipis.', '1764079033_kendaraan.jpg'),
(30, 12, 'motor', 'Vespa', 'Primavera', 'L 5555 SA', 2022, 'Cek sistem rem, bunyi mencicit.', '1764079018_kendaraan.jpg'),
(31, 4, 'mobil', 'Toyota', 'Rush', 'AG 2020 RU', 2018, 'Ganti busi dan filter udara.', '1764079002_kendaraan.jpg'),
(32, 6, 'mobil', 'Daihatsu', 'Sigra', 'B 3003 SD', 2021, 'Perlu perbaikan pada door lock pintu belakang.', '1764078985_kendaraan.jpg'),
(33, 8, 'mobil', 'Honda', 'Brio RS', 'H 4444 BR', 2023, 'Ban belakang kanan kempes perlahan, cek kebocoran.', '1764085324_kendaraan.jpg'),
(34, 10, 'mobil', 'Mitsubishi', 'Pajero Sport', 'W 9999 JT', 2019, 'Servis besar, kuras oli matic.', '1764078932_kendaraan.jpg'),
(35, 11, 'mobil', 'Suzuki', 'Jimny', 'AD 1945 JM', 2024, 'Baru selesai off-road, cek kaki-kaki.', '1764078635_kendaraan.jpg'),
(38, 8, 'mobil', 'Toyota', 'HR-V', 'AD 7812 GF', 2025, 'Hrv sangat mulus', '1764087740_kendaraan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `periode` varchar(20) DEFAULT NULL,
  `jumlah_reservasi` int DEFAULT NULL,
  `total_pendapatan` decimal(15,2) DEFAULT NULL,
  `dibuat_oleh` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `periode`, `jumlah_reservasi`, `total_pendapatan`, `dibuat_oleh`) VALUES
(1, '2025', 24, '900000.00', 'asla'),
(4, '2025', 28, '800000.00', 'sera'),
(5, '2025', 25, '200000.00', 'asla'),
(6, '2025', 35, '200000.00', 'asla'),
(7, '2025', 30, '500000.00', 'siti');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int NOT NULL,
  `nama_layanan` varchar(150) DEFAULT NULL,
  `kategori` enum('servis ringan','servis berat','oli','cuci','sparepart') DEFAULT NULL,
  `durasi_minutes` int DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `deskripsi` text,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama_layanan`, `kategori`, `durasi_minutes`, `harga`, `deskripsi`, `image`) VALUES
(8, 'Penggantian Oli Mesin Sintetik', 'oli', 20, '120000.00', 'Penggantian oli mesin baru (harga oli tidak termasuk) dan filter oli.', '1764080775_layanan.jpg'),
(9, 'Cuci Premium Mobil (Interior & Wax)', 'cuci', 45, '75000.00', 'Pencucian interior dan eksterior lengkap dengan vacuum dan aplikasi wax.', '1764080964_layanan.jpg'),
(11, 'Servis Rutin Motor (Ringan)', 'servis ringan', 60, '85000.00', 'Pengecekan standar, pembersihan injektor/karburator, setel komponen, dan pelumasan.', '1764080635_layanan.jpg'),
(12, 'Servis Besar Mobil 100K KM', 'servis berat', 180, '450000.00', 'Pengecekan dan penggantian busi, filter udara, filter bensin, dan cairan rem.', '1764080605_layanan.jpg'),
(13, 'Penggantian Oli Mesin Sintetik', 'oli', 20, '120000.00', 'Penggantian oli mesin baru (harga oli tidak termasuk) dan filter oli.', '1764080370_layanan.jpg'),
(15, 'Penggantian Ban Motor Tubeless', 'sparepart', 30, '50000.00', 'Jasa penggantian ban tubeless (hanya jasa, harga ban tidak termasuk).', '1764081514_layanan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mekanik`
--

CREATE TABLE `mekanik` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `skill` varchar(200) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mekanik`
--

INSERT INTO `mekanik` (`id`, `user_id`, `nama`, `skill`, `phone`, `is_available`, `image`) VALUES
(1, 5, 'pak saifur', 'otomotif', '(0291) 772322', 1, '1764083985_mekanik.jpg'),
(2, 3, 'Sella', 'otomotif', '082335645804', 1, '1764083962_mekanik.jpg'),
(6, 11, 'Eko Prasetyo', 'Body Repair & Cat', '089676543210', 1, '1764083930_mekanik.jpg'),
(7, 12, 'Fani Rahmawati', 'Injeksi dan ECU', '081543219876', 0, '1764083883_mekanik.jpg'),
(8, 13, 'Gilang Ramadhan', 'Kaki-kaki dan Rem', '087788990011', 1, '1764083824_mekanik.jpg'),
(9, 1, 'Aslamiyah', 'Administrasi dan Akuntansi', '082335645804', 0, '1764085610_mekanik.jpg'),
(10, 4, 'Tari matul', 'Kelistrikan', '082335645804', 1, '1764083627_mekanik.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `alamat` text,
  `email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `no_hp`, `alamat`, `email`) VALUES
(1, 'Sella', '086789512', 'jln penjaringan jakarta utara', 'tarimatula@gmail.com'),
(3, 'Diana pratiwi', '082335645804', 'jalan kancilan rt 01 rw 06', 'tarimatula@gmail.com'),
(4, 'pak saifur', '082335645804', 'Jalan pemuda', 'aslamiyah@gmail.com'),
(6, 'Sera', '08764532', 'jalan cepogo', 'sera@gmail.com'),
(7, 'Joko Susilo', '081234567890', 'Jl. Merdeka No. 15, Bandung', 'joko.susilo@mail.com'),
(8, 'Bambang Pamungkas', '085001122334', 'Komplek Griya Indah Blok C7, Surabaya', 'bambang.p@mail.com'),
(9, 'Rina Amelia', '087766554433', 'Perumahan Damai Sentosa No. 88, Yogyakarta', 'rina.amelia@mail.com'),
(10, 'Fajar Kurniawan', '089988776655', 'Gang Kenanga III No. 22, Jakarta Selatan', 'fajar.k@mail.com'),
(11, 'Lia Hartati', '083322110099', 'Jln. Mangga Besar IX, Medan', 'lia.hartati@mail.com'),
(12, 'Eko Prasetyo', '088899776655', 'Jalan Raya Cibiru KM 10, Bogor', 'eko.prasetyo@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int NOT NULL,
  `pelanggan_id` int DEFAULT NULL,
  `kendaraan_id` int DEFAULT NULL,
  `layanan_id` int DEFAULT NULL,
  `mekanik_id` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `durasi_minutes` int DEFAULT NULL,
  `status` enum('booked','confirmed','in-progress','completed','cancelled') DEFAULT NULL,
  `total_harga` decimal(12,2) DEFAULT NULL,
  `catatan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id`, `pelanggan_id`, `kendaraan_id`, `layanan_id`, `mekanik_id`, `tanggal`, `waktu`, `durasi_minutes`, `status`, `total_harga`, `catatan`) VALUES
(10, 3, 35, 9, 1, '2025-11-19', '08:00:00', 50, 'confirmed', '150000.00', 'busi mati'),
(18, 3, 2, 11, 2, '2025-11-20', '18:01:00', 60, 'confirmed', '8500000.00', 'ryhrn');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `reservasi_id` int DEFAULT NULL,
  `tipe_pembayaran` enum('tunai','transfer','e-wallet') DEFAULT NULL,
  `nominal` decimal(12,2) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `reservasi_id`, `tipe_pembayaran`, `nominal`, `tanggal_pembayaran`, `status`, `bukti_transfer`) VALUES
(24, 18, 'transfer', '250000.00', '2025-11-25 00:00:00', 'confirmed', '1764082127.png'),
(25, 10, 'transfer', '150000.00', '2025-11-25 00:00:00', 'confirmed', '1764082326.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','pelanggan','mekanik','kasir') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `phone`, `email`, `is_active`) VALUES
(1, 'aslamiyah', '$2y$10$.co8FsFtOzAw8mXpWtyVwOGEOQ65En/uBXkc8q6r/5r8389L5njnO', 'admin', 'asla', '082335645804', 'tarimatula@gmail.com', 1),
(3, 'sella', '$2y$10$dJtya9VpOq6cVoJKez4hyOsbMbVK.X7o88G7Aje3jo26bMEwUEPm.', 'mekanik', 'sella', '082335645804', 'tarimatula@gmail.com', 1),
(4, 'Tari matul', '$2y$10$/IbwKsIiLIN3w5WmSg8QcefycHpvBwL2TOupog3YD6Katvf/l7wWi', 'pelanggan', 'asla', '082335645804', 'tarimatula@gmail.com', 1),
(5, 'pak saifur', '$2y$10$8vhrTURSmPzTFA7dcMfpL.S2mqqatU1zZRJGb88a6MPLfsqSwSqo2', 'mekanik', 'pak saifur', '524524624624', 'dfsefe@gmail.com', 1),
(11, 'EkoMekanik', 'mekanik456', 'mekanik', 'Eko Prasetyo', '089676543210', 'eko.prast@bengkel.com', 1),
(12, 'FaniMekanik', 'mekanik456', 'mekanik', 'Fani Rahmawati', '081543219876', 'fani.rahm@bengkel.com', 1),
(13, 'GilangMekanik', 'mekanik456', 'mekanik', 'Gilang Ramadhan', '087788990011', 'gilang.rama@bengkel.com', 1),
(14, 'HendraPelanggan', 'pelanggan456', 'pelanggan', 'Hendra Wijaya', '081211223344', 'hendra.w@mail.com', 1),
(15, 'IkaPelanggan', 'pelanggan456', 'pelanggan', 'Ika Sari', '085887766554', 'ika.sari@mail.com', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_pendapatan_bulanan`
-- (See below for the actual view)
--
CREATE TABLE `view_pendapatan_bulanan` (
`periode` varchar(7)
,`jumlah_reservasi` bigint
,`total_pendapatan` decimal(34,2)
);

-- --------------------------------------------------------

--
-- Structure for view `view_pendapatan_bulanan`
--
DROP TABLE IF EXISTS `view_pendapatan_bulanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_pendapatan_bulanan`  AS SELECT date_format(`r`.`tanggal`,'%Y-%m') AS `periode`, count(distinct `r`.`id`) AS `jumlah_reservasi`, coalesce(sum(`t`.`nominal`),0) AS `total_pendapatan` FROM (`reservasi` `r` left join `transaksi` `t` on(((`t`.`reservasi_id` = `r`.`id`) and (`t`.`status` = 'confirmed')))) WHERE (`r`.`status` = 'completed') GROUP BY date_format(`r`.`tanggal`,'%Y-%m') ORDER BY `periode` AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mekanik`
--
ALTER TABLE `mekanik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `kendaraan_id` (`kendaraan_id`),
  ADD KEY `mekanik_id` (`mekanik_id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservasi_id` (`reservasi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mekanik`
--
ALTER TABLE `mekanik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `kendaraan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `mekanik`
--
ALTER TABLE `mekanik`
  ADD CONSTRAINT `mekanik_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraan` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_3` FOREIGN KEY (`mekanik_id`) REFERENCES `mekanik` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_4` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`reservasi_id`) REFERENCES `reservasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
