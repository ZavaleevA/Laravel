-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 12 2021 г., 17:41
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
-- База данных: `register-bd1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int UNSIGNED NOT NULL,
  `comment` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_c` datetime NOT NULL,
  `user_id` int NOT NULL,
  `date_edit` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `comment`, `date_c`, `user_id`, `date_edit`) VALUES
(1, '1 ksngre', '2021-07-12 17:35:42', 2, NULL),
(2, '2 slnjrer', '2021-07-12 17:35:46', 2, NULL),
(3, '3 lknthltr', '2021-07-12 17:36:12', 1, NULL),
(4, '4 sjrghkre', '2021-07-12 17:36:15', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `reply_comment`
--

CREATE TABLE `reply_comment` (
  `id_reply` int UNSIGNED NOT NULL,
  `reply_comment` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_comment` int DEFAULT NULL,
  `id_sub_comment` int DEFAULT NULL,
  `id_reply_user` int NOT NULL,
  `date_reply` datetime NOT NULL,
  `edit_date_reply` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reply_comment`
--

INSERT INTO `reply_comment` (`id_reply`, `reply_comment`, `id_comment`, `id_sub_comment`, `id_reply_user`, `date_reply`, `edit_date_reply`) VALUES
(1, '2.1 osngr', 2, NULL, 1, '2021-07-12 17:36:22', NULL),
(2, '1.2 skbfew', 1, NULL, 1, '2021-07-12 17:36:33', '2021-07-12 17:36:41'),
(3, '4.1 fdkjr', 4, NULL, 2, '2021-07-12 17:37:34', NULL),
(4, '3.1 dlsjnrhg', 3, NULL, 2, '2021-07-12 17:37:39', NULL),
(5, '1.2.1 ldfljrehrthrge', NULL, 2, 2, '2021-07-12 17:39:03', '2021-07-12 17:39:10'),
(6, '2.1.1 dmrohrt', NULL, 1, 2, '2021-07-12 17:39:33', NULL),
(7, '4.1.1 sdsqq1124', NULL, 3, 1, '2021-07-12 17:40:23', NULL),
(8, '3.1.1 lsnurg', NULL, 4, 1, '2021-07-12 17:40:30', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `surname` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(105) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hash` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL,
  `avatar` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `pass`, `hash`, `email_confirmed`, `avatar`) VALUES
(1, 'Anton', 'Antonio', 'arsentii2278@gmail.com', '94d550448b90ce1afb7ccd31652729d0', '9c567d776b9f9082dda219114ad0f883', 0, '/photo/cat.jpg'),
(2, 'Dan', 'Danov', 'arsentii2278@gmail.com', '68da59fbe8da0d504d56a453646dd1e9', '618692a00de20b7a6ff73e92b38434b0', 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `reply_comment`
--
ALTER TABLE `reply_comment`
  ADD UNIQUE KEY `id_reply` (`id_reply`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `reply_comment`
--
ALTER TABLE `reply_comment`
  MODIFY `id_reply` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
