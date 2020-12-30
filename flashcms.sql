-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 30 2020 г., 05:46
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
('fullAdmin', '1', 1609302648),
('instanceAdmin', '2', 1609302648),
('instanceAdmin', '3', 1609302648),
('instanceAdmin', '4', 1609302648),
('instanceAdmin', '40', 1609302857),
('instanceOperator', '5', 1609302648),
('instanceOperator', '6', 1609302648),
('instanceOperator', '7', 1609302648);

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
('chatAdmin', 2, 'Администратор инстанса бота', NULL, NULL, 1609302647, 1609302647),
('chatOperator', 2, 'Оператор чат бота', NULL, NULL, 1609302647, 1609302647),
('fullAdmin', 1, 'Роль администратора системы', NULL, NULL, 1609302647, 1609302647),
('instanceAdmin', 1, 'Роль администратора чата', NULL, NULL, 1609302647, 1609302647),
('instanceOperator', 1, 'Роль оператор чата', NULL, NULL, 1609302647, 1609302647),
('systemAdmin', 2, 'Администратор системы', NULL, NULL, 1609302647, 1609302647);

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
('fullAdmin', 'instanceAdmin'),
('fullAdmin', 'instanceOperator'),
('fullAdmin', 'systemAdmin'),
('instanceAdmin', 'chatAdmin'),
('instanceAdmin', 'instanceOperator'),
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


CREATE TABLE `flash_cms_table_bwa_bot_last_message` (
  `id` int(5) NOT NULL,
  `chat_id` varchar(255) DEFAULT NULL,
  `message_number` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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

-- --------------------------------------------------------

--
-- Структура таблицы `flash_cms_table_chat_inst_collation`
--

CREATE TABLE `flash_cms_table_chat_inst_collation` (
  `id` int(10) NOT NULL,
  `inst_name` varchar(20) DEFAULT NULL,
  `user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
(1, 'flashadmin', '$2y$13$2hoKoF5MJnoWviVudNOinO5o/FnvsbPubmM/1hSgZpoYoWZFz/9VO', 'Администартор системы', '', NULL, NULL, NULL),

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chats_messages`
--
ALTER TABLE `flash_cms_table_chats_messages`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chat_instances`
--
ALTER TABLE `flash_cms_table_chat_instances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_chat_inst_collation`
--
ALTER TABLE `flash_cms_table_chat_inst_collation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `flash_cms_table_users`
--
ALTER TABLE `flash_cms_table_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
