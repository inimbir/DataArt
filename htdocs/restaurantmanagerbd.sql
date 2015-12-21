-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 20 2015 г., 15:44
-- Версия сервера: 10.0.17-MariaDB
-- Версия PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `restaurantmanagerbd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `labels`
--

CREATE TABLE `labels` (
  `id` int(11) NOT NULL,
  `idR` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `labels`
--

INSERT INTO `labels` (`id`, `idR`, `login`, `text`) VALUES
(3, 12, 'test', '123'),
(4, 13, 'test', '321'),
(5, 12, 'admin', '456'),
(6, 13, 'admin', '654');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `idR` int(11) NOT NULL,
  `filename` varchar(261) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `idR`, `filename`) VALUES
(16, 12, 'af4556247c0a021413164200016.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `review` varchar(1001) NOT NULL,
  `adress` varchar(150) NOT NULL,
  `ratingWhole` int(1) NOT NULL DEFAULT '0',
  `ratingKitchen` int(1) NOT NULL DEFAULT '0',
  `ratingInterier` int(1) NOT NULL DEFAULT '0',
  `ratingService` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `lat`, `lng`, `review`, `adress`, `ratingWhole`, `ratingKitchen`, `ratingInterier`, `ratingService`) VALUES
(12, 'Царский Дворец', 46.39878855774571, 30.717813670635223, 'Тут проживает самый красивый, милый, стройный, накачанный, забавный и главное скромный царь всего мира.', 'проспект Академіка Глушка, 24, Одеса, Одеська область, Украина', 4, 3, 4, 4),
(13, 'тест', 46.481934959986255, 30.719833374023438, 'текст рецензии.', 'вулиця 10-го Квітня, 10, Одеса, Одеська область, Украина', 3, 4, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `type`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'admi', '21232f297a57a5a743894a0e4a801fc3', 0),
(3, 'kooka', '202cb962ac59075b964b07152d234b70', 0),
(4, 'asd', '81dc9bdb52d04dc20036dbd8313ed055', 0),
(5, 'test', '202cb962ac59075b964b07152d234b70', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `labels`
--
ALTER TABLE `labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
