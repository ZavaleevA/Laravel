-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 14 2021 г., 18:13
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
-- Структура таблицы `parse_olx`
--

CREATE TABLE `parse_olx` (
  `id` int UNSIGNED NOT NULL,
  `url_ads` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url_image` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `title_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `price` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `year` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type_of_fuel` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mileage` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `date` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parse_olx`
--

INSERT INTO `parse_olx` (`id`, `url_ads`, `url_image`, `title_name`, `price`, `year`, `type_of_fuel`, `mileage`, `description`, `date`) VALUES
(1, 'https://www.olx.ua/d/obyavlenie/avtomobil-deo-sens-2011-IDLknjv.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/x19z0vqsuyd21-UA/image;s=1000x750', 'Автомобиль Део Сенс 2011', '3 200 $', 'Год выпуска: 2011 ', 'Вид топлива: Бензин', 'Пробег: 146 000 км', 'Део Сенс 2011г. Бензин.Пробег 146000. Машина на ходу, серьезных вложений не требует.', 'Сегодня в 09:37'),
(2, 'https://www.olx.ua/d/obyavlenie/prodam-daewoo-lanos-1-5-IDMaj8V.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/189r5esk6cgf1-UA/image;s=2000x1500', 'Продам Daewoo Lanos 1,5', '3 000 $', 'Год выпуска: 2008 ', 'Вид топлива: Газ / бензин', 'Пробег: 165 000 км', 'Продам Ланос 2008 года, 1,5л, на полном ходу. Машина в рабочем состоянии, есть кондиционер и гидроусилитель руля, передние стеклоподъёмники, все работает исправно. Стоит новый аккумулятор, радиатор кондиционера, заменены задние пружины, амортизаторы, прокладка ГБЦ, свечи. Стоит практически новая зимняя резина. На сиденьях новые чехлы. Газ 2го поколения, работает исправно. По кузову есть дефекты, видно на фото. Возможен торг', '13 июля 2021 г.'),
(3, 'https://www.olx.ua/d/obyavlenie/deo-lanos-polyak-deal-IDKypIY.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/njpjkg51nj301-UA/image;s=1500x2000', 'Део Ланос поляк - ідеал', '4 500 $', 'Год выпуска: 2008 ', 'Вид топлива: Газ / бензин', 'Пробег: 65 000 км', 'Авто в гарному стані, обслуговується для сім\'ї,  замінено всі розходні матеріали, резина нова на 14 зима, літо на окремих дисках, салон ідеал нові чохли! Деталі за телефоном 06********47', '10 июля 2021 г.'),
(4, 'https://www.olx.ua/d/obyavlenie/prodam-deo-lanos-2008-goda-v-otlichnom-sost-IDM966U.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/plrz3uzvsgkq-UA/image;s=1000x750', 'Продам Део Ланос 2008 года,в отличном сост', '3 000 $', 'Год выпуска: 2008 ', 'Вид топлива: Газ / бензин', 'Пробег: 190 000 км', 'Продам Ланос 2008 года,польской сборки,в отличном сост.Кузов не бит,без ржавчины,вмятин и царапин.Техника обслужена,мотор работает хорошо,не дымит,масла не ест.установлен газ 4 поколения,работает отлично,вписан.Сигнализация,тонировка в круг.стеклоподъемники,гидрач.Электрика вся исправна.По документам переоформления в мрео,торг у капота.', '10 июля 2021 г.'),
(5, 'https://www.olx.ua/d/obyavlenie/deo-lanos-daewoo-lanos-IDLSbUw.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/j8wq5ntyvysk-UA/image;s=1600x1200', 'Део Ланос Daewoo Lanos', '3 500 $', 'Год выпуска: 2011 ', 'Вид топлива: Газ / бензин', 'Пробег: 69 000 км', 'Продам Ланос, 2011, двигатель 1,5, гидроусилитель, стеклоподъемники, кондиционер заправлен, хорошая резина, тонировка. \r\n Кузов без рыжиков, гнили, подкасов и тому подобное. пробег реальный, газ 4 поколение пропан. Ланос состояние идеал 5/5, полностью обслужена, без вложений.\r\n \r\n Продаю по ТП\r\n Возможен обмен на бляху в таком же состоянии под растаможку', '09 июля 2021 г.'),
(6, 'https://www.olx.ua/d/obyavlenie/remont-avtomobiley-IDM4az0.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/sdfzgxoud3651-UA/image;s=3024x4032;r=90', 'Ремонт автомобилей', '3 000 $', 'Год выпуска: 2010 ', 'Вид топлива: Бензин', 'Пробег: 69 000 км', 'Выполняем ремонт и обслуживание. Ходовая часть .Тормозная система.Замена масел жидкости и фильтров.Замена ремней навесного и ГРМ и многое другое звоните.', '01 июля 2021 г.'),
(7, 'https://www.olx.ua/d/obyavlenie/lanos-lanos-deu-prodam-IDHj13p.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/6bo7q7tg6slm2-UA/image;s=1376x1032', 'Lanos Ланос деу продам', '4 600 $', 'Год выпуска: 2013 ', 'Вид топлива: Бензин', 'Пробег: 55 000 км', 'Машина в  супер состоянии, без подкрасов и т.п. . Кузов в идеале , двигатель и коробка опель . \r\n Пробег родной любые проверки .Салон как новый .\r\n Вложений не требует . Только переоформление .\r\n Газа нет и не было.\r\n Без торга!', '30 июня 2021 г.'),
(8, 'https://www.olx.ua/d/obyavlenie/prodam-daewoo-lanos-IDLEBuk.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/aikomu43h4ww2-UA/image;s=1062x1416', 'Продам Daewoo Lanos', '3 000 $', 'Год выпуска: 2011 ', 'Вид топлива: Бензин', 'Пробег: 140 000 км', 'Продам Део Ланос, новая резина, гидроуселитель руля, есть нюансы по кузову все вопросы по тел.', '20 июня 2021 г.'),
(9, 'https://www.olx.ua/d/obyavlenie/prodam-deo-lanos-lanos-IDJQt6o.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/a3fmvir0jgcc3-UA/image;s=1745x1560', 'Продам Део Ланос Lanos', '3 500 $', 'Год выпуска: 2011 ', 'Вид топлива: Газ / бензин', 'Пробег: 67 000 км', 'Продам Ланос 2011, гидроусилитеть, электростеклоподъемники, новый АКБ, хорошая резина. Без рыжиков, гнили, подкасов и тому подобное. пробег реальный, газ 4 поколение пропан. Ланос состояние идеал 5/5, \r\n Продаю по ТП', '19 июня 2021 г.'),
(10, 'https://www.olx.ua/d/obyavlenie/prodam-lanos-1-6-16v-IDLV7zl.html#abc5269872', 'https://ireland.apollo.olxcdn.com:443/v1/files/3u51zb2mve6i2-UA/image;s=1040x780', 'Продам Lanos 1.6 16V', '3 700 $', 'Год выпуска: 2009 ', 'Вид топлива: Газ / бензин', 'Пробег: 132 000 км', 'Отличное состояние. Кузов без дтп, без ржавчины.Газ евро4. Гидроусилитель руля. Мотор 1.6 16клапаный ра ботает отлично как на газу так и на бензине. Ухоженый салончик', '16 июня 2021 г.');

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
-- Индексы таблицы `parse_olx`
--
ALTER TABLE `parse_olx`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT для таблицы `parse_olx`
--
ALTER TABLE `parse_olx`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
