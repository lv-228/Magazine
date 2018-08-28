-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 01 2018 г., 17:05
-- Версия сервера: 10.1.30-MariaDB
-- Версия PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bd_bot`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clothes`
--

CREATE TABLE `clothes` (
  `id_clothes` int(11) NOT NULL,
  `name_clothes` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `clothes`
--

INSERT INTO `clothes` (`id_clothes`, `name_clothes`) VALUES
(1, 'футболка'),
(3, 'пуховик');

-- --------------------------------------------------------

--
-- Структура таблицы `fabric_structure`
--

CREATE TABLE `fabric_structure` (
  `id` int(11) NOT NULL,
  `structure_name` text COLLATE utf8_bin NOT NULL,
  `care` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `fabric_structure`
--

INSERT INTO `fabric_structure` (`id`, `structure_name`, `care`) VALUES
(1, 'Хлопок', 'Изделия из хлопка, которые разрешено подвергать кипячению, можно стирать в режиме “хлопок – 95\r\nградусов” в стиральной машинке, а цветной хлопок – при температуре 30-40 градусов. Для стирки цветной ткани нужно использовать стиральный порошок без отбеливающих составляющих, для белого хлопка можно\r\nиспользовать универсальное моющее средство. Пододеяльники перед стиркой нужно вывернуть и хорошо вытряхнуть. Скатерти, салфетки и кухонные полотенца, которые содержат большое количество жировых загрязнений лучше предварительно замочить, а затем стирать с порошком. Если хлопок пожелтел от времени и многократных стирок, то его можно отбелить с помощью специальных отбеливающих средств.\r\n\r\nГладить изделия из данного материала нужно хорошо разогретым утюгом, с увлажнением.\r\n\r\nХлопковые ткани обладают прочностью и стойкостью к воздействию высоких температур, а также прекрасно впитывают влагу. При стирке могут дать усадку.');

-- --------------------------------------------------------

--
-- Структура таблицы `firm`
--

CREATE TABLE `firm` (
  `id_firm` int(11) NOT NULL,
  `name_firm` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `firm`
--

INSERT INTO `firm` (`id_firm`, `name_firm`) VALUES
(1, 'nike');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `id_clothes` int(11) NOT NULL,
  `id_firm` int(11) NOT NULL,
  `id_season` int(11) NOT NULL,
  `color` text COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `fabric_structure` int(11) NOT NULL,
  `discription` text COLLATE utf8_bin NOT NULL,
  `new_price` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id_product`, `id_clothes`, `id_firm`, `id_season`, `color`, `price`, `fabric_structure`, `discription`, `new_price`) VALUES
(3, 1, 1, 2, 'Красный', 1000, 1, 'Красная футболка с логотипом на груди фирмы nike', 0),
(4, 3, 1, 1, 'Белый', 15000, 1, 'Белый теплый пуховик на зиму', 10000);

-- --------------------------------------------------------

--
-- Структура таблицы `season`
--

CREATE TABLE `season` (
  `id_season` int(11) NOT NULL,
  `name_season` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `season`
--

INSERT INTO `season` (`id_season`, `name_season`) VALUES
(1, 'Зима'),
(2, 'Лето');

-- --------------------------------------------------------

--
-- Структура таблицы `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `stock_text` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `stock`
--

INSERT INTO `stock` (`id`, `name`, `stock_text`) VALUES
(1, 'Акция 2+1', 'Купите две вещи одного типа (2 футболки или 2 кофты и т.п.) и третью получите в подарок!'),
(2, 'пуховик + зимняя обувь', 'Купите белый пуховик и получите скидку на покупку зимней обуви!');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`id_clothes`);

--
-- Индексы таблицы `fabric_structure`
--
ALTER TABLE `fabric_structure`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `firm`
--
ALTER TABLE `firm`
  ADD PRIMARY KEY (`id_firm`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_clothes` (`id_clothes`),
  ADD KEY `id_firm` (`id_firm`),
  ADD KEY `id_season` (`id_season`),
  ADD KEY `fabric_structure` (`fabric_structure`);

--
-- Индексы таблицы `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`id_season`);

--
-- Индексы таблицы `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `clothes`
--
ALTER TABLE `clothes`
  MODIFY `id_clothes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `fabric_structure`
--
ALTER TABLE `fabric_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `firm`
--
ALTER TABLE `firm`
  MODIFY `id_firm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `season`
--
ALTER TABLE `season`
  MODIFY `id_season` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_clothes`) REFERENCES `clothes` (`id_clothes`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`id_firm`) REFERENCES `firm` (`id_firm`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`id_season`) REFERENCES `season` (`id_season`),
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`fabric_structure`) REFERENCES `fabric_structure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
