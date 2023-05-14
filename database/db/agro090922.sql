-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 09 2022 г., 15:06
-- Версия сервера: 5.5.68-MariaDB
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `agro`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auctions`
--

CREATE TABLE IF NOT EXISTS `auctions` (
  `id` bigint(20) unsigned NOT NULL,
  `type` enum('rise','drop','sale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_material` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_analog` int(1) NOT NULL,
  `size` float NOT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `over_date` timestamp NULL DEFAULT NULL,
  `delivery_date` date NOT NULL,
  `delivery_condition` int(11) NOT NULL,
  `delivery_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_condition` int(11) NOT NULL,
  `special_terms` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_ogrn` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_bank_account` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_correspondent_account` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_bank_bik` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_warehouse_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_ogrn` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_bank_account` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_correspondent_account` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_bank_bik` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_warehouse_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0 - отменен, 1 - активный, 2 - завершен',
  `customer_confirm` int(1) NOT NULL DEFAULT '0',
  `customer_contract_files` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_confirm` int(1) NOT NULL DEFAULT '0',
  `supplier_contract_files` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `win_rate_id` int(11) DEFAULT NULL,
  `subdivision_id` int(11) NOT NULL DEFAULT '1',
  `org_id` int(11) NOT NULL DEFAULT '2',
  `cancel_reason` text COLLATE utf8mb4_unicode_ci,
  `exclude_analogs` text COLLATE utf8mb4_unicode_ci,
  `start_price` float DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3531 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `auctions`
--

INSERT INTO `auctions` (`id`, `type`, `user_id`, `title`, `active_material`, `is_analog`, `size`, `unit`, `over_date`, `delivery_date`, `delivery_condition`, `delivery_region`, `payment_condition`, `special_terms`, `customer_ogrn`, `customer_bank_account`, `customer_correspondent_account`, `customer_bank_bik`, `customer_warehouse_address`, `supplier_ogrn`, `supplier_bank_account`, `supplier_correspondent_account`, `supplier_bank_bik`, `supplier_warehouse_address`, `photo`, `status`, `customer_confirm`, `customer_contract_files`, `supplier_confirm`, `supplier_contract_files`, `win_rate_id`, `subdivision_id`, `org_id`, `cancel_reason`, `exclude_analogs`, `start_price`, `created_at`, `updated_at`) VALUES
(2, 'drop', 39, 'Пластик', '0', 1, 1, 'кг.', '2021-03-13 20:59:59', '2021-03-28', 1, NULL, 1, NULL, '1047796209339', '40702810201600002671', '30101810200000000593', '044525593', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, '["\\u0410\\u0431\\u0430\\u043a\\u0443\\u0441 \\u041f\\u0440\\u0430\\u0439\\u043c, \\u0421\\u042d","\\u0410\\u0431\\u0430\\u043a\\u0443\\u0441 \\u0423\\u043b\\u044c\\u0442\\u0440\\u0430, \\u0421\\u042d","\\u0410\\u0431\\u0438\\u0433\\u0430-\\u041f\\u0438\\u043a, \\u0412\\u0421"]', 0, '2021-03-04 22:12:14', '2021-12-05 11:32:26'),
(3, 'drop', 39, 'ВЕРТИМЕК®, КЭ (18 г/л)', '', 0, 9, 'л.', '2021-03-26 20:59:58', '2021-04-30', 2, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-07 17:13:47', '2021-04-20 10:25:26'),
(4, 'drop', 55, 'Айвенго, КЭ', '', 0, 400, 'л.', '2021-04-12 20:59:58', '2021-04-11', 2, '', 1, 'г. Смоленск', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-09 20:01:37', '2021-04-20 10:25:26'),
(5, 'drop', 55, 'Риманол, ВДГ', '250 г/кг римсульфурона', 1, 5.5, 'кг.', '2021-04-10 20:59:58', '2021-04-25', 3, '', 1, 'Брянск', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-09 20:44:20', '2021-04-20 10:25:26'),
(6, 'drop', 55, 'Ламадор, КС', 'Протиоконазол + тебуконазол', 0, 100, 'л.', '2021-04-07 20:59:58', '2021-04-14', 2, '', 1, 'г. Кострома', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-09 20:45:43', '2021-04-28 08:49:24'),
(7, 'drop', 55, 'Нужен мешок удобрений', 'Пестициды', 1, 100, 'кг.', '2021-04-01 20:59:58', '2021-04-03', 1, '', 1, 'Мешок должен быть завязан фиолетовым бантиком.', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-09 22:21:42', '2021-04-20 10:25:26'),
(8, 'drop', 55, 'ПЛЕНУМ®, ВДГ', '', 0, 50, 'л.', '2021-04-01 20:59:58', '2021-04-30', 2, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-10 07:55:16', '2021-04-20 10:25:26'),
(9, 'drop', 39, 'Фундазол', 'Беномил 500г/кг', 1, 10, 'кг.', '2021-03-23 20:59:58', '2021-04-08', 1, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-18 06:39:04', '2021-04-28 08:49:38'),
(10, 'drop', 55, 'Максим, КС', 'Флудиоксонил', 0, 20, 'л.', '2021-03-19 20:59:58', '2021-04-09', 1, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-18 07:51:24', '2021-04-28 08:49:56'),
(11, 'drop', 55, 'тайфун', 'глифосат 360 г/л', 1, 1000, 'л.', '2021-03-29 20:59:58', '2021-04-11', 2, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-21 09:56:31', '2021-04-20 10:25:26'),
(12, 'drop', 240, 'Средство', '0', 1, 500, 'л.', '2021-03-22 13:59:59', '2021-04-30', 1, NULL, 1, 'Особые условия', '123123123123123', '12312312312312312123', '12341234123412341234', '243523523', 'ул. 11-ая Текстильщиков, д. 2, кв. 16', '1175027030200', '40702810401600007447', '30101810200000000593', '044525593', '962 Simmental st', NULL, 2, 1, '["2021\\/\\u0414\\u043e\\u0433\\u043e\\u0432\\u043e\\u0440 \\u043f\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0438 \\u2116\\u042d\\u0422\\u041f-12 \\u043e\\u0442 \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u044f 1.52b.pdf"]', 1, '', 30, 1, 2, NULL, 'null', 0, '2021-03-21 12:44:15', '2022-05-24 11:21:28'),
(14, 'drop', 74, '«Майстер, ВДГ»', '-', 0, 36, 'кг.', '2021-03-24 20:59:58', '2021-04-22', 1, '', 1, 'нет', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-22 05:38:26', '2021-04-28 08:48:50'),
(15, 'drop', 39, '«Консенто, КС»', 'Пропамокарб гидрохлорид – 375 г/л, фенамидон – 75 г/л.', 1, 840, 'л.', '2021-03-26 20:59:58', '2021-04-29', 2, '', 1, '-', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-22 05:44:03', '2021-04-28 08:48:29'),
(16, 'drop', 51, '«Линтур, ВДГ»', '-', 0, 30, 'кг.', '2021-03-27 20:59:58', '2021-04-15', 3, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-22 05:47:01', '2021-04-28 08:45:14'),
(17, 'drop', 94, 'Гранстар', 'Трибенурон-метил', 0, 100, 'кг.', '2021-04-25 20:59:58', '2021-05-10', 2, '', 1, 'товар 2020 года выпуска.', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-24 08:37:04', '2021-04-20 10:25:26'),
(18, 'drop', 99, 'гренери', 'трибенурон', 1, 135, 'кг.', '2021-04-26 20:59:58', '2021-04-30', 2, '', 1, 'в коробках', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-26 07:36:15', '2021-04-20 10:25:26'),
(19, 'drop', 99, 'грэнери', 'трибенурон-метил', 1, 135, 'кг.', '2021-04-26 20:59:58', '2021-04-15', 2, '', 1, 'оплата по договорённости', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-26 07:48:22', '2021-04-20 10:25:26'),
(20, 'drop', 99, 'грэнери', 'трибенурон-метил', 1, 135, 'кг.', '2021-04-16 20:59:58', '2021-04-25', 2, '', 1, 'оплата по договорённости', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-26 10:54:48', '2021-09-30 11:30:16'),
(21, 'drop', 94, 'Гранстар Мега', 'трибенурон-метил + тифенсульфурон-метил', 0, 100, 'кг.', '2021-04-24 20:59:58', '2021-05-10', 2, '', 1, 'товар 2020 года выпуска', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-29 05:22:22', '2021-04-20 10:25:26'),
(22, 'drop', 138, 'селитра', 'любая', 1, 100, 'кг.', '2021-05-01 20:59:58', '2021-05-10', 2, '', 1, 'продукт качественный, изготовлен 2020', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-30 04:41:48', '2021-06-18 05:57:04'),
(23, 'drop', 142, 'гренэри', 'трибенурон-метил', 1, 110, 'кг.', '2021-05-01 20:59:58', '2021-05-14', 2, '', 1, 'Качественный, не подделка.', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-03-30 11:13:01', '2021-04-29 16:09:50'),
(24, 'drop', 143, 'Гренэри', 'Трибенурон-метил', 1, 10, 'л.', '2021-05-01 20:59:58', '2021-04-30', 1, '', 1, NULL, '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, 'Отпала потребность в препарате', NULL, 0, '2021-04-01 04:18:24', '2021-12-06 11:57:25'),
(25, 'drop', 144, 'Максим плюс КС', 'Флудиоксонил+дифеноконазол', 1, 75, 'л.', '2021-05-06 20:59:58', '2021-04-22', 2, '', 1, 'Товар качественный, товар 2020 года выпуска', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-04-01 06:09:06', '2021-04-21 07:25:23'),
(26, 'drop', 146, 'селитра', 'нитрат амония', 1, 100000, 'кг.', '2021-05-26 20:59:58', '2021-06-09', 2, '', 1, 'Производства 2020 года', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-04-01 07:59:01', '2021-04-20 10:25:26'),
(27, 'drop', 147, 'Евро-Лайтнинг, ВРК', 'любое', 1, 10, 'л.', '2021-04-13 20:59:58', '2021-04-20', 2, '', 1, 'нет', '', '', '', '', '', '', '', '', '', '', NULL, 0, 0, '', 0, '', NULL, 1, 2, NULL, NULL, 0, '2021-04-02 08:14:09', '2021-04-20 10:25:26'),
(28, 'drop', 147, 'Евро-Лайтинг, В�