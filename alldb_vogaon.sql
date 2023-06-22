-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.4.27-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk vogaon
CREATE DATABASE IF NOT EXISTS `alancreative_vogaon` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `alancreative_vogaon`;

-- membuang struktur untuk table vogaon.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `users_code` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `total_price` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.carts: ~0 rows (lebih kurang)
INSERT INTO `carts` (`id`, `code`, `users_code`, `item_code`, `quantity`, `price`, `total_price`, `created_at`, `updated_at`) VALUES
	(6, 'CH-252023041107459280163', 'USERS1', 'b', 1, 1650000, 1650000, '2023-04-11 00:45:25', '2023-04-11 00:45:25');

-- membuang struktur untuk table vogaon.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.category: ~2 rows (lebih kurang)
INSERT INTO `category` (`id`, `category_name`, `category_code`, `created_at`, `updated_at`) VALUES
	(1, 'Mobile Game', 'MG', '2023-04-11 02:43:10', '2023-04-11 02:43:10'),
	(2, 'Voucher Game', 'VG', '2023-04-11 02:43:55', '2023-04-11 02:43:55');

-- membuang struktur untuk table vogaon.contact
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_code` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_image` varchar(255) DEFAULT NULL,
  `contact_url` varchar(255) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.contact: ~4 rows (lebih kurang)
INSERT INTO `contact` (`id`, `contact_code`, `contact_name`, `contact_image`, `contact_url`, `isActive`, `created_at`, `updated_at`) VALUES
	(1, 'whatsapp', 'WhatsApp', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26'),
	(2, 'telegram', 'Telegram', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26'),
	(3, 'email', 'Email', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26'),
	(4, 'message', 'Message', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26');

-- membuang struktur untuk table vogaon.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.failed_jobs: ~0 rows (lebih kurang)

-- membuang struktur untuk table vogaon.fields
CREATE TABLE IF NOT EXISTS `fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.fields: ~6 rows (lebih kurang)
INSERT INTO `fields` (`id`, `game_code`, `name`, `type`, `created_at`, `updated_at`) VALUES
	(1, 'LMC_ID', 'userid', 'string', '2023-04-13 03:04:03', '2023-04-13 03:04:03'),
	(2, 'MLBBD_ID', 'userid', 'string', '2023-04-13 03:04:03', '2023-04-13 03:04:03'),
	(3, 'MLBBD_ID', 'zoneid', 'number', '2023-04-13 03:04:03', '2023-04-13 03:04:03'),
	(4, 'MLBBS_ID', 'userid', 'string', '2023-04-13 03:04:03', '2023-04-13 03:04:03'),
	(5, 'MLBBS_ID', 'zoneid', 'number', '2023-04-13 03:04:03', '2023-04-13 03:04:03'),
	(6, 'FFD_ID', 'userid', 'string', '2023-04-13 03:04:03', '2023-04-13 03:04:03'),
	(7, 'HDC_ID', 'userid', 'string', '2023-04-13 03:04:03', '2023-04-13 03:04:03');

-- membuang struktur untuk table vogaon.games
CREATE TABLE IF NOT EXISTS `games` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `category_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.games: ~86 rows (lebih kurang)
INSERT INTO `games` (`id`, `img`, `title`, `code`, `category_code`, `created_at`, `updated_at`) VALUES
	(1, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565343343-icon-1548659712-icon-Mobile%20legend%20300x300%20px.png', 'Mobile Legends Diamonds', 'MLBBD_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(2, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565343258-icon-1548659712-icon-Mobile%20legend%20300x300%20px.png', 'Mobile Legends Starlight Member', 'MLBBS_ID', 'VG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(3, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1564563688-icon-1557979493-icon-1542812484-icon-1542778565-icon-1541579008-icon-Icon-300x300.jpg', 'Ragnarok Big Cat Coin', 'RO_COIN_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(4, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1553831479-icon-1553593202-icon-logo%20bleach.png', 'Bleach Kristal', 'BLEACHK_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(5, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565327748-icon-1551085770-icon-picturemessage_hif2b2up.gfh.png', 'Era Of Celestial Diamond', 'EOCD_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(6, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565327766-icon-1557980059-icon-1548927653-icon-Icon-1024.png', 'Love Nikki Diamond', 'LND_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(7, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1557992187-icon-eternal-city-logo.png', 'Eternal City Gem', 'EC_GEM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(8, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1557992480-icon-eternal-city-logo.png', 'Eternal City Monthly Card', 'EC_MC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(9, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1559276140-icon-speed-drifters-remark.jpg', 'Speed Drifters', 'GSDD_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(10, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1564458967-icon-1563952412-icon-higg.png', 'Higgs Domino Coins', 'HDC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(11, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565949768-icon-1557979538-icon-1544071208-icon-H45-Icon_直角%20(1).png', 'Rules Of Survival Diamond Mobile', 'ROSD_MOBILE_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(12, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565949762-icon-1557979987-icon-1548656495-icon-27459161_894915430675672_88606554974892711_n.png', 'Rules Of Survival Diamond PC', 'ROSD_PC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(13, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1565854756-icon-domino%20qiuqiu%2099%20icon300X300.png', 'Boyaa Domino Qiuqiu Koin', 'BDK_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(14, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1573638611-icon-icon.png', 'Lords Mobile', 'LMC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(15, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1566274292-icon-1562052922-icon-mangatoon-new.png', 'Manga Toon Coins', 'MGTC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(16, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1566276541-icon-ss-logo.png', 'Shining Spirit', 'SSD_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(17, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1570718795-icon-1569988040-icon-Copy%20of%201%20Unipin%20300x300.jpg', 'Call of Duty', 'CODCP_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(18, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1571976544-icon-300.png', 'Boyaa Poker Texas', 'BPK_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(19, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1573616951-icon-1564728125-icon-pb.png', 'Point Blank Cash', 'PBC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(20, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1560508508-icon-1559204633-icon-ss-youzu.png', 'Saint Seiya', 'SSC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(21, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1558923942-icon-1557979854-icon-1556523733-icon-laplace.jpg', 'Laplace M Spirals', 'ZL_SP_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(22, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1573626262-icon-be78a82b-0ccf-43b1-858e-d2f3e5f3dc33.jpg', 'Capsa City', 'CCI_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(23, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1572841169-icon-lod.png', 'Legacy of Discord-FuriousWings Diamonds', 'LODD_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(24, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1574072015-icon-life_after.jpg', 'Life After', 'LA_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(25, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1566905119-icon-1559273401-icon-au2.png', 'AU2 Mobile', 'AU2_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(26, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1578364095-icon-WhatsApp%20Image%202020-01-03%20at%2016.03.31.jpeg', 'Scroll Of Onmyoji', 'SO_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(27, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1579518101-icon-marvel-min.jpg', 'Marvel Super War', 'MSW_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(28, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1583122067-icon-WhatsApp%20Image%202020-02-27%20at%2014.09.26.jpeg', 'Crossing Void', 'CV_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(29, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1586751688-icon-unnamed.jpg', 'MU 2 Origin', 'MU2_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(30, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1587367952-icon-unnamed.png', 'Idle Legend', 'IL_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(31, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1588911637-icon-WeChat%20Image_20200508104803.png', 'Dragon Brawlers', 'IGGDB_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(32, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1595930073-icon-kov-logo.png', 'Knights of Valour', 'KOV_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(33, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1598850131-icon-lokapala.png', 'Lokapala Citrine', 'LP_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(34, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1635830311-icon-one%20punch%20man.jpg', 'One Punch Man', 'OPM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(35, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1602648207-icon-astral.jpg', 'Astral Guardian', 'AG_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(36, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1635829350-icon-1602655925-icon-dragon-raja.jpg', 'Dragon Raja Fund', 'ZDR_FUND_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(37, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1608113120-icon-1566291326-icon-snail-games-logo.png', 'Snail Games', 'SGC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(38, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1608270175-icon-heavensaga.jpg', 'Heaven Saga Crystal', 'HSC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(39, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1612925116-icon-WhatsApp%20Image%202021-02-08%20at%2010.22.53.jpeg', 'Omega Legends', 'IGGOL_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(40, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1613033470-icon-molatv.jpg', 'Mola TV Subscription Package', 'MTV_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(41, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1614852891-icon-logo.jpeg', 'Sin Tales', 'ST_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(42, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1623379600-icon-bulletangel_640x241-min%20(1).jpg', 'Bullet Angel', 'BA_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(43, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1635829664-icon-1625538035-icon-1625128892-icon-9a63d0817ee337a44e148854654a88fa144cfc6f2c31bc85f860f4a42c92019f_200.jpg', 'Genshin Impact', 'GHI_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(44, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1626249609-icon-1625564551-icon-unnamed.png', 'Mango Live', 'MOL_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(45, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1627965781-icon-icon-app-1-200x200.jpg', 'Cloud Song', 'CS_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(46, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1632474549-icon-WeChat%20Image_20210924111417.png', 'Sugar Live', 'SUGAR_LIVE_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(47, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1637304725-icon-1625128892-icon-9a63d0817ee337a44e148854654a88fa144cfc6f2c31bc85f860f4a42c92019f_200.jpg', 'Genshin Impact Crystal', 'GHI_CRY_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(48, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1637304797-icon-WeChat%20Image_20211119145247.png', 'Genshin Impact Blessing of Welkin Moon', 'GHI_BWM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(49, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1637577823-icon-placeholder-300x200.png', 'Sausage Man', 'SM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(50, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1639115684-icon-1586764089-icon-MU2.jpg', 'MU Origin 2 Badges', 'MU2B_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(51, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1639115575-icon-1586764089-icon-MU2.jpg', 'MU Origin 2 Diamonds', 'MU2D_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(52, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1644827962-icon-HE%20logo.jpg', 'Heroes Evolved Tokens', 'HEND_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(53, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1644834645-icon-placeholder-300x200.png', 'Hyper Front', 'HF_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(54, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1646726193-icon-1642561895-icon-black.jpg', 'Super SUS', 'SUPERSUS_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(55, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1648016378-icon-placeholder-300x200.png', 'Mirage: Perfect Skyline', 'MPS_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(56, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1651126871-icon-WeChat%20Image_20220422170624.jpg', 'Sky: Children of the Light', 'SCOL_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(57, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1652763114-icon-placeholder-300x200.png', 'Never After Diamonds', 'NAF_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(58, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1653901726-icon-black.jpg', 'Eudemons Online Tokens', 'EOND_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(59, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1655799412-icon-placeholder-300x200.png', 'YS 6', 'YS6_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(60, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1656510849-icon-black.jpg', 'Area Six', 'ASIX_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(61, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1657264149-icon-black.jpg', 'Dewa Domino', 'DEWADOM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(62, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1658295539-icon-unnamed.png', 'MU ORIGIN 3 Divine Diamonds', 'MU3_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(63, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1586883090-icon-1579164285-icon-tom_jerry-min%20(1).jpg', 'Tom and Jerry: Chase', 'TAJ_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(64, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1568963879-icon-1557979636-icon-1548649370-icon-AU%20Mobile%20(1).png', 'Audition Mobile', 'AU_MOBILE_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(65, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1569227213-icon-WhatsApp%20Image%202019-08-20%20at%206.24.52%20PM.jpeg', 'Audistar Mobile', 'AUDISTAR_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(66, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1594890968-icon-DCSID-iconapp-256x256.png', 'Samurai Era: Rise of Empires', 'SE_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(67, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1574649271-icon-ROH_LOGO%20(1).jpg', 'Ride Out Heroes Tokens', 'ROH_TOKENS_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(68, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1603424341-icon-UniPin_BG.jpg', 'Naruto YoYoo', 'NYYM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(69, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1564563688-icon-1557979493-icon-1542812484-icon-1542778565-icon-1541579008-icon-Icon-300x300.jpg', 'Ragnarok Zeny', 'RO_ZENY_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(70, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1635831827-icon-appicon_ob30.jpg', 'Free Fire', 'FFD_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(71, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1661447534-icon-cq1.png', 'JADE LEGENDS POINT', 'JADE_LEGENDS_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(72, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1661755174-icon-DWSEA_Icon%20App_200x200.png', 'Dinasty Warrior', 'DWM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(73, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1663058580-icon-sqrpop.png', 'City of Crime', 'COC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(74, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1665640074-icon-sqrpop.png', 'Time Raider', 'TRR_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(75, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1666606702-icon-sqrpop.png', 'Echocalypse', 'ECH_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(76, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1668487949-icon-harry_potter_logo.jpg', 'Harry Potter', 'HP_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(77, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1669714947-icon-bigo.png', 'Bigo', 'BIGO_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(78, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1669876710-icon-ML300x300.jpg', 'Manager League', 'ML_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(79, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1672116783-icon-20220822-EN34-Logo-RE1.png', 'Miko Era', 'ME_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(80, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1673497700-icon-icon.png', 'Dead Target', 'DT_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(81, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1675146300-icon-sqrpop.png', 'Ace Racer', 'AR_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(82, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1676344416-icon-smash_legends.jpg', 'Smash Legends Gem', 'SL_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(83, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1571382953-icon-chaos.png', 'Chaos Crisis', 'CC_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(84, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1676978636-icon-revelation.jpg', 'Revelation: Infinite Journey Jade', 'RIJG_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(85, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1676978679-icon-revelation.jpg', 'Revelation: Infinite Journey Pack', 'RIJP_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16'),
	(86, 'https://storage.googleapis.com/unipin-dev/images/icon_direct_topup_games/1677658519-icon-Solid_black.png', 'Dark Continent', 'DCM_ID', 'MG', '2023-04-11 02:36:16', '2023-04-11 02:36:16');

-- membuang struktur untuk table vogaon.games_item
CREATE TABLE IF NOT EXISTS `games_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `game_code` varchar(255) NOT NULL,
  `ag_code` varchar(255) DEFAULT NULL,
  `price` double NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `from` enum('apigames','unipin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.games_item: ~31 rows (lebih kurang)
INSERT INTO `games_item` (`id`, `code`, `title`, `game_code`, `ag_code`, `price`, `isActive`, `from`, `created_at`, `updated_at`) VALUES
	(1, 'a', 'Starlight Member with 4 Diamonds', 'MLBBS_ID', 'mobilelegend', 165000, 1, NULL, '2023-04-11 02:45:20', '2023-04-11 02:45:20'),
	(2, 'aa', 'Starlight Member with 193 Diamonds', 'MLBBS_ID', 'mobilelegend', 220000, 1, NULL, '2023-04-11 02:45:20', '2023-04-11 02:45:20'),
	(3, 'aaa', 'Starlight Member with 586 Diamonds', 'MLBBS_ID', 'mobilelegend', 330000, 1, NULL, '2023-04-11 02:45:20', '2023-04-11 02:45:20'),
	(4, 'aaaa', 'Starlight Member with 1411 Diamonds', 'MLBBS_ID', 'mobilelegend', 550000, 1, NULL, '2023-04-11 02:45:20', '2023-04-11 02:45:20'),
	(5, 'b', 'Starlight Member with 5408 Diamonds', 'MLBBS_ID', 'mobilelegend', 1650000, 1, NULL, '2023-04-11 02:45:20', '2023-04-11 02:45:20'),
	(6, 'UPMBL5', '5 Diamonds + 0 Bonus', 'MLBBD_ID', 'mobilelegend', 1650, 1, 'apigames', '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(7, 'bbb', '11 Diamonds + 1 Bonus', 'MLBBD_ID', 'mobilelegend', 3850, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(8, 'bbbb', '17 Diamonds + 2 Bonus', 'MLBBD_ID', 'mobilelegend', 6050, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(9, 'c', '25 Diamonds + 3 Bonus', 'MLBBD_ID', 'mobilelegend', 8000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(10, 'cc', '33 Diamonds + 3 Bonus', 'MLBBD_ID', 'mobilelegend', 11000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(11, 'ccc', '40 Diamonds + 4 Bonus', 'MLBBD_ID', 'mobilelegend', 13200, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(12, 'cccc', '67 Diamonds + 7 Bonus', 'MLBBD_ID', 'mobilelegend', 22000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(13, 'd', '53 Diamonds + 6 Bonus', 'MLBBD_ID', 'mobilelegend', 25132, 1, 'apigames', '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(14, 'dd', 'One Time Weekly Diamond', 'MLBBD_ID', 'mobilelegend', 29000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(15, 'ddd', '100 Percent Diamond Rebate', 'MLBBD_ID', 'mobilelegend', 46200, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(16, 'dddd', '154 Diamonds + 16 Bonus', 'MLBBD_ID', 'mobilelegend', 50600, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(17, 'e', '77 Diamonds + 8 Bonus', 'MLBBD_ID', 'mobilelegend', 53000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(18, 'ee', '167 Diamonds + 18 Bonus', 'MLBBD_ID', 'mobilelegend', 55000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(19, 'eee', '200 Diamonds + 22 Bonus', 'MLBBD_ID', 'mobilelegend', 66000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(20, 'eeee', '217 Diamonds + 23 Bonus', 'MLBBD_ID', 'mobilelegend', 71500, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(21, 'f', '333 Diamonds + 37 Bonus', 'MLBBD_ID', 'mobilelegend', 110000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(22, 'ff', '367 Diamonds + 41 Bonus', 'MLBBD_ID', 'mobilelegend', 121000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(23, 'fff', '256 Diamonds + 40 Bonus', 'MLBBD_ID', 'mobilelegend', 156000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(24, 'ffff', '503 Diamonds + 65 Bonus', 'MLBBD_ID', 'mobilelegend', 165000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(25, 'g', '1003 Diamonds + 156 Bonus', 'MLBBD_ID', 'mobilelegend', 330000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(26, 'gg', '774 Diamonds + 101 Bonus', 'MLBBD_ID', 'mobilelegend', 460000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(27, 'ggg', '1708 Diamonds + 302 Bonus', 'MLBBD_ID', 'mobilelegend', 550000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(28, 'gggg', '4003 Diamonds + 827 Bonus', 'MLBBD_ID', 'mobilelegend', 1320000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(29, 'h', '5003 Diamonds + 1047 Bonus', 'MLBBD_ID', 'mobilelegend', 1650000, 1, NULL, '2023-04-11 02:45:26', '2023-04-11 02:45:26'),
	(30, 'UPLM67', '67 Diamonds', 'LMC_ID', 'lordsmobile', 10000, 1, 'unipin', '2023-04-11 02:45:41', '2023-04-11 02:45:41'),
	(31, 'hhh', '134 Coins', 'LMC_ID', 'lordsmobile', 20000, 1, 'unipin', '2023-04-11 02:45:41', '2023-04-11 02:45:41');

-- membuang struktur untuk table vogaon.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.migrations: ~16 rows (lebih kurang)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_03_22_060703_create_sliders_table', 1),
	(6, '2023_03_23_022234_create_social_contact_table', 1),
	(7, '2023_03_23_031407_add_social_contact', 1),
	(8, '2023_03_24_044657_create_users_balance_table', 1),
	(9, '2023_03_24_044711_create_users_pin_table', 1),
	(10, '2023_03_27_055542_create_games_table', 1),
	(11, '2023_03_27_055558_create_category_table', 1),
	(12, '2023_03_28_025140_create_games_item_table', 1),
	(13, '2023_03_28_051025_create_cart_table', 1),
	(14, '2023_03_29_082840_create_contact_table', 1),
	(15, '2023_03_29_083039_add_contact', 1),
	(16, '2023_03_31_024326_create_fields_table', 1),
	(17, '2023_04_14_031207_create_payment_method_table', 2);

-- membuang struktur untuk table vogaon.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.password_resets: ~0 rows (lebih kurang)

-- membuang struktur untuk table vogaon.payment_method
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pm_code` varchar(255) NOT NULL,
  `pm_title` varchar(255) NOT NULL,
  `pm_logo` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.payment_method: ~4 rows (lebih kurang)
INSERT INTO `payment_method` (`id`, `pm_code`, `pm_title`, `pm_logo`, `from`, `created_at`, `updated_at`) VALUES
	(1, 'bca-va', 'BCA', 'bca.png', 'midtrans', '2023-04-14 03:23:54', '2023-04-14 03:23:54'),
	(2, 'bri-va', 'BRI', 'bri.png', 'midtrans', '2023-04-14 03:23:54', '2023-04-14 03:23:54'),
	(3, 'mandiri-va', 'MANDIRI', 'mandiri.png', 'midtrans', '2023-04-14 03:23:54', '2023-04-14 03:23:54'),
	(4, 'gopay', 'GOPAY', 'gopay.png', 'midtrans', '2023-04-14 03:23:54', '2023-04-14 03:23:54');

-- membuang struktur untuk table vogaon.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.personal_access_tokens: ~4 rows (lebih kurang)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'ardiris19@gmail.com', '850d919e8173ca12ac719f6bb5ee9055e8b00194355ca14eaafcf070caa8d747', '["*"]', '2023-04-11 00:11:15', '2023-04-10 19:40:34', '2023-04-11 00:11:15'),
	(2, 'App\\Models\\User', 1, 'ardiris19@gmail.com', '798a2ec49ccdf3bff9801ae6b9dd26ab88c9d980207f7b9cb7548211b31313be', '["*"]', '2023-04-11 00:12:49', '2023-04-10 21:40:00', '2023-04-11 00:12:49'),
	(3, 'App\\Models\\User', 1, 'ardiris19@gmail.com', '0abded7b646aa6f1b3a39c39e322034266dad07506dd673628c06d1871757ac9', '["*"]', '2023-04-11 02:09:37', '2023-04-11 00:21:17', '2023-04-11 02:09:37'),
	(4, 'App\\Models\\User', 1, 'ardiris19@gmail.com', 'e9f09e2ae441d8ec0df904e1abeee9722a8f5c60d3edc67a519cf2472f2ccc57', '["*"]', '2023-04-11 00:53:21', '2023-04-11 00:43:33', '2023-04-11 00:53:21'),
	(5, 'App\\Models\\User', 1, 'ardiris19@gmail.com', '53b3f6dddd712d95580de330a7bc9ce4c5f2b641cba6723cc31e658bd70c434c', '["*"]', '2023-04-14 02:46:00', '2023-04-12 19:14:09', '2023-04-14 02:46:00'),
	(6, 'App\\Models\\User', 1, 'ardiris19@gmail.com', '34d4ed2a54e9c344885152a6f6b16bd689fbb462c9cb7b3a4d4079ca3bd18cf4', '["*"]', '2023-04-17 00:55:39', '2023-04-16 18:14:40', '2023-04-17 00:55:39');

-- membuang struktur untuk table vogaon.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.sliders: ~3 rows (lebih kurang)
INSERT INTO `sliders` (`id`, `image`, `created_at`, `updated_at`) VALUES
	(2, 'https://cdnb.artstation.com/p/assets/images/images/014/473/061/large/rockspro-art-flayer-piggy-side2-rgb.jpg?1544099677', '2023-04-27 09:12:25', NULL),
	(3, 'https://lelogama.go-jek.com/cms_editor/2021/02/09/banner-blog-promo-cuan-google-play-games-0.jpg', '2023-04-27 09:13:02', NULL),
	(4, 'https://news.codashop.com/id/wp-content/uploads/2019/05/GENERAL-BANNER-CODA-730x280-1.jpg', '2023-04-27 09:13:03', NULL);

-- membuang struktur untuk table vogaon.social_contact
CREATE TABLE IF NOT EXISTS `social_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `social_contact_code` varchar(255) DEFAULT NULL,
  `social_contact_name` varchar(255) DEFAULT NULL,
  `social_contact_image` varchar(255) DEFAULT NULL,
  `social_contact_url` varchar(255) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.social_contact: ~3 rows (lebih kurang)
INSERT INTO `social_contact` (`id`, `social_contact_code`, `social_contact_name`, `social_contact_image`, `social_contact_url`, `isActive`, `created_at`, `updated_at`) VALUES
	(1, 'twitter', 'Twitter', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26'),
	(2, 'facebook', 'Facebook', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26'),
	(3, 'tiktok', 'Tiktok', NULL, NULL, 0, '2023-04-11 02:17:26', '2023-04-11 02:17:26'),
	(4, 'twitter', 'twitter', NULL, NULL, 0, '2023-04-11 02:53:22', '2023-04-11 02:53:22');

-- membuang struktur untuk table vogaon.transaction
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(50) DEFAULT NULL,
  `users_code` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'waiting',
  `total_amount` double DEFAULT 0,
  `subtotal` double DEFAULT 0,
  `fee` double DEFAULT 0,
  `voucher_discount` double DEFAULT 0,
  `voucher_code` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_url` text DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL COMMENT 'transaction from (midtrans etc)',
  `no_reference` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.transaction: ~2 rows (lebih kurang)
INSERT INTO `transaction` (`id`, `transaction_code`, `users_code`, `email`, `status`, `total_amount`, `subtotal`, `fee`, `voucher_discount`, `voucher_code`, `payment_method`, `transaction_url`, `from`, `no_reference`, `created_at`) VALUES
	(6, 'INV2301170151936172108635', 'USERS1', 'ardiris19@gmail.com', 'processing', 20000, 20000, 0, 0, NULL, 'mandiri-va', 'https://app.sandbox.midtrans.com/payment-links/1681696297877', 'unipin', 'INV2301170151936172108635', '2023-04-17 08:51:34'),
	(10, 'INV2307170750135684732350', NULL, 'rsqard@gmail.com', 'waiting', 10000, 10000, 0, 0, NULL, 'MANDIRI', 'https://app.sandbox.midtrans.com/payment-links/1681717836286', 'unipin', 'INV2307170750135684732350', '2023-04-17 14:50:34');

-- membuang struktur untuk table vogaon.transaction_detail
CREATE TABLE IF NOT EXISTS `transaction_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_code` varchar(50) DEFAULT NULL,
  `transaction_code` varchar(50) DEFAULT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `price` double DEFAULT 0,
  `qty` tinyint(4) DEFAULT 1,
  `total` double DEFAULT 0,
  `userid` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.transaction_detail: ~2 rows (lebih kurang)
INSERT INTO `transaction_detail` (`id`, `detail_code`, `transaction_code`, `item_code`, `price`, `qty`, `total`, `userid`, `username`, `created_at`, `updated_at`) VALUES
	(5, 'TRD-342023041701512214663', 'INV2301170151936172108635', 'hhh', 20000, 1, 20000, '123123', '12345678', '2023-04-17 08:51:34', '2023-04-17 12:56:13'),
	(9, 'TRD-342023041707503464370', 'INV2307170750135684732350', 'UPLM67', 10000, 1, 10000, NULL, '12345678', '2023-04-17 14:50:34', NULL);

-- membuang struktur untuk table vogaon.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `users_code` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `isSuspend` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `isSetPin` tinyint(1) NOT NULL DEFAULT 0,
  `memberType` tinyint(1) NOT NULL DEFAULT 1,
  `users_profile_pic` varchar(255) DEFAULT NULL,
  `email_verification_status` tinyint(1) NOT NULL DEFAULT 0,
  `no_telp` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `login_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.users: ~0 rows (lebih kurang)
INSERT INTO `users` (`id`, `name`, `users_code`, `email`, `email_verified_at`, `password`, `isSuspend`, `isActive`, `isSetPin`, `memberType`, `users_profile_pic`, `email_verification_status`, `no_telp`, `remember_token`, `login_by`, `created_at`, `updated_at`) VALUES
	(1, 'Risqi Ardiansyah', 'USERS1', 'ardiris19@gmail.com', NULL, '$2a$12$Lx8uEXYO9240dyPUEsgxTuRU2c9EHIkXyQvvqXjPW78D6uxNOMUta', 0, 1, 1, 1, NULL, 0, '088225146375', NULL, NULL, '2023-04-11 02:40:00', '2023-04-11 02:40:00');

-- membuang struktur untuk table vogaon.users_balance
CREATE TABLE IF NOT EXISTS `users_balance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `users_balance_code` varchar(255) NOT NULL,
  `users_code` varchar(255) NOT NULL,
  `users_balance` double NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.users_balance: ~0 rows (lebih kurang)
INSERT INTO `users_balance` (`id`, `users_balance_code`, `users_code`, `users_balance`, `created_at`, `updated_at`) VALUES
	(1, 'UB1', 'USERS1', 0, '2023-04-11 02:41:07', '2023-04-11 02:41:07');

-- membuang struktur untuk table vogaon.users_pin
CREATE TABLE IF NOT EXISTS `users_pin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `users_pin_code` varchar(255) DEFAULT NULL,
  `users_code` varchar(255) DEFAULT NULL,
  `users_pin` varchar(255) NOT NULL,
  `users_pin_attempts` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel vogaon.users_pin: ~0 rows (lebih kurang)
INSERT INTO `users_pin` (`id`, `users_pin_code`, `users_code`, `users_pin`, `users_pin_attempts`, `created_at`, `updated_at`) VALUES
	(1, 'PIN-002023041107268999391', 'USERS1', '$2y$10$rK4eP74OFS52r/bv54LHRuN8p.YxwDYcTXHeGFEJJ6V75txPhLf7q', 1, '2023-04-11 07:26:00', '2023-04-11 07:26:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
