-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 29 2020 г., 19:34
-- Версия сервера: 10.1.37-MariaDB
-- Версия PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `flashcms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('fullAdmin', '1', 1609240203),
('instanceAdmin', '2', 1609240204),
('instanceAdmin', '3', 1609240204),
('instanceAdmin', '4', 1609240204),
('instanceOperator', '33', 1609240687),
('instanceOperator', '36', 1609264909),
('instanceOperator', '37', 1609265495),
('instanceOperator', '5', 1609240204),
('instanceOperator', '6', 1609240204),
('instanceOperator', '7', 1609240204);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('chatAdmin', 2, 'Администратор инстанса бота', NULL, NULL, 1609240203, 1609240203),
('chatOperator', 2, 'Оператор чат бота', NULL, NULL, 1609240203, 1609240203),
('fullAdmin', 1, 'Роль администратора системы', NULL, NULL, 1609240203, 1609240203),
('instanceAdmin', 1, 'Роль администратора чата', NULL, NULL, 1609240203, 1609240203),
('instanceOperator', 1, 'Роль оператор чата', NULL, NULL, 1609240203, 1609240203),
('systemAdmin', 2, 'Администратор системы', NULL, NULL, 1609240203, 1609240203);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('chatAdmin', 'chatOperator'),
('fullAdmin', 'systemAdmin'),
('instanceAdmin', 'chatAdmin'),
('instanceOperator', 'chatOperator'),
('systemAdmin', 'chatAdmin');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_base_pages`
--

CREATE TABLE `flash_cms_table_base_pages` (
  `id` int(2) NOT NULL,
  `title` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_base_pages`
--

INSERT INTO `flash_cms_table_base_pages` (`id`, `title`, `link`) VALUES
(1, 'Главная', '/'),
(2, 'Заглушка', '#');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_bwa_bot_last_message`
--

CREATE TABLE `flash_cms_table_bwa_bot_last_message` (
  `id` int(5) NOT NULL,
  `chat_id` varchar(255) DEFAULT NULL,
  `message_number` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_bwa_bot_last_message`
--

INSERT INTO `flash_cms_table_bwa_bot_last_message` (`id`, `chat_id`, `message_number`) VALUES
(1, '77761666161-1572782758@g.us', 11000);

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_chats_info`
--

CREATE TABLE `flash_cms_table_chats_info` (
  `id` int(11) NOT NULL,
  `chatId` varchar(100) NOT NULL,
  `chatName` varchar(100) NOT NULL,
  `chatImage` varchar(255) DEFAULT NULL,
  `city` varchar(10) DEFAULT NULL,
  `instance` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_chats_info`
--

INSERT INTO `flash_cms_table_chats_info` (`id`, `chatId`, `chatName`, `chatImage`, `city`, `instance`) VALUES
(1, '77770188219@c.us', 'TRJflash', 'https://pps.whatsapp.net/v/t61.24694-24/55963533_382458569009471_881171145603153920_n.jpg?oh=b38a0d6510e8626a3cdf1f60724f4076&oe=5FDB2EF2', NULL, 207064),
(82, '77770188219@c.us', 'TRJflash_2', 'https://pps.whatsapp.net/v/t61.24694-24/55963533_382458569009471_881171145603153920_n.jpg?oh=b38a0d6510e8626a3cdf1f60724f4076&oe=5FDB2EF2', NULL, 131785),
(84, '77770188289@c.us', 'TRJflash_3', 'https://pps.whatsapp.net/v/t61.24694-24/55963533_382458569009471_881171145603153920_n.jpg?oh=b38a0d6510e8626a3cdf1f60724f4076&oe=5FDB2EF2', NULL, 131785);

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_chats_messages`
--

CREATE TABLE `flash_cms_table_chats_messages` (
  `id` int(7) NOT NULL,
  `messageId` varchar(255) DEFAULT NULL,
  `body` text,
  `self` enum('0','1') DEFAULT '0',
  `fromMe` enum('0','1') NOT NULL DEFAULT '0',
  `isForwarded` enum('0','1') DEFAULT '0',
  `author` varchar(50) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `chatId` varchar(50) DEFAULT NULL,
  `messageNumber` int(5) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `senderName` varchar(100) DEFAULT NULL,
  `caption` text,
  `quotedMsgBody` text,
  `quotedMsgId` varchar(255) DEFAULT NULL,
  `quotedMsgType` varchar(50) DEFAULT NULL,
  `chatName` varchar(100) DEFAULT NULL,
  `isNew` enum('0','1') DEFAULT '0',
  `instance` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_chats_messages`
--

INSERT INTO `flash_cms_table_chats_messages` (`id`, `messageId`, `body`, `self`, `fromMe`, `isForwarded`, `author`, `time`, `chatId`, `messageNumber`, `type`, `senderName`, `caption`, `quotedMsgBody`, `quotedMsgId`, `quotedMsgType`, `chatName`, `isNew`, `instance`) VALUES
(1, 'false_77770188219@c.us_3BA46E64CC700CE1F13CF2ADBF260119', 'Ответ', '0', '0', '0', '77770188219@c.us', 1608189972, '77770188219@c.us', 940, 'chat', 'TRJflash', NULL, NULL, NULL, NULL, '+7 777 018 8219', '0', 207064),
(2, 'false_77770188219@c.us_663EDBD98873D35145FEB90012AB5599', 'Ещё раз', '0', '0', '0', '77770188219@c.us', 1608189993, '77770188219@c.us', 941, 'chat', 'TRJflash', NULL, NULL, NULL, NULL, '+7 777 018 8219', '0', 207064),
(3, 'true_77770188219@c.us_3EB050946DE290D6DD47', 'ОК', '1', '1', '0', '77073660303@c.us', 1608190013, '77770188219@c.us', 942, 'chat', 'Он Клиник', NULL, NULL, NULL, NULL, '+7 777 018 8219', '0', 207064),
(6, 'true_77770188219@c.us_3EB050946DE290D6DD47', 'ОК', '1', '0', '0', '77073660303@c.us', 1608190013, '77770188219@c.us', 942, 'chat', 'Он Клиник', NULL, NULL, NULL, NULL, '+7 777 018 8219', '1', 131785),
(7, 'true_77770188289@c.us_3EB050946DE290D6DD47', 'ОК', '1', '0', '0', '77073660303@c.us', 1608190013, '77770188289@c.us', 942, 'chat', 'Он Клиник', NULL, NULL, NULL, NULL, '+7 777 018 82189', '1', 131785);

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_chat_instances`
--

CREATE TABLE `flash_cms_table_chat_instances` (
  `id` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `instance` int(7) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `display_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_chat_instances`
--

INSERT INTO `flash_cms_table_chat_instances` (`id`, `link`, `token`, `instance`, `name`, `display_name`) VALUES
(1, 'https://eu182.chat-api.com/instance207064/', 'o3dnty29nf5l5qth', 207064, 'astsna', 'Астана'),
(9, 'https://eu39.chat-api.com/instance131785/', 'xiszsnf6lokcys3l', 131785, 'almaty', 'Алматы');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_chat_inst_collation`
--

CREATE TABLE `flash_cms_table_chat_inst_collation` (
  `id` int(10) NOT NULL,
  `inst_name` varchar(20) DEFAULT NULL,
  `user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_chat_inst_collation`
--

INSERT INTO `flash_cms_table_chat_inst_collation` (`id`, `inst_name`, `user`) VALUES
(30, 'almaty', 1),
(13, 'almaty', 3),
(14, 'almaty', 6),
(31, 'astsna', 1),
(6, 'astsna', 2),
(12, 'astsna', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_menus`
--

CREATE TABLE `flash_cms_table_menus` (
  `id` int(2) NOT NULL,
  `menu_item` varchar(50) DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `is_parent` enum('0','1') DEFAULT '0',
  `parent_id` int(2) DEFAULT '0',
  `menu_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_menus`
--

INSERT INTO `flash_cms_table_menus` (`id`, `menu_item`, `link`, `is_parent`, `parent_id`, `menu_type`) VALUES
(1, 'Главная', '#', '0', 0, 'main'),
(2, 'Услуги', '#', '1', 0, 'main'),
(3, 'Мгновенная помощь', '#', '0', 0, 'main'),
(4, 'Подать заявку', '#', '0', 0, 'main'),
(5, 'Контакты', '#', '0', 0, 'main'),
(6, 'IT-аутсорсинг', '#', '0', 2, 'main'),
(7, 'Монтаж видеонаблюдения', '#', '0', 2, 'main'),
(118, 'Отображаемое имя пункта меню', '/material/view?id=1', '1', 0, 'nazvanie-menyu'),
(119, 'Отображаемое имя пункта суб меню', '/', '0', 118, 'nazvanie-menyu'),
(120, 'Отображаемое имя пункта суб меню 2', '#', '0', 118, 'nazvanie-menyu');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_menus_destinations`
--

CREATE TABLE `flash_cms_table_menus_destinations` (
  `id` int(2) NOT NULL,
  `tableName` varchar(100) NOT NULL,
  `keyField` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_menus_destinations`
--

INSERT INTO `flash_cms_table_menus_destinations` (`id`, `tableName`, `keyField`) VALUES
(1, 'flash_cms_table_pages', 'title');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_menus_types`
--

CREATE TABLE `flash_cms_table_menus_types` (
  `id` int(3) NOT NULL,
  `menu_type` varchar(100) NOT NULL,
  `menu_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_menus_types`
--

INSERT INTO `flash_cms_table_menus_types` (`id`, `menu_type`, `menu_type_name`) VALUES
(1, 'main', 'Главное'),
(34, 'nazvanie-menyu', 'Название меню');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_pages`
--

CREATE TABLE `flash_cms_table_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `keywords` text,
  `page_content` text NOT NULL,
  `views` int(7) DEFAULT '0',
  `comments` int(7) DEFAULT '0',
  `author` varchar(100) DEFAULT NULL,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `edit_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `need_comments` enum('0','1') DEFAULT '0',
  `need_info_line` enum('0','1') DEFAULT '0',
  `page_type` varchar(100) NOT NULL,
  `page_type_name` varchar(100) NOT NULL,
  `active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица материалов основных страниц';

--
-- Дамп данных таблицы `flash_cms_table_pages`
--

INSERT INTO `flash_cms_table_pages` (`id`, `title`, `description`, `keywords`, `page_content`, `views`, `comments`, `author`, `creation_date`, `edit_date`, `need_comments`, `need_info_line`, `page_type`, `page_type_name`, `active`) VALUES
(1, 'IT-Аутсорсинг,Ремонт,обслуживание ПК и оргтехники', 'IT-Аутсорсинг, Ремонт, обслуживание ПК и оргтехники', 'IT-Аутсорсинг алматы,it аутсорсинг алматы,абонентское обслуживание компьютеров алматы,абонентское обслуживание компьютеров Алматы,абонентское обслуживание компьютеров организаций алматы,абонентское обслуживание компьютеров цены алматы,аутсорсинг ит инфраструктуры алматы,аутсорсинг ит компании алматы,аутсорсинг ит услуг алматы,аутсорсинг ит цены алматы,аутсорсинг обслуживание компьютеров алматы,договор +на абонентское обслуживание компьютеров алматы,договор +на ит аутсорсинг алматы,договор +на обслуживание компьютеров алматы,договор ит аутсорсинга образец алматы,договор технического обслуживания компьютеров алматы,инженер +по обслуживанию компьютеров алматы,ит аутсорсинг алматы,ит аутсорсинг коммерческое предложение алматы,ит аутсорсинг Алматы,ит обслуживание,аутсорсинг коммерческое предложение +на обслуживание компьютеров алматы,компания +по обслуживанию компьютеров алматы,комплексное обслуживание компьютеров алматы,настройка компьютеров алматы,обслуживание настройка алматы,ремонт +и обслуживание компьютеров алматы,обслуживание компьютеров алматы,обслуживание компьютеров +в офисе алматы,обслуживание компьютеров +и ноутбуков алматы,обслуживание компьютеров +и серверов алматы,обслуживание компьютеров Алматы,обслуживание компьютеров организации алматы,обслуживание компьютеров прайс лист алматы,обслуживание компьютеров цены алматы,обслуживание компьютеров юридических лиц алматы,обслуживание оргтехники +и компьютеров алматы,обслуживание офисных компьютеров алматы,обслуживание персонального компьютера алматы,обслуживание ремонт компьютеров алматы,обслуживание сетей компьютеров алматы,обслуживание системы компьютера алматы,прайс обслуживание компьютеров алматы,преимущества ит аутсорсинга алматы,программное обслуживание компьютеров алматы,разовое обслуживание компьютеров алматы,расценки +на обслуживание компьютеров алматы,рынок ит аутсорсинга алматы,сервисное обслуживание компьютеров алматы,системное обслуживание компьютеров алматы,специалист +по обслуживанию компьютеров алматы,стоимость ит аутсорсинга алматы,стоимость обслуживания компьютеров алматы,техник +по обслуживанию компьютеров алматы,техническое обслуживание +и ремонт компьютеров алматы,техническое обслуживание компьютеров алматы,техническое обслуживание компьютеров +и оргтехники алматы,техническое обслуживание персонального компьютера алматы,требуется обслуживание компьютеров алматы,удаленное обслуживание компьютеров алматы,услуги обслуживания компьютеров алматы,фирмы +по обслуживанию компьютеров алматы', '<p>&nbsp;</p><p>Мы IT компания, которая поставила для себя цель профессионально и качественно сопровождать предприятия в нашей сфере, взяв на себя все возникающие проблемы в IT. На своем примере показывая, что \"Не нужно платить за часы, платите за результат\". Мы не пытаемся пропиариться за счет наших клиентов показывая кто нам доверяет, тем самым сохраняя анонимность, конфиденциальность и сохранность информационной безопасности наших клиентов. С Trinity IT ВЫ и Ваш бизнес будут идти в ногу со временем, и не дадим вам споткнуться или отстать!</p><p>&nbsp;</p>', 0, 0, 'ADM', '2020-06-01 00:00:00', '2020-07-16 12:54:56', '0', '0', 'main', 'Главная', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_pages_types`
--

CREATE TABLE `flash_cms_table_pages_types` (
  `id` int(2) NOT NULL,
  `page_type` varchar(100) NOT NULL,
  `page_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_pages_types`
--

INSERT INTO `flash_cms_table_pages_types` (`id`, `page_type`, `page_type_name`) VALUES
(1, 'main', 'Главная'),
(2, 'contact', 'Контакты');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_shop_categories`
--

CREATE TABLE `flash_cms_table_shop_categories` (
  `id` int(3) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT NULL,
  `is_parent` enum('0','1') DEFAULT NULL,
  `parent_id` int(3) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `imported` enum('0','1') NOT NULL DEFAULT '0',
  `import_source` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_shop_categories`
--

INSERT INTO `flash_cms_table_shop_categories` (`id`, `category_name`, `is_active`, `is_parent`, `parent_id`, `keywords`, `description`, `imported`, `import_source`) VALUES
(1, 'Мобильные телефоны и аксессуары', '1', '0', 0, '', '', '0', '');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_shop_delivery_type`
--

CREATE TABLE `flash_cms_table_shop_delivery_type` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_shop_delivery_type`
--

INSERT INTO `flash_cms_table_shop_delivery_type` (`id`, `type`, `active`) VALUES
(1, 'Самовывоз', '1'),
(2, 'Доставка', '1'),
(3, 'Почтой', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_shop_goods`
--

CREATE TABLE `flash_cms_table_shop_goods` (
  `id` int(3) NOT NULL,
  `category_id` int(3) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `photos` varchar(255) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `price` int(10) DEFAULT '0',
  `self_price` int(10) NOT NULL DEFAULT '0',
  `anons` varchar(255) DEFAULT NULL,
  `description` text,
  `top` enum('0','1') NOT NULL DEFAULT '0',
  `new` enum('0','1') NOT NULL DEFAULT '0',
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `availability` int(7) NOT NULL DEFAULT '0',
  `imported` enum('0','1') NOT NULL DEFAULT '0',
  `import_source` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_shop_goods`
--

INSERT INTO `flash_cms_table_shop_goods` (`id`, `category_id`, `name`, `photos`, `code`, `price`, `self_price`, `anons`, `description`, `top`, `new`, `active`, `availability`, `imported`, `import_source`) VALUES
(30, 1, 'dfgdf gsdfg', '31,32,33,34,35', 'jXbfNsaOjU30', 123123, 312, 'sadfsdf', 'asdfasdf', '1', '0', '1', 123, '0', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_shop_goods_photos`
--

CREATE TABLE `flash_cms_table_shop_goods_photos` (
  `id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `good_id` int(11) NOT NULL,
  `is_main` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_shop_goods_photos`
--

INSERT INTO `flash_cms_table_shop_goods_photos` (`id`, `file`, `good_id`, `is_main`) VALUES
(31, 'aAskdhnvVP.jpeg', 30, '1'),
(32, 'ZrQUZghnNg.jpg', 30, '0'),
(33, 'QAmomFPDYS.jpg', 30, '0'),
(34, 'uQUquaAAde.jpg', 30, '0'),
(35, 'BQMBdYToWz.jpeg', 30, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_shop_orders`
--

CREATE TABLE `flash_cms_table_shop_orders` (
  `id` int(5) NOT NULL,
  `doogs` int(3) NOT NULL,
  `delivery_type` int(1) NOT NULL,
  `delivery_point` varchar(255) NOT NULL,
  `total_price` int(10) NOT NULL,
  `executed` enum('0','1') NOT NULL,
  `creatione_time` date NOT NULL,
  `executed_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_tables_controllers`
--

CREATE TABLE `flash_cms_table_tables_controllers` (
  `id` int(3) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `controller_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_tables_controllers`
--

INSERT INTO `flash_cms_table_tables_controllers` (`id`, `table_name`, `controller_name`) VALUES
(1, 'flash_cms_table_pages', 'material');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_tables_for_links`
--

CREATE TABLE `flash_cms_table_tables_for_links` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `table_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_tables_for_links`
--

INSERT INTO `flash_cms_table_tables_for_links` (`id`, `table_name`, `table_title`) VALUES
(1, 'flash_cms_table_pages', 'ROOT материалы'),
(2, 'flash_cms_table_base_pages', 'Базовые ссылки');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_users`
--

CREATE TABLE `flash_cms_table_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `display_name` varchar(100) NOT NULL,
  `avatar_icon` varchar(100) NOT NULL,
  `authKey` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `lastLogin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_users`
--

INSERT INTO `flash_cms_table_users` (`id`, `username`, `secret`, `display_name`, `avatar_icon`, `authKey`, `email`, `lastLogin`) VALUES
(1, 'flashadmin', '$2y$13$D8jgVSD/aZ5HBkgg4l2ml.8Rjnt3vwEkLffZM3Nkc9IRPUutw4Jxm', 'Администартор системы', '', NULL, NULL, NULL),
(2, 'astanaadmin', '$2y$13$RxAXttxAmRVL.Chd6h85V.rtcjzJg/sIbwEGxQFXVIxpyIkDfUL0a', 'Администратор Астана', '', NULL, NULL, NULL),
(3, 'almatyadmin', '$2y$13$RxAXttxAmRVL.Chd6h85V.rtcjzJg/sIbwEGxQFXVIxpyIkDfUL0a', 'Администратор Алматы', '', NULL, NULL, NULL),
(4, 'ukadmin', '$2y$13$RxAXttxAmRVL.Chd6h85V.rtcjzJg/sIbwEGxQFXVIxpyIkDfUL0a', 'Администратор Усть-Каменогорск', '', NULL, NULL, NULL),
(5, 'astanaoperator', '$2y$13$RxAXttxAmRVL.Chd6h85V.rtcjzJg/sIbwEGxQFXVIxpyIkDfUL0a', 'Оператор Астана', '', NULL, NULL, NULL),
(6, 'almatyoperator', '$2y$13$RxAXttxAmRVL.Chd6h85V.rtcjzJg/sIbwEGxQFXVIxpyIkDfUL0a', 'Оператор Алматы', '', NULL, NULL, NULL),
(7, 'ukoperator', '$2y$13$RxAXttxAmRVL.Chd6h85V.rtcjzJg/sIbwEGxQFXVIxpyIkDfUL0a', 'Оператор Усть-Каменогорск', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1604983375),
('m140506_102106_rbac_init', 1608524223),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1608524224),
('m180523_151638_rbac_updates_indexes_without_prefix', 1608524224),
('m200409_110543_rbac_update_mssql_trigger', 1608524224);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `flash_cms_table_base_pages`
--
ALTER TABLE `flash_cms_table_base_pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_bwa_bot_last_message`
--
ALTER TABLE `flash_cms_table_bwa_bot_last_message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_chats_info`
--
ALTER TABLE `flash_cms_table_chats_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `instance` (`instance`);

--
-- Индексы таблицы `flash_cms_table_chats_messages`
--
ALTER TABLE `flash_cms_table_chats_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `instance` (`instance`);

--
-- Индексы таблицы `flash_cms_table_chat_instances`
--
ALTER TABLE `flash_cms_table_chat_instances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `flash_cms_table_chat_inst_collation`
--
ALTER TABLE `flash_cms_table_chat_inst_collation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inst_name` (`inst_name`,`user`),
  ADD KEY `FK_User` (`user`);

--
-- Индексы таблицы `flash_cms_table_menus`
--
ALTER TABLE `flash_cms_table_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_type` (`menu_type`);

--
-- Индексы таблицы `flash_cms_table_menus_destinations`
--
ALTER TABLE `flash_cms_table_menus_destinations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_menus_types`
--
ALTER TABLE `flash_cms_table_menus_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_type` (`menu_type`,`menu_type_name`) USING BTREE;

--
-- Индексы таблицы `flash_cms_table_pages`
--
ALTER TABLE `flash_cms_table_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_type` (`page_type`),
  ADD KEY `page_type_name` (`page_type_name`);

--
-- Индексы таблицы `flash_cms_table_pages_types`
--
ALTER TABLE `flash_cms_table_pages_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_type` (`page_type`),
  ADD UNIQUE KEY `page_type_name` (`page_type_name`);

--
-- Индексы таблицы `flash_cms_table_shop_categories`
--
ALTER TABLE `flash_cms_table_shop_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_shop_delivery_type`
--
ALTER TABLE `flash_cms_table_shop_delivery_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_shop_goods`
--
ALTER TABLE `flash_cms_table_shop_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_category` (`category_id`);

--
-- Индексы таблицы `flash_cms_table_shop_goods_photos`
--
ALTER TABLE `flash_cms_table_shop_goods_photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_shop_orders`
--
ALTER TABLE `flash_cms_table_shop_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_type` (`delivery_type`);

--
-- Индексы таблицы `flash_cms_table_tables_controllers`
--
ALTER TABLE `flash_cms_table_tables_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_tables_for_links`
--
ALTER TABLE `flash_cms_table_tables_for_links`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_users`
--
ALTER TABLE `flash_cms_table_users`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_base_pages`
--
ALTER TABLE `flash_cms_table_base_pages`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_bwa_bot_last_message`
--
ALTER TABLE `flash_cms_table_bwa_bot_last_message`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chats_info`
--
ALTER TABLE `flash_cms_table_chats_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chats_messages`
--
ALTER TABLE `flash_cms_table_chats_messages`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chat_instances`
--
ALTER TABLE `flash_cms_table_chat_instances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chat_inst_collation`
--
ALTER TABLE `flash_cms_table_chat_inst_collation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_menus`
--
ALTER TABLE `flash_cms_table_menus`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_menus_destinations`
--
ALTER TABLE `flash_cms_table_menus_destinations`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_menus_types`
--
ALTER TABLE `flash_cms_table_menus_types`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_pages`
--
ALTER TABLE `flash_cms_table_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_pages_types`
--
ALTER TABLE `flash_cms_table_pages_types`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_shop_categories`
--
ALTER TABLE `flash_cms_table_shop_categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_shop_delivery_type`
--
ALTER TABLE `flash_cms_table_shop_delivery_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_shop_goods`
--
ALTER TABLE `flash_cms_table_shop_goods`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_shop_goods_photos`
--
ALTER TABLE `flash_cms_table_shop_goods_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_shop_orders`
--
ALTER TABLE `flash_cms_table_shop_orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_tables_controllers`
--
ALTER TABLE `flash_cms_table_tables_controllers`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_tables_for_links`
--
ALTER TABLE `flash_cms_table_tables_for_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_users`
--
ALTER TABLE `flash_cms_table_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `flash_cms_table_chat_inst_collation`
--
ALTER TABLE `flash_cms_table_chat_inst_collation`
  ADD CONSTRAINT `FK_City` FOREIGN KEY (`inst_name`) REFERENCES `flash_cms_table_chat_instances` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_InstName` FOREIGN KEY (`inst_name`) REFERENCES `flash_cms_table_chat_instances` (`name`),
  ADD CONSTRAINT `FK_User` FOREIGN KEY (`user`) REFERENCES `flash_cms_table_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserId` FOREIGN KEY (`user`) REFERENCES `flash_cms_table_users` (`id`);

--
-- Ограничения внешнего ключа таблицы `flash_cms_table_menus`
--
ALTER TABLE `flash_cms_table_menus`
  ADD CONSTRAINT `flash_cms_table_menus_ibfk_1` FOREIGN KEY (`menu_type`) REFERENCES `flash_cms_table_menus_types` (`menu_type`);

--
-- Ограничения внешнего ключа таблицы `flash_cms_table_pages`
--
ALTER TABLE `flash_cms_table_pages`
  ADD CONSTRAINT `flash_cms_table_pages_ibfk_1` FOREIGN KEY (`page_type`) REFERENCES `flash_cms_table_pages_types` (`page_type`),
  ADD CONSTRAINT `flash_cms_table_pages_ibfk_2` FOREIGN KEY (`page_type_name`) REFERENCES `flash_cms_table_pages_types` (`page_type_name`);

--
-- Ограничения внешнего ключа таблицы `flash_cms_table_shop_goods`
--
ALTER TABLE `flash_cms_table_shop_goods`
  ADD CONSTRAINT `good_category` FOREIGN KEY (`category_id`) REFERENCES `flash_cms_table_shop_categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `flash_cms_table_shop_orders`
--
ALTER TABLE `flash_cms_table_shop_orders`
  ADD CONSTRAINT `delivery_type` FOREIGN KEY (`delivery_type`) REFERENCES `flash_cms_table_shop_delivery_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
