-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 18 2016 г., 11:15
-- Версия сервера: 5.5.49-0ubuntu0.14.04.1
-- Версия PHP: 5.6.23-1+deprecated+dontuse+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `watchdog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `system` int(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `system_name`, `system`, `created`, `updated`, `deleted`) VALUES
(1, 'Гости', 'guest', 1, 111, NULL, NULL),
(2, 'Администраторы', 'admin', 1, 111, NULL, NULL),
(3, 'Клиенты', 'client', 1, 111, NULL, NULL),
(4, 'Партнеры', 'partner', 1, 111, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `groups_permissions`
--

CREATE TABLE IF NOT EXISTS `groups_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `groups_permissions`
--

INSERT INTO `groups_permissions` (`id`, `group_id`, `permission_id`, `created`, `updated`, `deleted`) VALUES
(1, 1, 1, 1459333521, NULL, NULL),
(2, 1, 2, 1459333521, NULL, NULL),
(3, 2, 1, 1459333521, NULL, NULL),
(4, 2, 2, 1459333521, NULL, NULL),
(5, 2, 3, 1459333521, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access` int(12) NOT NULL,
  `owner` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `access`, `owner`, `text`) VALUES
(1, 15, 1, 'test new');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `resource` varchar(255) NOT NULL,
  `allowed` int(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `resource`, `allowed`, `created`, `updated`, `deleted`) VALUES
(1, 'Основные элементы', 'core_*_*', 1, 1441908435, NULL, NULL),
(2, 'Сайт', 'frontend_*_*', 1, 1441908435, NULL, NULL),
(3, 'Административная панель', 'admin_*_*', 1, 1441908435, NULL, NULL),
(4, 'Панель франчайзи', 'franchisepanel_*_*', 1, 1441908435, NULL, NULL),
(8, 'Авторизация', 'access_*_*', 1, 1441908435, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` char(60) NOT NULL,
  `must_change_password` char(1) DEFAULT NULL,
  `banned` int(1) DEFAULT '0',
  `suspended` int(1) DEFAULT '0',
  `active` int(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `avatar`, `login`, `email`, `phone`, `password`, `must_change_password`, `banned`, `suspended`, `active`, `created`, `updated`, `deleted`) VALUES
(1, 'Алексей', ' Маркин', NULL, NULL, 'markin@townwifi.ru', '999999999999', 'f4fd11ee08205422df31ef9589a3a6ab', '0', 0, 0, 1, 9999, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `user_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `fk_roles_u_r_role_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users_groups`
--

INSERT INTO `users_groups` (`user_id`, `group_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users_permissions`
--

CREATE TABLE IF NOT EXISTS `users_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `user_permission_type` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `user_permission_type` (`user_permission_type`),
  KEY `fk_permissions_u_p_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
