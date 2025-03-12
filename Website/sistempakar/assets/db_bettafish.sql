-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Jan 2025 pada 15.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bettafish`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`) VALUES
(1, 'matthew', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `kode_gejala` varchar(10) NOT NULL,
  `nama_gejala` varchar(255) NOT NULL,
  `nilai_cf` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`, `nilai_cf`) VALUES
(1, 'G001', 'Sirip ikan cupang meguncup', 0.7),
(2, 'G002', 'Sirip ikan cupang rontok', 0.8),
(3, 'G003', 'Sirip ikan cupang terlihat robek dan rusak', 0.9),
(4, 'G004', 'Muncul bintik-bintik di tubuh ikan cupang', 0.6),
(5, 'G005', 'Ikan cupang sering bergerak menabrak dinding wadah', 0.5),
(6, 'G006', 'Muncul bintik-bintik emas/berkarat di tubuh ikan cupang', 0.7),
(7, 'G007', 'Pergerakan insang ikan cupang terlihat cepat', 0.6),
(8, 'G008', 'Sisik ikan cupang rontok secara berkala', 0.8),
(9, 'G009', 'Mata ikan cupang mulai membengkak', 0.9),
(10, 'G010', 'Mata ikan cupang terlihat berselaput putih', 0.8),
(11, 'G011', 'Muncul bercak darah di selaput mata', 0.7),
(12, 'G012', 'Bagian mulut terlihat pucat', 0.6),
(13, 'G013', 'Perut ikan cupang mulai membengkak', 0.7),
(14, 'G014', 'Ikan cupang tidak bisa membuang kotoran', 0.8),
(15, 'G015', 'Ikan cupang berenang miring', 0.7),
(16, 'G016', 'Insang ikan memerah dan tidak tertutup rapat', 0.8),
(17, 'G017', 'Ikan cupang cenderung dekat permukaan air', 0.6),
(18, 'G018', 'Kotoran ikan cupang memanjang', 0.5),
(19, 'G019', 'Ikan cupang sering diam/pasif', 0.7),
(20, 'G020', 'Tubuh ikan cupang terutama bagian perut terlihat seperti sisik nanas', 0.8),
(21, 'G021', 'Insang ikan jarang terbuka', 0.6),
(22, 'G022', 'Ikan cupang kurang aktif bergerak', 0.7),
(23, 'G023', 'Warna ikan cupang secara menyeluruh terlihat pucat', 0.7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_konsultasi`
--

CREATE TABLE `hasil_konsultasi` (
  `id_konsultasi` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `gejala_kategori` text NOT NULL,
  `hasil_diagnosa` text NOT NULL,
  `tanggal_diagnosa` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `kode_penyakit` varchar(10) DEFAULT NULL,
  `nama_penyakit` varchar(255) DEFAULT NULL,
  `gejala` text DEFAULT NULL,
  `penanganan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`, `gejala`, `penanganan`) VALUES
(1, 'P001', 'Sirip Busuk (Fin Rot)', 'Warna ikan cupang secara menyeluruh terlihat pucat, Ikan cupang sering diam/pasif, Sirip ikan cupang terlihat robek dan rusak, Sirip ikan cupang rontok', 'Gejala-gejala yang terlihat pada ikan cupang, seperti warna yang pucat, perilaku pasif, sirip yang robek dan rusak, serta sirip yang rontok, mengindikasikan kemungkinan infeksi atau stres yang disebabkan oleh faktor-faktor seperti penyakit, kualitas air yang buruk, atau cedera fisik. Kondisi ini memerlukan perhatian segera untuk mengatasi penyebabnya dan merawat ikan dengan baik.'),
(2, 'P002', 'Bintik Putih (White Spot)', 'Sirip ikan cupang meguncup, Ikan cupang sering bergerak menabrak dinding wadah, Muncul Bintik-bintik di tubuh ikan cupang, Ikan cupang kurang aktif bergerak, Warna ikan cupang secara menyeluruh terlihat pucat.', 'Jika ikan cupang menunjukkan gejala sirip meguncup, sering menabrak dinding wadah, bintik-bintik di tubuh, kurang aktif, dan warnanya pucat, segera isolasi ikan, perbaiki kualitas air (sesuaikan suhu dan pH), dan pastikan lingkungan bebas dari stres. Berikan pakan bergizi untuk mendukung pemulihan, dan gunakan obat yang tepat untuk mengatasi infeksi atau parasit. Jika kondisi tidak membaik, konsultasikan dengan ahli akuarium atau dokter ikan.'),
(3, 'P003', 'Bintik Emas (Velvet)', 'Sirip ikan cupang meguncup, Ikan cupang sering bergerak menabrak dinding wadah, Muncul bintik bintik emas/berkarat di tubuh ikan cupang, Pergerakan insang ikan cupang terlihat cepat, Sisik ikan cupang rontok secara berkala.', 'Jika ikan cupang menunjukkan gejala sirip meguncup, sering menabrak dinding wadah, muncul bintik-bintik emas/berkarat di tubuh, pergerakan insang yang cepat, dan sisik yang rontok secara berkala, segera isolasi ikan dan perbaiki kualitas air dengan menjaga suhu dan pH yang sesuai. Berikan pakan bergizi dan hindari faktor stres. Gunakan obat yang tepat untuk mengatasi infeksi atau parasit seperti *Velvet* (parasite Oodinium). Jika kondisi ikan tidak membaik, konsultasikan dengan ahli akuarium atau dokter ikan.'),
(4, 'P004', 'Mata Bengkak (Pop Eye)', 'Mata ikan cupang mulai membengkak, Mata ikan cupang terlihat berselaput putih, Muncul bercak darah di selaput mata, Bagian mulut terlihat pucat. Ikan cupang kurang aktif bergerak, Warna ikan cupang secara menyeluruh terlihat pucat', 'Jika ikan cupang menunjukkan gejala mata bengkak, berselaput putih, bercak darah di selaput mata, mulut pucat, kurang aktif bergerak, dan warnanya pucat, segera isolasi ikan untuk mencegah penyebaran infeksi. Perbaiki kualitas air dengan menjaga suhu dan pH yang sesuai. Berikan pakan bergizi untuk mendukung pemulihan. Gunakan obat untuk mengatasi infeksi bakteri atau parasit, seperti *Ich* atau infeksi mata. Jika kondisi ikan tidak membaik, segera konsultasikan dengan ahli akuarium atau dokter ikan.'),
(5, 'P005', 'Sisik Nanas (Dropsy)', 'Perut ikan cupang mulai membengkak,Ikan cupang tidak bisa membuang kotoran,Ikan cupang sering diam/pasif, Tubuh ikan cupang terutama bagian perut terlihat seperti sisik  nanas, Insang ikan jarang terbuka, Ikan cupang kurang aktif bergerak, Warna ikan cupang secara menyeluruh terlihat pucat.', 'Jika ikan cupang menunjukkan gejala perut membengkak, tidak bisa membuang kotoran, sering diam, tubuh bagian perut terlihat seperti sisik nanas, insang jarang terbuka, kurang aktif bergerak, dan warnanya pucat, ini bisa mengindikasikan infeksi internal atau masalah pencernaan. Segera isolasi ikan, perbaiki kualitas air dengan suhu dan pH yang sesuai, serta berikan pakan yang mudah dicerna. Gunakan obat untuk infeksi internal atau cacing parasit, dan pastikan untuk menghindari stres pada ikan. Jika kondisi tidak membaik, konsultasikan dengan dokter ikan atau ahli akuarium untuk diagnosis dan pengobatan lebih lanjut.'),
(6, 'P006', 'Kembung (Swim Bladder Disorder)', 'Ikan cupang tidak bisa membuang kotoran, Ikan cupang berenang miring, Kotoran ikan cupang memanjang, Ikan cupang kurang aktif bergerak.', 'Jika ikan cupang tidak bisa membuang kotoran, berenang miring, kotorannya memanjang, dan kurang aktif bergerak, ini bisa mengindikasikan masalah pencernaan atau infeksi parasit. Segera isolasi ikan untuk mencegah penyebaran, perbaiki kualitas air dengan menjaga suhu dan pH yang sesuai. Berikan pakan yang mudah dicerna, seperti cacing darah atau artemia. Gunakan obat untuk mengatasi infeksi parasit atau masalah pencernaan. Jika kondisi ikan tidak membaik, konsultasikan dengan dokter ikan atau ahli akuarium untuk diagnosis lebih lanjut.'),
(7, 'P007', 'Insang Memerah (inflamed Gills)', 'Sisik ikan cupang rontok secara berkala, Insang ikan memerah dan tidak tertutup rapat, Ikan cupang cenderung dekat permukaan air,', 'Jika ikan cupang menunjukkan gejala sisik rontok secara berkala, insang memerah dan tidak tertutup rapat, serta cenderung dekat permukaan air, kemungkinan ikan mengalami infeksi atau masalah dengan kualitas air, seperti kadar oksigen yang rendah atau infeksi bakteri. Segera isolasi ikan untuk mencegah penyebaran, perbaiki kualitas air dengan memastikan aerasi yang cukup dan menjaga suhu serta pH yang sesuai. Berikan pakan yang bergizi dan pastikan lingkungan bebas dari stres. Jika kondisi tidak membaik, gunakan obat yang sesuai untuk infeksi atau gangguan pernapasan, dan konsultasikan dengan dokter ikan jika diperlukan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `id_penyakit` int(11) DEFAULT NULL,
  `id_gejala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `id_penyakit`, `id_gejala`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 19),
(4, 1, 23),
(5, 2, 1),
(6, 2, 4),
(7, 2, 5),
(8, 2, 22),
(9, 2, 23),
(10, 3, 1),
(11, 3, 5),
(12, 3, 6),
(13, 3, 7),
(14, 3, 8),
(15, 3, 22),
(16, 4, 9),
(17, 4, 10),
(18, 4, 11),
(19, 4, 12),
(20, 4, 22),
(21, 4, 23),
(22, 5, 13),
(23, 5, 14),
(24, 5, 19),
(25, 5, 20),
(26, 5, 21),
(27, 5, 22),
(28, 5, 23),
(29, 6, 14),
(30, 6, 15),
(31, 6, 18),
(32, 6, 22),
(33, 7, 8),
(34, 7, 16),
(35, 7, 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`) VALUES
(19, 'stephanus saputra tupamahu', 'stephns.tpmhu@gmail.com', 'metyu1223'),
(21, 'matthew', 'metyutupamahu84@gmail.com', 'candil123'),
(24, 'zainal', 'zainal@gmail.com', 'zainal123');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indeks untuk tabel `hasil_konsultasi`
--
ALTER TABLE `hasil_konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `id_penyakit` (`id_penyakit`),
  ADD KEY `id_gejala` (`id_gejala`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `hasil_konsultasi`
--
ALTER TABLE `hasil_konsultasi`
  MODIFY `id_konsultasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `rule_ibfk_1` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`),
  ADD CONSTRAINT `rule_ibfk_2` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
