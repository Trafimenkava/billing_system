-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 26 2018 г., 23:45
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `billing_system`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` float NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `fk_to_services_idx` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`account_id`, `balance`, `service_id`) VALUES
(2, 0, 1),
(3, 19.39, 10),
(6, 0, 13),
(7, 0, 14),
(8, 0, 15),
(9, 0, 16),
(10, 0, 17),
(11, 0, 18);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL,
  `passport_number` varchar(100) DEFAULT NULL,
  `birthday_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `status` enum('Активный','Заблокированный','Неактивный') NOT NULL DEFAULT 'Неактивный',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`client_id`, `passport_number`, `birthday_date`, `address`, `card_number`, `status`) VALUES
(1, '4231196B011PB3', '1996-11-23', 'г. Борисов, ул. Горького, 104-47', '2222222', 'Неактивный'),
(18, '4231196B011PB4', '1996-11-23', 'Борисов, ул. Горького, 104-47', '1111111111', 'Неактивный'),
(19, '', '1992-02-29', 'г. Борисов, ул. Горького, 104-47', 'NULL', 'Неактивный'),
(20, '', '1995-03-23', 'г. Минск', '...', 'Неактивный'),
(21, '', '0000-00-00', 'г. Борисов, ул. 50 лет БССР', 'NULL', 'Неактивный'),
(22, '', '1997-03-20', 'г. Калинковичи', 'NULL', 'Неактивный'),
(23, NULL, NULL, NULL, NULL, 'Неактивный'),
(24, NULL, NULL, NULL, NULL, 'Неактивный'),
(25, NULL, NULL, NULL, NULL, 'Неактивный'),
(26, NULL, NULL, NULL, NULL, 'Неактивный'),
(27, NULL, NULL, NULL, NULL, 'Неактивный'),
(28, NULL, NULL, NULL, NULL, 'Неактивный'),
(29, NULL, NULL, NULL, NULL, 'Неактивный'),
(30, NULL, NULL, NULL, NULL, 'Неактивный'),
(31, NULL, NULL, NULL, NULL, 'Неактивный'),
(32, NULL, NULL, NULL, NULL, 'Неактивный'),
(33, NULL, NULL, NULL, NULL, 'Неактивный'),
(34, NULL, NULL, NULL, NULL, 'Неактивный');

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `send_to` varchar(100) DEFAULT NULL,
  `send_from` varchar(100) DEFAULT NULL,
  `subject` text,
  `content` text,
  `trigger_type` enum('Регистрация','Подключение услуги','Блокировка услуги') NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`notification_id`, `send_to`, `send_from`, `subject`, `content`, `trigger_type`) VALUES
(1, '', 'velcom@gmail.com', 'Регистрация в биллинговой системе Velcom', 'Здравствуйте, $_SURNAME $_NAME $_LASTNAME!<br>\r\nВы зарегистрированы в системе Velcom. Ваши данные для входа:<br>\r\nЛогин: $_EMAIL<br>\r\nПароль: $_PASSWORD<br><br>\r\nС уважением,<br>\r\nVelcom', 'Регистрация'),
(8, '', 'velcom@gmail.com', 'Подключение на тарифный план $_TARIFF_PLAN_TITLE', 'Здравствуйте, $_SURNAME $_NAME $_LASTNAME!<br>\r\nВы подключены на тарифный план $_TARIFF_PLAN_TITLE. Ваш телефонный номер: $_TELEPHONE_NUMBER.<br><br>\r\nС уважением,<br>\r\nVelcom', 'Подключение услуги');

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount_of_money` double NOT NULL,
  `account_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `fk_to_accounts_idx` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`payment_id`, `amount_of_money`, `account_id`, `date`) VALUES
(1, 15, 2, '2018-05-24');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `tariff_plan_id` int(11) NOT NULL,
  `telephone_number` varchar(25) DEFAULT NULL,
  `connection_date` date NOT NULL,
  `disconnection_date` date DEFAULT NULL,
  `status` enum('Активна','Неактивна','Заблокирована') NOT NULL DEFAULT 'Неактивна',
  PRIMARY KEY (`service_id`),
  KEY `fk_services_clients_idx` (`client_id`),
  KEY `fk_services_tariff_plans_idx` (`tariff_plan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`service_id`, `client_id`, `tariff_plan_id`, `telephone_number`, `connection_date`, `disconnection_date`, `status`) VALUES
(1, 1, 6, '+375(29)673-67-60', '2018-04-05', NULL, 'Неактивна'),
(10, 1, 1, '+375(29)183-50-88', '2018-04-05', NULL, 'Активна'),
(13, 18, 1, '+375(29)187-08-42', '2018-04-20', NULL, 'Неактивна'),
(14, 18, 10, '+375(29)744-89-01', '2018-04-19', NULL, 'Неактивна'),
(15, 19, 3, '+375(29)744-89-01', '2018-04-17', NULL, 'Неактивна'),
(16, 20, 4, '+375(33)639-14-70', '2018-04-30', NULL, 'Неактивна'),
(17, 21, 10, '+375(44)412-64-58', '2018-04-12', NULL, 'Активна'),
(18, 22, 7, '+375(29)351-16-55', '2018-04-06', NULL, 'Неактивна');

-- --------------------------------------------------------

--
-- Структура таблицы `tariff_plans`
--

CREATE TABLE IF NOT EXISTS `tariff_plans` (
  `tariff_plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `tariff_plan_group_id` int(11) NOT NULL,
  `internet_traffic_mb` varchar(16) DEFAULT NULL,
  `phone_traffic_within_network_min` varchar(16) DEFAULT NULL,
  `phone_traffic_all_networks_min` varchar(16) DEFAULT NULL,
  `international_calls_traffic_min` varchar(16) DEFAULT NULL,
  `sms_within_network` varchar(16) DEFAULT NULL,
  `sms_all_networks` varchar(16) DEFAULT NULL,
  `mms_within_network` varchar(16) DEFAULT NULL,
  `mms_all_networks` varchar(16) DEFAULT NULL,
  `favorite_numbers_amount` int(2) DEFAULT NULL,
  `state` enum('Действующий','Архивный') NOT NULL DEFAULT 'Действующий',
  `subscription_fee` double NOT NULL,
  PRIMARY KEY (`tariff_plan_id`),
  KEY `fk_to_tpg_idx` (`tariff_plan_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `tariff_plans`
--

INSERT INTO `tariff_plans` (`tariff_plan_id`, `title`, `description`, `tariff_plan_group_id`, `internet_traffic_mb`, `phone_traffic_within_network_min`, `phone_traffic_all_networks_min`, `international_calls_traffic_min`, `sms_within_network`, `sms_all_networks`, `mms_within_network`, `mms_all_networks`, `favorite_numbers_amount`, `state`, `subscription_fee`) VALUES
(1, 'Комфорт', '', 1, '1024', 'БЕЗЛИМИТ', '100', NULL, NULL, NULL, NULL, NULL, NULL, 'Действующий', 11.11),
(2, 'Комфорт 2', '', 1, '2048', 'БЕЗЛИМИТ', '200', NULL, NULL, NULL, NULL, NULL, NULL, 'Действующий', 16.72),
(3, 'Комфорт 4', '', 1, '4096', 'БЕЗЛИМИТ', '300', NULL, NULL, NULL, NULL, NULL, NULL, 'Действующий', 18.97),
(4, 'В твоем ритме', '', 6, '4096', NULL, NULL, NULL, NULL, '600', NULL, NULL, NULL, 'Действующий', 10.76),
(5, 'Smart Бесконечный', '', 3, 'БЕЗЛИМИТ', 'БЕЗЛИМИТ', '1000', NULL, 'БЕЗЛИМИТ', NULL, 'БЕЗЛИМИТ', NULL, NULL, 'Действующий', 56.02),
(6, 'Бизнес-класс', '', 3, 'БЕЗЛИМИТ', NULL, 'БЕЗЛИМИТ', '300', 'БЕЗЛИМИТ', NULL, NULL, NULL, NULL, 'Действующий', 112.15),
(7, 'Супер WEB 5', '', 4, '5120', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Действующий', 8.75),
(8, 'Супер WEB 10', '', 4, '10240', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Действующий', 12.87),
(9, 'Супер WEB 30', '', 4, '30720', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Действующий', 20.08),
(10, 'Социальный', '', 5, NULL, '60', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Действующий', 1.54);

-- --------------------------------------------------------

--
-- Структура таблицы `tariff_plans_groups`
--

CREATE TABLE IF NOT EXISTS `tariff_plans_groups` (
  `tariff_plan_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`tariff_plan_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `tariff_plans_groups`
--

INSERT INTO `tariff_plans_groups` (`tariff_plan_group_id`, `title`, `description`) VALUES
(1, 'Лучшее для смартфонов', 'На странице собраны тарифы, которым можно позавидовать: содержат все, идеальны для пользователей смартфонов и вполне динамичные.'),
(2, 'Легкие тарифы', 'Тарифы собраны так, что дают возможность определиться с какого начать, какой подходит больше, какие плюсы и минусы у каждого.'),
(3, 'Включено почти все', 'Тарифы для фундаменталистов. Такие же наполненные, стабильные и не содержат ничего лишнего.'),
(4, 'Только интернет', 'Планшет или компьютер - девайсы, которые используются только для работы в интернете? Значит, выбрана нужная страница сайта. Предлагаемые тарифы с широким выбором включенного трафика не позволят заскучать в интернете.'),
(5, 'Социальные и специальные тарифы', 'Предлагаемые тарифы подходят не многим и отрицать не стоит. Содержат достаточное количество включенных минут, любимые номера или интернет трафик. Действительно удобно, если использовать исключительно по назначению.'),
(6, 'Тарифы для молодежи', 'Тарифы, в которых есть все, что тебе нужно: безлимит на соцсети и мессенжеры в lemon или музыка без границ "В твоем ритме".');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` date DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'avatar.png',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `lastname`, `email`, `password`, `registration_date`, `is_admin`, `image`) VALUES
(1, 'Анна', 'Трофименкова', 'Александровна', 'anna.trof@tut.by', '$1$Xh..UB1.$kOIPehC7IGm3LRbOvt3GY.', '2018-03-24', 1, 'ma3xsEtTDLQ.jpg'),
(18, 'Ольга', 'Трофименкова', 'Александровна', 'olga.trof02@gmail.com', '$1$FU1.qp1.$xlYmR/D5WbCtU3KwjaKn71', '2018-04-22', 0, 'tihHSEoNP5M.jpg'),
(19, 'Григорий', 'Трофименков', 'Александрович', 'gryndix@gmail.com', '$1$485.5R2.$IG2oYUu0bgW67cMKCyS5d1', '2018-05-01', 0, 'M8mejgg8n5w.jpg'),
(20, 'Кира', 'Емчик', 'Руслановна', 'kerminsk@gmail.com', '$1$d9..ih4.$MXomtlwWSn0YFMyVeQIMD.', '2018-05-01', 0, 'Nkpm-dnCEYY.jpg'),
(21, 'Валентина', 'Бондарева', 'Ефимовна', 'bondareva.valentina@tut.by', '$1$4P0.5O..$UYKa7OsspNLlWIobN6nUe0', '2018-05-01', 0, 'avatar.png'),
(22, 'Надежда', 'Климчук', 'Михайловна', 'klimchuk.nadya@gmail.com', '$1$B11.0q4.$Fc19w.oW.7iOwWvfZgTSC0', '2018-05-01', 0, 'Jpc8mPKx7_I.jpg'),
(23, 'Александр', 'Трофименков', 'Николаевич', 'alex.trof@tut.by', '$1$Vv..4E/.$/VOzkznfYa8gny/QdABfA1', '2018-05-01', 0, 'avatar.png'),
(24, 'Тамара', 'Тисецкая', 'Ефимовна', 'tamara@gmail.com', '$1$/O1.aA1.$h08a6zS5U5HjW6FdCl4wP0', '2018-05-01', 0, 'avatar.png'),
(25, 'Алексей', 'Тисецкий', 'Эдуардович', 'aleksei@gmail.com', '$1$az5.bY1.$XSwryiOXlaFphf24XZ1QU1', '2018-05-01', 0, 'avatar.png'),
(26, 'Кристина', 'Харитоник', 'Дмитриевна', 'haritonik.kristina@gmail.com', '$1$Rd1.Gz3.$XqJm1EhYBVQTN55f23Wmq/', '2018-05-01', 0, 'avatar.png'),
(27, 'Сергей', 'Бондарев', 'Анатольевич', 'sergey.bondarev@tut.by', '$1$SO4.zJ..$pm7APJPYBIe8sxXq61SpJ0', '2018-05-01', 0, 'avatar.png'),
(28, 'Людмила', 'Гайдук', 'Вячеславовна', 'gaiduk.lyadmila@tut.by', '$1$fD..6J5.$S8SauFgOB1xi6z4e7T5GN0', '2018-05-01', 0, 'avatar.png'),
(29, 'Галина', 'Короленок', 'Григорьевна', 'korolenok@tut.by', '$1$d.5.iy4.$rvfJ17hfxnoMlLmRKwrkL.', '2018-05-01', 0, 'avatar.png'),
(30, 'Михаил', 'Цеховой', 'Васильевич', 'chehovoi@tut.by', '$1$WD1.nB0.$Cmd4saWZYq6.fZLYZ/XFs.', '2018-05-01', 0, 'avatar.png'),
(31, 'Людмила', 'Синькевич', 'Александровна', 'sinkevich@gmail.com', '$1$71/.CD/.$DrvnbrY/8iQGr7PsG.VvB1', '2018-05-01', 0, 'avatar.png'),
(32, 'Любовь', 'Ковова', 'Аркадьевна', 'kovova.lybov@gmail.com', '$1$Wu0.nQ4.$COeUFwhuHkIqAUUgoJ1/b1', '2018-05-01', 0, 'avatar.png'),
(33, 'Наталья', 'Ковова', 'Алексеевна', 'kovova.natasha@tut.by', '$1$5f..oX4.$icQqnl5y5q1zHijagz1qa/', '2018-05-01', 0, 'avatar.png'),
(34, 'Надежда', 'Куприянова', 'Александровна', 'kupriyanova@tut.by', '$1$Dv4.Q/5.$7OGSKDfUjsRnJxZxVlKJI/', '2018-05-01', 0, 'avatar.png');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_to_services` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_to_users` FOREIGN KEY (`client_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_to_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_services_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_to_tarif_plans` FOREIGN KEY (`tariff_plan_id`) REFERENCES `tariff_plans` (`tariff_plan_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tariff_plans`
--
ALTER TABLE `tariff_plans`
  ADD CONSTRAINT `fk_to_tpg` FOREIGN KEY (`tariff_plan_group_id`) REFERENCES `tariff_plans_groups` (`tariff_plan_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
