-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 07 2020 г., 09:59
-- Версия сервера: 10.4.14-MariaDB
-- Версия PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Структура таблицы `flash_cms_table_chats_info`
--

CREATE TABLE `flash_cms_table_chats_info` (
  `id` int(11) NOT NULL,
  `chatId` varchar(100) NOT NULL,
  `chatName` varchar(100) NOT NULL,
  `chatImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_chats_info`
--

INSERT INTO `flash_cms_table_chats_info` (`id`, `chatId`, `chatName`, `chatImage`) VALUES
(1, '77015667246@c.us', '+7 701 566 7246', 'https://pps.whatsapp.net/v/t61.24694-24/125526754_809729479595229_4979426076799001883_n.jpg?oh=b8ecb336c0090f57dd6b784a82e4fceb&oe=5FCA47A4'),
(4, '77011002015@c.us', 'Дамир Жаримбетов', 'https://pps.whatsapp.net/v/t61.24694-24/124456374_1341224036270192_1766066952502831056_n.jpg?oh=250830cd181989326177e7ed68975d31&oe=5FCB471F'),
(5, '77777815599@c.us', 'Мария Маркетинг', 'https://pps.whatsapp.net/v/t61.24694-24/74937007_462321697800314_959897802823991846_n.jpg?oh=8af1be180fcbf2b9b8c19cc7df7c87da&oe=5FCB09E7'),
(17, '77770188219@c.us', 'ЛЮБИМЫЙ МУЖ!!!!!!', 'https://pps.whatsapp.net/v/t61.24694-24/55963533_382458569009471_881171145603153920_n.jpg?oh=5d71e0f63db5ec88cba2da55c0497e56&oe=5FD1F472'),
(18, '77750188218@c.us', 'Киса', 'https://pps.whatsapp.net/v/t61.24694-24/104433811_209146187166411_6185456538709267362_n.jpg?oh=36eb441d4c26b5725b05d74e945c46d3&oe=5FD1C4C6');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_chats_messages`
--

CREATE TABLE `flash_cms_table_chats_messages` (
  `id` int(7) NOT NULL,
  `messageId` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `self` tinyint(1) DEFAULT NULL,
  `fromMe` tinyint(1) NOT NULL,
  `isForwarded` tinyint(1) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `chatId` varchar(50) DEFAULT NULL,
  `messageNumber` int(5) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `senderName` varchar(100) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `quotedMsgBody` text DEFAULT NULL,
  `quotedMsgId` varchar(255) DEFAULT NULL,
  `quotedMsgType` varchar(50) DEFAULT NULL,
  `chatName` varchar(100) DEFAULT NULL,
  `isNew` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_chats_messages`
--

INSERT INTO `flash_cms_table_chats_messages` (`id`, `messageId`, `body`, `self`, `fromMe`, `isForwarded`, `author`, `time`, `chatId`, `messageNumber`, `type`, `senderName`, `caption`, `quotedMsgBody`, `quotedMsgId`, `quotedMsgType`, `chatName`, `isNew`) VALUES
(2, 'false_77770188219@c.us_3EB088013C21095F5E3B', 'фываыфв', 1, 0, 0, '77770188219@c.us', 1607330751, '77770188219@c.us', 187, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(3, 'false_77770188219@c.us_3EB0E14D947A611B0801', 'dgsdfg', 1, 0, 0, '77770188219@c.us', 1607331113, '77770188219@c.us', 188, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(4, 'false_77770188219@c.us_3EB048860233F1E98DA9', 'asdf', 1, 0, 0, '77770188219@c.us', 1607331654, '77770188219@c.us', 189, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(5, 'false_77770188219@c.us_3EB01B14F7554218CB7B', 'asdasd', 1, 0, 0, '77770188219@c.us', 1607331731, '77770188219@c.us', 190, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(6, 'false_77750188218@c.us_3EB0156AFB63ADE9B0FA', 'ююю', 1, 0, 0, '77750188218@c.us', 1607331888, '77750188218@c.us', 191, 'chat', 'Киса', NULL, NULL, NULL, NULL, 'Киса', '0'),
(7, 'false_77770188219@c.us_3EB07F07A51F480F2641', 'Тест', 1, 0, 0, '77770188219@c.us', 1607331911, '77770188219@c.us', 192, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(8, 'true_77750188218@c.us_3EB0699A764D93E811C1', 'Аааа', 1, 1, 0, '77771298943@c.us', 1607332713, '77750188218@c.us', 193, 'chat', 'Hetreelis', NULL, NULL, NULL, NULL, 'Киса', '0'),
(9, 'false_77750188218@c.us_3EB0EC99C2CC22105897', 'добрый день', 1, 0, 0, '77750188218@c.us', 1607332790, '77750188218@c.us', 194, 'chat', 'Киса', NULL, NULL, NULL, NULL, 'Киса', '0'),
(10, 'true_77750188218@c.us_3EB090BB89DF87490100', 'ага', 1, 1, 0, '77771298943@c.us', 1607332803, '77750188218@c.us', 195, 'chat', 'Hetreelis', NULL, NULL, NULL, NULL, 'Киса', '0'),
(11, 'true_77750188218@c.us_3EB079C827548A61FAF3', 'фыв', 1, 1, 0, '77771298943@c.us', 1607332877, '77750188218@c.us', 196, 'chat', 'Hetreelis', NULL, NULL, NULL, NULL, 'Киса', '0'),
(12, 'false_77750188218@c.us_3EB0896E303AC1B42D5C', 'Здравствуйте', 1, 0, 0, '77750188218@c.us', 1607332949, '77750188218@c.us', 197, 'chat', 'Киса', NULL, NULL, NULL, NULL, 'Киса', '0'),
(13, 'false_77770188219@c.us_07D67D355AA6485BDAB622FCDA49BFC2', 'Ага', 0, 0, 0, '77770188219@c.us', 1607333011, '77770188219@c.us', 198, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(14, 'false_77770188219@c.us_89FAF71B7AB3B0A90522D14689A9957A', 'Йцу', 0, 0, 0, '77770188219@c.us', 1607333067, '77770188219@c.us', 199, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(15, 'false_77770188219@c.us_3EB0688D5B30AA6E0089', 'asd', 1, 0, 0, '77770188219@c.us', 1607333123, '77770188219@c.us', 200, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(16, 'true_77770188219@c.us_3EB06C4FE99C1B2F7B2C', 'Ответить надо бы', 1, 1, 0, '77771298943@c.us', 1607333140, '77770188219@c.us', 201, 'chat', 'Hetreelis', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(17, 'false_77770188219@c.us_3EB025C9EE206974D416', 'ячс', 1, 0, 0, '77770188219@c.us', 1607333188, '77770188219@c.us', 202, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(18, 'false_77770188219@c.us_3EB0F3EB348038B5ED6D', 'ыквуцк', 1, 0, 0, '77770188219@c.us', 1607333207, '77770188219@c.us', 203, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(19, 'false_77770188219@c.us_3EB067B8EBC3DD772A43', 'asd', 1, 0, 0, '77770188219@c.us', 1607333482, '77770188219@c.us', 204, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(20, 'false_77770188219@c.us_3EB06CA102376F82B55B', 'sdaf', 1, 0, 0, '77770188219@c.us', 1607333633, '77770188219@c.us', 205, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(21, 'true_77770188219@c.us_3EB075FA07709AF6E3D9', 'Агась', 1, 1, 0, '77771298943@c.us', 1607333647, '77770188219@c.us', 206, 'chat', 'Hetreelis', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(22, 'false_77770188219@c.us_3EB0952F6EFC3F3DB915', 'фывэ', 1, 0, 0, '77770188219@c.us', 1607333726, '77770188219@c.us', 207, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(23, 'false_77770188219@c.us_3EB0F5D530AE3BF43875', 'ывф', 1, 0, 0, '77770188219@c.us', 1607333789, '77770188219@c.us', 208, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(24, 'true_77750188218@c.us_3EB01D9E9C3E194B32D4', 'Проверим 2 клиента', 1, 1, 0, '77771298943@c.us', 1607333830, '77750188218@c.us', 209, 'chat', 'Hetreelis', NULL, NULL, NULL, NULL, 'Киса', '0'),
(25, 'false_77770188219@c.us_3EB0A58F411F4A202BE8', 'asdf', 1, 0, 0, '77770188219@c.us', 1607333841, '77770188219@c.us', 210, 'chat', 'ЛЮБИМЫЙ МУЖ!!!!!!', NULL, NULL, NULL, NULL, 'ЛЮБИМЫЙ МУЖ!!!!!!', '0'),
(26, 'false_77750188218@c.us_3EB0316A8C2CA57230E1', 'какие', 1, 0, 0, '77750188218@c.us', 1607333898, '77750188218@c.us', 211, 'chat', 'Киса', NULL, NULL, NULL, NULL, 'Киса', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_menus`
--

CREATE TABLE `flash_cms_table_menus` (
  `id` int(2) NOT NULL,
  `menu_item` varchar(50) DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `is_parent` enum('0','1') DEFAULT '0',
  `parent_id` int(2) DEFAULT 0,
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
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `page_content` text NOT NULL,
  `views` int(7) DEFAULT 0,
  `comments` int(7) DEFAULT 0,
  `author` varchar(100) DEFAULT NULL,
  `creation_date` datetime DEFAULT current_timestamp(),
  `edit_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `need_comments` enum('0','1') DEFAULT '0',
  `need_info_line` enum('0','1') DEFAULT '0',
  `page_type` varchar(100) NOT NULL,
  `page_type_name` varchar(100) NOT NULL,
  `active` tinyint(1) DEFAULT 0
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
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
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
  `category_id` int(3) NOT NULL DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `photos` varchar(255) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `price` int(10) DEFAULT 0,
  `self_price` int(10) NOT NULL DEFAULT 0,
  `anons` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta_kw` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `top` enum('0','1') NOT NULL DEFAULT '0',
  `new` enum('0','1') NOT NULL DEFAULT '0',
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `need_comments` enum('0','1') NOT NULL DEFAULT '0',
  `need_info_line` enum('0','1') NOT NULL DEFAULT '0',
  `availability` int(7) NOT NULL DEFAULT 0,
  `imported` enum('0','1') NOT NULL DEFAULT '0',
  `import_source` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_shop_goods`
--

INSERT INTO `flash_cms_table_shop_goods` (`id`, `category_id`, `name`, `photos`, `code`, `price`, `self_price`, `anons`, `description`, `meta_kw`, `meta_description`, `top`, `new`, `active`, `need_comments`, `need_info_line`, `availability`, `imported`, `import_source`) VALUES
(30, 1, 'dfgdf gsdfg', '31,32,33,34,35', 'jXbfNsaOjU30', 123123, 312, 'sadfsdf', 'asdfasdf', NULL, NULL, '1', '0', '1', '0', '0', 123, '0', NULL);

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
  `authKey` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `lastLogin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flash_cms_table_users`
--

INSERT INTO `flash_cms_table_users` (`id`, `username`, `secret`, `authKey`, `email`, `lastLogin`) VALUES
(1, 'flashadmin', '$2y$13$D8jgVSD/aZ5HBkgg4l2ml.8Rjnt3vwEkLffZM3Nkc9IRPUutw4Jxm', NULL, NULL, NULL);

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
('m000000_000000_base', 1604983375);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `flash_cms_table_base_pages`
--
ALTER TABLE `flash_cms_table_base_pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_chats_info`
--
ALTER TABLE `flash_cms_table_chats_info`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_cms_table_chats_messages`
--
ALTER TABLE `flash_cms_table_chats_messages`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `id` (`id`);

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
-- AUTO_INCREMENT для таблицы `flash_cms_table_chats_info`
--
ALTER TABLE `flash_cms_table_chats_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chats_messages`
--
ALTER TABLE `flash_cms_table_chats_messages`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

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
