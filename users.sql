-- Adminer 4.8.1 MySQL 5.7.33 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ttd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `username`, `profile_image`, `jabatan`, `role`, `ttd`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Surya Sahputra',	'suryasahputra07@gmail.com',	'surya123',	'1768832051770345.jpg',	5,	'4',	'0',	NULL,	'$2y$10$JvrOj.Ppl.U1qx.5W5W9/uo9.vmKTgDwidZiPNAeXczJ94l8Ij7ku',	NULL,	'2023-02-25 23:14:42',	'2023-06-15 21:28:17'),
(2,	'Marliza,S.Pd.,M.Pd',	'kepsek@gmail.com',	'kepsek01',	'1768832037705245.jpg',	6,	'1',	'1768832037756817.png',	NULL,	'$2y$10$bQkQZl5PxaHmvVIyUuyWZuMrEuNGA5aZbQyeCef.f.XW3PyZ/4xg2',	NULL,	'2023-04-10 23:52:19',	'2023-06-15 21:28:04'),
(3,	'Ridafdal',	'Wakil@gmail.com',	'wakil',	'1768832021903682.JPG',	7,	'2',	'0',	NULL,	'$2y$10$GapT504bWfB6rM/4l1DK8.RbBI47wK4MxrzWqoispL41W4PHcv76y',	NULL,	'2023-04-11 08:00:17',	'2023-06-15 21:27:49'),
(4,	'Yasnimarlis',	'verifikator@gmail.com',	'verifikator',	'1768832002092560.JPG',	8,	'3',	'0',	NULL,	'$2y$10$5eHVCX7BRxbgyYiBoqZpn.HcUcQIaB/jtFXgK3CgsBsIHOoVBqABy',	NULL,	'2023-05-27 23:22:39',	'2023-06-15 21:27:30'),
(6,	'Amri J',	'wakil01@gmail.com',	'wakil01',	'1768832011865297.JPG',	7,	'2',	'0',	NULL,	'$2y$10$jd6g7MHVvcQPODCARL5xzuPoGuWx3h4ENJm3DbXbOYQbHqMJxsvQa',	NULL,	'2023-06-15 07:48:17',	'2023-06-15 21:27:39');

-- 2023-07-16 14:14:59
