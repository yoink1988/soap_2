-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 28 2017 г., 15:12
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `carshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `motor` decimal(3,2) NOT NULL,
  `speed` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `model`, `brand`, `year`, `motor`, `speed`, `color`, `price`) VALUES
(1, 'lanos', 'daewoo', 2004, '1.20', 220, 'red', '44239.20'),
(2, 'x4', 'bmw', 2010, '3.20', 260, 'black', '22363.30'),
(3, 'z4', 'bmw', 2011, '2.20', 240, 'blue', '33255.65'),
(4, '100', 'audi', 1998, '2.00', 220, 'white', '88315.20'),
(5, 'octavia', 'shkoda', 2001, '2.20', 220, 'black', '56221.00'),
(6, 'sandera', 'renault', 2010, '2.20', 230, 'white', '56233.20'),
(7, 'sandera', 'renault', 2011, '2.50', 230, 'red', '65442.20'),
(8, 'x5', 'bmw', 2010, '3.20', 230, 'white', '88652.21'),
(9, 'rapid', 'shkoda', 2010, '2.10', 220, 'white', '45287.33');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
