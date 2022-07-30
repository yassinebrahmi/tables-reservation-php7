DROP DATABASE IF EXISTS `restaurant`;
CREATE DATABASE `restaurant`;
USE `restaurant`;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(50) NOT NULL DEFAULT '0',
  `desc` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `ref`, `desc`, `photo`) VALUES
	(1, 'FRN', 'French table service', 'images/french.jpg'),
	(2, 'AMR', 'American table service', 'images/american.jpg'),
	(3, 'SLV', 'Silver table service', 'images/silver.jpg'),
	(4, 'RUS', 'Russian table service', 'images/russian.jpg'),
	(5, 'FIL', 'Filipino table service', 'images/filipino.jpg');

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `many_people` int(11) DEFAULT NULL,
  `day` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `special_request` text,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Accept','Refuse','Waiting') DEFAULT 'Waiting',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placement` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO `tables` (`id`, `placement`, `category_id`, `description`, `guests`, `created_by`, `created_at`) VALUES
	(3, 'B', 1, 'sdfdf sdfsd fsd fsd fsdf', 10, 1, '2021-08-04 22:51:13'),
	(4, 'A', 1, 'testffffffff', 4, 1, '2021-08-04 22:47:15'),
	(5, 'B', 2, 'test', 4, 1, '2021-07-26 16:57:09'),
	(8, 'A', 1, 'test', 4, 1, '2021-07-27 14:29:02'),
	(9, 'B', 1, 'test', 8, 1, '2021-07-27 14:29:09'),
	(10, 'B', 3, 'test', 8, 1, '2021-07-27 14:29:15'),
	(11, 'D', 5, 'test ajax', 2, 1, '2021-08-04 22:50:04'),
	(12, 'D', 4, '', 20, 1, '2021-07-31 15:45:35'),
	(14, 'A', 3, 'testghjghj', 12, 1, '2021-08-03 23:20:58'),
	(15, 'A', 1, 'test', 4, 1, '2021-08-04 22:32:32'),
	(16, 'B', 5, 'test', 20, 1, '2021-08-04 22:32:50'),
	(18, 'C', 2, 'testttt', 10, 1, '2021-08-04 22:50:57');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `profil` enum('Administrator','User') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `password`, `name`, `profil`, `created_by`, `created_at`) VALUES
	(1, 'admin', 'lb+o0gSWmuJmLAPWcGh0mw==', 'Bintashah Hasan', 'Administrator', 1, '2021-08-04 01:26:27');

ALTER TABLE tables
ADD FOREIGN KEY (category_id) REFERENCES categories(id)  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE reservations
ADD FOREIGN KEY (table_id) REFERENCES tables(id)  ON DELETE CASCADE ON UPDATE CASCADE;