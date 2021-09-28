-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 28 2021 г., 18:20
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `register-bd-laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `text`, `created_at`, `updated_at`) VALUES
(1, 1, '1 crknjerr', '2021-08-03 14:57:04', '2021-08-27 16:57:25'),
(2, 1, '2 dksbjehfjwgwgwwgykf', '2021-08-03 14:57:08', '2021-08-27 17:25:54'),
(3, 2, '3 ldbwe kakrw', '2021-08-03 14:57:41', '2021-08-03 14:57:55'),
(4, 2, '4 dskuf', '2021-08-03 14:57:45', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `comment_ads`
--

CREATE TABLE `comment_ads` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint NOT NULL,
  `ads_id` bigint NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comment_ads`
--

INSERT INTO `comment_ads` (`id`, `user_id`, `ads_id`, `text`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1 lfknng', '2021-09-20 12:20:13', NULL),
(2, 1, 1, '2 dksnlfnwlfe', '2021-09-20 12:20:20', NULL),
(3, 1, 2, '1 best ads', '2021-09-20 12:20:29', NULL),
(4, 1, 2, '2 kneflw', '2021-09-20 12:20:34', NULL),
(5, 1, 3, '1 lejknjjf', '2021-09-20 12:20:41', NULL),
(6, 1, 3, '2 ldnfjekfwe', '2021-09-20 12:20:49', NULL),
(7, 2, 1, '3 krjgne', '2021-09-20 12:22:26', NULL),
(8, 2, 1, '4 douhefw', '2021-09-20 12:22:31', NULL),
(9, 2, 2, '3 krgnreg', '2021-09-20 12:22:38', NULL),
(10, 2, 2, '4 iwqwuuwuquwwqwwq', '2021-09-20 12:22:45', NULL),
(11, 2, 3, '3 kbgkwegg', '2021-09-20 12:23:56', NULL),
(12, 2, 3, '4 sukhywfyuqwf', '2021-09-20 12:24:04', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(10, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(11, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(12, '2016_06_01_000004_create_oauth_clients_table', 2),
(13, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(14, '2021_07_27_125120_create_comments_table', 2),
(15, '2021_08_02_140132_create_sub_comments_table', 3),
(17, '2021_08_03_160733_create_parsings_table', 4),
(23, '2021_08_26_143902_create_comment_ads_table', 5),
(24, '2021_08_30_120347_create_sub_comment_ads_table', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `parsings`
--

CREATE TABLE `parsings` (
  `id` int UNSIGNED NOT NULL,
  `url_ads` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url_image` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `title_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  `year` bigint DEFAULT NULL,
  `type_of_fuel` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mileage` bigint DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `dates` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parsings`
--

INSERT INTO `parsings` (`id`, `url_ads`, `url_image`, `title_name`, `price`, `year`, `type_of_fuel`, `mileage`, `description`, `dates`, `updated_at`, `created_at`) VALUES
(1, 'https://www.olx.ua/d/obyavlenie/prodam-avtomobil-lanos-1-5-IDMJFt5.html#abc5269872;promoted', 'https://ireland.apollo.olxcdn.com:443/v1/files/nortmdaqzpfj3-UA/image;s=1200x1600', 'Продам автомобиль Ланос 1.5', 2700, 2008, 'Газ / бензин', 260000, 'Продам автомобиль Ланос. Объем двигателя 1,5. Состояние на фото. Есть кондиционер, электро стеклоподъёмники, усилитель руля. Стоимость 2700 без торга! Обмен не интересует!', '2021-09-18', NULL, '2021-09-20 15:00:24'),
(2, 'https://www.olx.ua/d/obyavlenie/srochno-prodam-lanos-IDMxmmE.html#abc5269872;promoted', 'https://ireland.apollo.olxcdn.com:443/v1/files/2y2avx1esvz9-UA/image;s=2000x1500', 'Срочно продам Ланос', 1999, 2008, 'Газ / бензин', 215000, '2008 год. Перебрана передняя подвеска.Едет хорошо.Коробка,двигатель без нареканий.Газ вписан в ТП. Без ДТП,местами притертости по кузову,ничего критичного. Магнитола с флешкой и громкой связью.ГУР,ЦЗ.Документы в полном порядке. Переоформление.', '2021-09-18', NULL, '2021-09-20 15:00:25'),
(3, 'https://www.olx.ua/d/obyavlenie/prodam-lanos-1-4-IDMLHWK.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/fl0wxxsznmkt1-UA/image;s=688x1416', 'Продам ланос 1.4', 2800, 2008, 'Газ / бензин', 192000, 'Состояние хорошее по желанию поменять лобовое стекло и правое крыло би ксенон в фарах и туманках', '2021-09-18', NULL, '2021-09-20 15:00:26'),
(4, 'https://www.olx.ua/d/obyavlenie/daewoo-lanos-1-5-IDMJI9L.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/cop42tur5cvh1-UA/image;s=1600x1200', 'Daewoo Lanos 1.5', 3500, 2008, 'Бензин', 175000, 'Продам ухоженный автомобиль, ТО производителось своевременно. Польская сборка. Двигатель (1.5) и кпп в отличном состоянии. Стоит 2дин магнитола, есть сигнализация. Газа нету и некогда не было. По кузову все ок, красить либо варить не нужно. Присутствует небольшой торг. Я 2владелец. Все интересующие вас вопросы по телефону.', '2021-09-14', NULL, '2021-09-20 15:00:27'),
(5, 'https://www.olx.ua/d/obyavlenie/lanos-lanos-1-5-deu-IDKywYT.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/c2nlfzq9sezn1-UA/image;s=1077x811', 'Lanos Ланос 1.5 деу', 4500, 2013, 'Бензин', 52000, 'Авто в отличном состоянии, без подкрасов , пробег родной - все видно по машине , газа нет и не было . Магнитола, стеклоподъёмники, двухсторонняя сигнализация. Только переоформление Без торга совсем .', '2021-09-14', NULL, '2021-09-20 15:00:28'),
(6, 'https://www.olx.ua/d/obyavlenie/prodam-daewoo-lanos-IDMHdcE.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/yitclj1ofqxx1-UA/image;s=1040x780', 'Продам Daewoo Lanos', 3600, 2008, 'Газ / бензин', 145, 'Отличное состояние. Кузов абсолютно целый и без ржавчины. Мотор, ходовая на отлично. Гидроусилитель руля. Газ-пропан(вписан в техпаспорт). По машине ничего делать не надо', '2021-09-10', NULL, '2021-09-20 15:00:29'),
(7, 'https://www.olx.ua/d/obyavlenie/lanos-lanos-deu-prodam-IDHj13p.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/6bo7q7tg6slm2-UA/image;s=1376x1032', 'Lanos Ланос деу продам', 4600, 2013, 'Бензин', 55000, 'Машина в супер состоянии, без подкрасов и т.п. . Кузов в идеале , двигатель и коробка опель . Пробег родной любые проверки .Салон как новый . Вложений не требует . Только переоформление . Газа нет и не было. Без торга!', '2021-08-30', NULL, '2021-09-20 15:00:30');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sub_comments`
--

CREATE TABLE `sub_comments` (
  `id` int UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_comment` int DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_sub_comment` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sub_comments`
--

INSERT INTO `sub_comments` (`id`, `text`, `id_comment`, `id_user`, `id_sub_comment`, `created_at`, `updated_at`) VALUES
(1, '2/1 l urwgr fw', 2, 2, NULL, '2021-08-03 14:58:04', NULL),
(2, '1/1 cbjwvyq', 1, 2, NULL, '2021-08-03 14:58:15', NULL),
(3, '4/1  fldnrbq21v8888', 4, 1, NULL, '2021-08-03 14:58:48', '2021-09-07 13:11:43'),
(4, '3/1 lsduger', 3, 1, NULL, '2021-08-03 14:58:56', NULL),
(5, '3/2 ldsugreg RRR', 3, 1, NULL, '2021-08-03 14:59:01', '2021-08-03 14:59:19'),
(6, '3/3 ldsnuggrczteqxwqpo', 3, 1, NULL, '2021-08-03 14:59:08', NULL),
(7, '1/1/1 ldueyq wtrdwf', 1, 1, 2, '2021-08-03 14:59:33', NULL),
(8, '1/1/2 dksyreer TTTa', 1, 1, 2, '2021-08-03 14:59:40', '2021-08-03 14:59:50'),
(9, '2/1/1 dsour', 2, 1, 1, '2021-08-03 15:00:03', NULL),
(10, '4/1/1 yewuvbchwe', 4, 2, 3, '2021-08-03 15:00:34', NULL),
(11, '3/3/1 dsugiergeg', 3, 2, 6, '2021-08-03 15:00:44', NULL),
(12, '3/3/2 lfdnuiergeh', 3, 2, 6, '2021-08-03 15:00:50', NULL),
(13, '3/1/1 ldgnure', 3, 2, 4, '2021-08-03 15:01:10', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_comment_ads`
--

CREATE TABLE `sub_comment_ads` (
  `id` bigint UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_comment` bigint NOT NULL,
  `id_user` bigint NOT NULL,
  `id_sub_comment` bigint DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sub_comment_ads`
--

INSERT INTO `sub_comment_ads` (`id`, `text`, `id_comment`, `id_user`, `id_sub_comment`, `created_at`, `updated_at`) VALUES
(1, '1.1 kjngjreg', 1, 2, NULL, '2021-09-20 12:22:06', NULL),
(2, '2.1 lngjkg', 2, 2, NULL, '2021-09-20 12:22:17', NULL),
(3, '2.1 kvjnr', 4, 2, NULL, '2021-09-20 12:22:59', NULL),
(4, '2.2. rkuhure', 4, 2, NULL, '2021-09-20 12:23:05', NULL),
(5, '1.1 ejkwyeyeywetwbnlkdmcsdfr', 3, 2, NULL, '2021-09-20 12:23:16', NULL),
(6, '1.1 ekeyiefnr', 5, 2, NULL, '2021-09-20 12:24:13', NULL),
(7, '2.1 keb xgwq', 6, 2, NULL, '2021-09-20 12:24:27', NULL),
(8, '1.1.1 lgrnmlreg', 1, 1, 1, '2021-09-20 12:25:32', NULL),
(9, '2.1.1 rkuryefbvjew', 2, 1, 2, '2021-09-20 12:25:47', NULL),
(10, '4.1 lngjeg', 8, 1, NULL, '2021-09-20 12:25:57', NULL),
(11, '3.1 ljewebx', 7, 1, NULL, '2021-09-20 12:26:08', NULL),
(12, '1.1.1 rjlllllllllllllllllllrjc', 3, 1, 5, '2021-09-20 12:26:41', NULL),
(13, '2.1.1 leufenw', 4, 1, 3, '2021-09-20 12:26:54', NULL),
(14, '3.1 nnnrbbxlekfopewfj', 9, 1, NULL, '2021-09-20 12:27:13', NULL),
(15, '4.1 kdbwyvuwqdhwqbfke', 10, 1, NULL, '2021-09-20 12:27:25', NULL),
(16, '1.1.1 lfnejbwytqu', 5, 1, 6, '2021-09-20 12:27:51', NULL),
(17, '4.1 ejcne', 12, 1, NULL, '2021-09-20 12:28:02', NULL),
(18, '3.1 bxvvrqtwekgkkmrg', 11, 1, NULL, '2021-09-20 12:28:17', NULL),
(19, '2.1.1 dcbeebyefu', 6, 1, 7, '2021-09-20 12:28:34', NULL),
(20, '3.1.1 vlrkngleg', 7, 2, 11, '2021-09-20 12:29:17', NULL),
(21, '3.1.2 djeuigeg', 7, 2, 11, '2021-09-20 12:29:25', NULL),
(22, '3.1.3 sgwcqfww', 7, 2, 11, '2021-09-20 12:29:33', NULL),
(23, '4.1.1 djkneuuhweyew', 8, 2, 10, '2021-09-20 12:29:47', NULL),
(24, '4.1.1 ljdnenk', 10, 2, 15, '2021-09-20 12:30:29', NULL),
(25, '3.1.1. ekjwenkwe', 9, 2, 14, '2021-09-20 12:30:40', NULL),
(26, '3.1.1 djnvbq', 11, 2, 18, '2021-09-20 12:31:06', NULL),
(27, '4.1.1 nhdwvqtfwflegreg', 12, 2, 17, '2021-09-20 12:31:24', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `avatar`) VALUES
(1, 'Anton', 'a@gmail.com', '2021-07-21 08:28:34', '$2y$10$G6H4VlM2M.JS84xHN9z0OO6ze8y7g/PboSjI8/UjQWPn.8WQSMPPu', NULL, '2021-07-21 08:28:22', '2021-07-21 08:28:34', '/storage/uploads/97LJY5G1IA630mNmUcWy8gnwPCes9iqQHPpjhsLk.jpg'),
(2, 'Boris', 'zavaleev.sbase@gmail.com', '2021-07-26 10:17:34', '$2y$10$u8KedlMko5FZX9ANf1liKeQlWWGFELIvTvxnZsnwgQ.wqNYZU9tEm', NULL, '2021-07-26 07:14:02', '2021-07-26 10:17:34', '/storage/uploads/1nT9rcEKK352t289H6vlz4WOASmEODHiGtM950Xv.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comment_ads`
--
ALTER TABLE `comment_ads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Индексы таблицы `parsings`
--
ALTER TABLE `parsings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `sub_comments`
--
ALTER TABLE `sub_comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub_comment_ads`
--
ALTER TABLE `sub_comment_ads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `comment_ads`
--
ALTER TABLE `comment_ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `parsings`
--
ALTER TABLE `parsings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `sub_comments`
--
ALTER TABLE `sub_comments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `sub_comment_ads`
--
ALTER TABLE `sub_comment_ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
