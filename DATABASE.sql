-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 01:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ress`
--

-- --------------------------------------------------------

--
-- Table structure for table `callendar_users_member`
--

CREATE TABLE `callendar_users_member` (
  `id` int(11) UNSIGNED NOT NULL,
  `member_login_name` text NOT NULL,
  `member_first_name` text NOT NULL,
  `member_last_name` text NOT NULL,
  `member_telephone` text NOT NULL,
  `member_email` text NOT NULL,
  `member_email_ok` int(11) DEFAULT NULL,
  `member_institution` text DEFAULT NULL,
  `member_address_institution` text DEFAULT NULL,
  `member_invoice` text DEFAULT NULL,
  `member_employee_position` text DEFAULT NULL,
  `member_description` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_callendar`
--

CREATE TABLE `event_callendar` (
  `id` int(11) UNSIGNED NOT NULL,
  `callendar_name` text DEFAULT NULL,
  `work_dayStart` time DEFAULT NULL,
  `work_dayEnd` time DEFAULT NULL,
  `lunch_breakStart` time DEFAULT NULL,
  `lunch_breakEnd` time DEFAULT NULL,
  `prepare_time` int(11) DEFAULT NULL,
  `registration_end_date` varchar(255) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_callendar`
--

INSERT INTO `event_callendar` (`id`, `callendar_name`, `work_dayStart`, `work_dayEnd`, `lunch_breakStart`, `lunch_breakEnd`, `prepare_time`, `registration_end_date`, `menu_id`, `place_id`, `addon_id`, `created`, `updated`) VALUES
(1, 'Registracija', '08:15:00', '16:45:00', '12:00:00', '13:00:00', 10, '1', 31, 19, 24, '2023-09-21 03:01:01', '2023-10-23 08:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `event_callendar_holidays`
--

CREATE TABLE `event_callendar_holidays` (
  `id` int(11) UNSIGNED NOT NULL,
  `month` int(11) DEFAULT NULL,
  `holiday` int(11) DEFAULT NULL,
  `holiday_name` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_callendar_holidays`
--

INSERT INTO `event_callendar_holidays` (`id`, `month`, `holiday`, `holiday_name`, `created`, `updated`) VALUES
(1, 10, 26, 'test', '2023-09-21 18:45:16', '2023-10-23 07:59:14'),
(2, 10, 30, 'bandomas', '2023-09-21 18:45:16', '2023-10-23 07:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `event_callendar_item`
--

CREATE TABLE `event_callendar_item` (
  `id` int(11) UNSIGNED NOT NULL,
  `laboratories_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `methodical_material` text DEFAULT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `target_audience` text DEFAULT NULL,
  `metodic_file_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_callendar_item`
--

INSERT INTO `event_callendar_item` (`id`, `laboratories_id`, `title`, `short_description`, `methodical_material`, `time_limit`, `target_audience`, `metodic_file_id`, `image_id`, `created`, `updated`) VALUES
(1, 1, 'Testuoju Pavadinima', 'Trumpas aprašymas', 'dgffg455', 180, '6-9', NULL, 27, '2023-09-21 15:27:16', '2023-09-23 08:00:10'),
(2, 1, 'Trumpas ar koks pavadinimas', 'Trumpas aprašymas 2', '45nkjkjkbvbvbv', 90, '7-8', NULL, 28, '2023-09-21 15:27:16', '2023-09-22 20:27:45'),
(3, 1, 'Bandomasis įrašas antraštei', 'testukas su kitu', 'bvbvbbvbv555', 45, '10-12', NULL, 27, '2023-09-21 17:50:05', '2023-10-04 06:36:35'),
(4, 2, 'laboratorijos temos antraštė', 'Bandome trumpą aprašymą apie veiklos pobūdį', 'erertrte ertertrete  erterte e err', 45, '11-12', NULL, 28, '2023-09-21 18:36:58', '2023-09-22 20:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `event_callendar_laboratories`
--

CREATE TABLE `event_callendar_laboratories` (
  `id` int(11) UNSIGNED NOT NULL,
  `callendar_id` int(11) DEFAULT NULL,
  `event_name` text DEFAULT NULL,
  `managers` varchar(255) DEFAULT NULL,
  `when_event_will_start` date DEFAULT NULL,
  `event_days` text NOT NULL,
  `event_color` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_callendar_laboratories`
--

INSERT INTO `event_callendar_laboratories` (`id`, `callendar_id`, `event_name`, `managers`, `when_event_will_start`, `event_days`, `event_color`, `created`, `updated`) VALUES
(1, 1, 'Mechatronika', '1,22', '2023-10-15', '32', 'blue', '2023-09-21 03:12:48', '2023-10-23 07:56:32'),
(2, 1, 'Gamtamokslinė', '1', '2023-10-15', '31', 'yellow', '2023-09-21 03:12:48', '2023-10-23 07:55:35'),
(3, 1, 'Žalioji energetika', '1', '2023-10-15', '25', 'green', '2023-09-21 03:12:48', '2023-10-23 07:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `event_reservation_time`
--

CREATE TABLE `event_reservation_time` (
  `id` int(11) UNSIGNED NOT NULL,
  `event_laboratory_id` int(11) DEFAULT NULL,
  `event_item_id` int(11) DEFAULT NULL,
  `reserve_event_time` time DEFAULT NULL,
  `reserve_date` date DEFAULT NULL,
  `reservation_description` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_reservation_time`
--

INSERT INTO `event_reservation_time` (`id`, `event_laboratory_id`, `event_item_id`, `reserve_event_time`, `reserve_date`, `reservation_description`, `created`, `updated`) VALUES
(6, 1, 2, '13:00:00', '2023-10-31', 'dfgsfdg', '2023-09-23 08:02:39', '2023-10-18 11:58:57'),
(10, 1, 3, '09:10:00', '2023-10-31', 'dfgsfdg', '2023-09-23 08:02:39', '2023-10-18 11:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `flussi_contact_form_settings`
--

CREATE TABLE `flussi_contact_form_settings` (
  `id` int(11) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_body` text NOT NULL,
  `email_success_message` varchar(255) NOT NULL,
  `email_error_message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flussi_contact_form_settings`
--

INSERT INTO `flussi_contact_form_settings` (`id`, `email_subject`, `email_body`, `email_success_message`, `email_error_message`) VALUES
(1, 'New message from Contact Form', 'We received a message from:', 'Email has been sent successfully', 'Failed to send the email');

-- --------------------------------------------------------

--
-- Table structure for table `flussi_files`
--

CREATE TABLE `flussi_files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flussi_files`
--

INSERT INTO `flussi_files` (`id`, `name`, `url`, `uploaded_at`) VALUES
(20, 'pexels-dominika-roseclay_2b7dd92bc8d188b4_b6617d36205e378a.jpg', 'http://localhost/uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4_b6617d36205e378a.jpg', '2023-08-08 08:20:20'),
(23, '7646653_f9f1c35fca142b93.jpg', 'http://localhost/uploads/7646653_f9f1c35fca142b93.jpg', '2023-08-09 17:33:11'),
(24, 'flusity-b_a252d067e7fe12f7_019b936138264d1f.png', 'http://localhost/uploads/flusity-b_a252d067e7fe12f7_019b936138264d1f.png', '2023-08-09 23:05:49'),
(25, 'facebook-1_d00a2bd3f98d49c6.png', 'http://localhost/uploads/facebook-1_d00a2bd3f98d49c6.png', '2023-08-27 16:39:00'),
(26, 'github_c1b0e9c17264fee5.png', 'http://localhost/uploads/github_c1b0e9c17264fee5.png', '2023-08-27 20:28:37'),
(27, 'image1_05f051a9605edf83.jpg', 'http://localhost/uploads/image1_05f051a9605edf83.jpg', '2023-09-13 07:10:57'),
(28, 'image2_17dc230bc4563906.jpg', 'http://localhost/uploads/image2_17dc230bc4563906.jpg', '2023-09-13 07:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `flussi_menu`
--

CREATE TABLE `flussi_menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `lang_menu_name` varchar(255) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flussi_menu`
--

INSERT INTO `flussi_menu` (`id`, `name`, `lang_menu_name`, `page_url`, `position`, `template`, `created_at`, `updated_at`, `show_in_menu`, `parent_id`) VALUES
(6, 'HOMES', NULL, 'index', 1, 'template_index', '2023-04-16 12:35:26', '2023-06-20 19:59:31', 1, 0),
(12, 'Contact', 'Kontaktai', 'contacts', 2, 'template_contacts', '2023-04-21 14:28:01', '2023-08-17 12:00:59', 1, 0),
(20, 'LOGIN', NULL, 'login', 3, 'template_login_form', '2023-08-08 16:03:28', '2023-08-17 09:39:10', 0, 0),
(31, 'Callendar', 'Kalendorius', 'event-callendar', 4, 'template_callendar', '2023-09-16 11:18:26', '2023-09-16 11:18:26', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `flussi_places`
--

CREATE TABLE `flussi_places` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flussi_places`
--

INSERT INTO `flussi_places` (`id`, `name`, `created_at`, `updated_at`) VALUES
(7, 'contact-right-5', '2023-05-28 08:28:19', '2023-05-28 08:28:19'),
(8, 'contact-left-7', '2023-05-28 08:30:01', '2023-05-28 08:30:01'),
(12, 'footer-col4-1', '2023-07-13 12:10:02', '2023-07-13 12:10:02'),
(13, 'footer-col4-2', '2023-07-13 12:10:09', '2023-07-13 12:10:09'),
(14, 'footer-col4-3', '2023-07-13 12:10:13', '2023-07-13 12:10:13'),
(15, 'head-pulse-animated', '2023-08-07 19:45:30', '2023-08-07 19:45:30'),
(16, 'right-my-history', '2023-08-07 19:48:00', '2023-08-07 19:48:00'),
(17, 'home-content-bottom', '2023-09-13 14:09:16', '2023-09-13 14:09:16'),
(18, 'home-content-top', '2023-09-14 18:30:50', '2023-09-14 18:30:50'),
(19, 'callendar-full-12', '2023-09-16 11:22:43', '2023-09-16 11:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `flussi_posts`
--

CREATE TABLE `flussi_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `lang_post_title` text DEFAULT NULL,
  `lang_post_content` text DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `menu_id` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `priority` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flussi_posts`
--

INSERT INTO `flussi_posts` (`id`, `title`, `content`, `lang_post_title`, `lang_post_content`, `author_id`, `role`, `created_at`, `status`, `menu_id`, `tags`, `updated_at`, `description`, `keywords`, `priority`) VALUES
(2, 'New attempt', '&lt;p&gt;&lt;b&gt;Lorem&lt;/b&gt; ipsum dolor sit amet, consectetur adipiscing elit.&lt;/p&gt;\n\n\n\n&lt;img src=&quot;uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4_b6617d36205e378a.jpg&quot; title=&quot; &quot; alt=&quot; &quot; width=&quot;250px&quot; height=&quot;auto&quot; align=&quot;left&quot; hspace=&quot;15&quot; vspace=&quot;15&quot;/&gt;\n\n\n\n&lt;p&gt;Aliquam ultricies justo ut purus efficitur, eleifend pellentesque risus cursus. Maecenas ex massa, sagittis id metus non, convallis scelerisque ligula. Vivamus aliquam risus accumsan lacinia eleifend. Nunc vestibulum massa a mauris egestas, quis sollicitudin est posuere. Duis lobortis tincidunt leo, vitae condimentum odio mollis at. Nullam mollis lobortis erat, lobortis mollis mi commodo ac. Nunc in lectus vitae mauris imperdiet varius in id neque. Vestibulum orci risus, posuere in velit eget, ullamcorper convallis augue. Mauris nulla dui, iaculis ac ultrices quis, scelerisque a libero.&lt;/p&gt;', NULL, NULL, 2, 'admin', '2023-01-01 11:03:58', 'published', 6, NULL, '2023-08-22 16:52:14', 'Flusity is a contemporary PHP CMS project utilizing MVC architecture, MySQL database, and Bootstrap front-end framework. It includes the management of users, posts, menu, blocks and other elements, as well as security and SEO features.', 'free cms flusity, php cms, cms, website', 1),
(16, 'Lorem ipsum dolor sit', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur magnam, excepturi aliquid ex itaque esse est vero natus quae optio aperiam soluta voluptatibus corporis atque iste neque sit tempora!&lt;/p&gt;', 'Lorem ipsum dolor sit LT', '&lt;p&gt;LT Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur magnam, excepturi aliquid ex itaque esse est vero natus quae optio aperiam soluta voluptatibus corporis atque iste neque sit tempora!&lt;/p&gt;', 1, 'admin', '2023-08-08 19:51:48', 'published', 6, 'word', '2023-10-24 09:54:17', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `flussi_settings`
--

CREATE TABLE `flussi_settings` (
  `site_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `footer_text` text NOT NULL,
  `pretty_url` int(1) NOT NULL DEFAULT 0,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `posts_per_page` int(11) NOT NULL DEFAULT 10,
  `registration_enabled` tinyint(1) DEFAULT 1,
  `session_lifetime` int(11) DEFAULT 1800,
  `default_keywords` text DEFAULT NULL,
  `theme` varchar(255) DEFAULT 'default_theme',
  `brand_icone` varchar(255) DEFAULT NULL,
  `table_prefix` varchar(255) DEFAULT NULL,
  `bilingualism` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flussi_settings`
--

INSERT INTO `flussi_settings` (`site_title`, `meta_description`, `footer_text`, `pretty_url`, `language`, `posts_per_page`, `registration_enabled`, `session_lifetime`, `default_keywords`, `theme`, `brand_icone`, `table_prefix`, `bilingualism`) VALUES
('Free CMS flusity', 'Flusity is a contemporary PHP CMS project utilizing MVC architecture, MySQL database, and Bootstrap front-end framework. It includes the management of users, posts, menu, blocks and other elements, as well as security and SEO features.', 'Copyright &copy; flusity JD Theme 2023', 1, 'en', 10, 1, 30, 'free cms, php, free website, cms, content management system, free cms flusity, php cms, website ', 'free-time', 'flusity-b_a252d067e7fe12f7_019b936138264d1f.png', 'jdfsite', 1);

-- --------------------------------------------------------

--
-- Table structure for table `flussi_sidebar`
--

CREATE TABLE `flussi_sidebar` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flussi_sidebar`
--

INSERT INTO `flussi_sidebar` (`id`, `title`, `icon`, `url`, `parent_id`, `order_number`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', '/admin.php', NULL, 1),
(2, 'Posts', 'fas fa-newspaper', '/core/tools/posts.php', NULL, 2),
(3, 'Block', 'fas fa-shapes', '/core/tools/customblock.php', NULL, 3),
(4, 'Files', 'fas fa-folder', '/core/tools/files.php', NULL, 4),
(5, 'Core Settings', 'fas fa-cog', NULL, NULL, 5),
(6, 'Users', 'fas fa-users', '/core/tools/users.php', 5, 1),
(7, 'Menu', 'fas fa-bars', '/core/tools/menu.php', 5, 2),
(8, 'AddOns', 'fas fa-puzzle-piece', '/core/tools/addons.php', 5, 3),
(9, 'Contact Form', 'fas fa-message', '/core/tools/contact_form.php', 5, 5),
(10, 'Layout Places', 'fas fa-tags', '/core/tools/places.php', 5, 6),
(11, 'Themes', 'fa-solid fa-brush', '/core/tools/themes.php', 5, 7),
(12, 'Settings', 'fas fa-cog', '/core/tools/settings.php', 5, 8),
(13, 'Language', 'fas fa-language', '/core/tools/language.php', 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `flussi_tjd_addons`
--

CREATE TABLE `flussi_tjd_addons` (
  `id` int(11) NOT NULL,
  `name_addon` varchar(255) DEFAULT NULL,
  `description_addon` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `version` varchar(50) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `show_front` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flussi_tjd_addons`
--

INSERT INTO `flussi_tjd_addons` (`id`, `name_addon`, `description_addon`, `active`, `version`, `author`, `created_at`, `updated_at`, `show_front`) VALUES
(14, 'jd_simple_zer', 'This test addon', 1, '1v', 'JD Flusite Zer', '2023-08-08 16:52:26', '2023-08-08 16:52:37', 1),
(16, 'social_block_links', 'Social block links addon', 1, '1v', 'JD Flusite', '2023-09-01 10:53:39', '2023-09-01 10:53:45', 1),
(19, 'info_media_gallery', 'Gallery info with description', 1, '1v', 'JD Flusity', '2023-09-13 18:40:54', '2023-09-13 18:40:59', 1),
(24, 'event_callendar', 'Events callendar addon', 1, '1v', 'JD Flusity', '2023-09-21 13:31:15', '2023-09-21 13:31:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `flussi_translations`
--

CREATE TABLE `flussi_translations` (
  `id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `translation_key` varchar(255) NOT NULL,
  `translation_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flussi_translations`
--

INSERT INTO `flussi_translations` (`id`, `language_code`, `translation_key`, `translation_value`) VALUES
(1, 'lt', 'Language', 'Kalba'),
(2, 'lt', 'Users', 'Vartotojai'),
(4, 'lt', 'Dashboard', 'Prietaisų skydelis'),
(5, 'lt', 'Translation Key', 'Verčiamas žodis'),
(6, 'lt', 'Translation Value', 'Išverstas įrašas'),
(7, 'lt', 'Language Code', 'Kalbos Kodas'),
(8, 'lt', 'Translation form', 'Vertimo forma'),
(9, 'lt', 'Settings successfully updated!', 'Nustatymai sėkmingai atnaujinti!'),
(10, 'lt', 'Page Name', 'Puslapio pavadinimas'),
(11, 'lt', 'Settings', 'Nustatymai'),
(12, 'lt', 'Contact Form', 'Kontaktų forma'),
(13, 'lt', 'Posts', 'Įrašai'),
(14, 'lt', 'Menu', 'Meniu'),
(15, 'lt', 'Username', 'Vardas'),
(16, 'lt', 'META description', 'META aprašymas'),
(17, 'lt', 'Footer text', 'Apačios tekstas'),
(18, 'lt', 'Pretty URL', 'Gražus URL'),
(19, 'lt', 'Home Page', 'Puslapio priekis'),
(20, 'lt', 'Menu items', 'Meniu vienetai'),
(21, 'lt', 'User\'s', 'Vartotojai'),
(22, 'lt', 'Administration tools', 'Administravimo įrankiai'),
(23, 'lt', 'Post\'s', 'Įrašai'),
(24, 'lt', 'Block\'s', 'Blokai'),
(25, 'lt', 'Usename', 'Vartotojo Vardas'),
(26, 'lt', 'User successfully updated.', 'Vartotojas sėkmingai atnaujintas.'),
(27, 'lt', 'Actions', 'Veiksmas'),
(28, 'lt', 'Places', 'Vietos'),
(29, 'lt', 'Name', 'Pavadinimas'),
(30, 'lt', 'Translation added successfully.', 'Vertimas sėkmingai pridėtas.'),
(31, 'lt', 'Error: Please fill in all fields.', 'Klaida: užpildykite visus laukus.'),
(32, 'lt', 'Are you sure you want to delete this place?', 'Ar tikrai norite ištrinti šią Vietą?'),
(33, 'lt', 'Add/Edit', 'Pridėti/Redaguoti'),
(34, 'lt', 'Translation updated successfully.', 'Vertimas sėkmingai atnaujintas.'),
(35, 'lt', 'Edit', 'Redaguoti'),
(36, 'lt', 'Delete', 'Ištrinti'),
(37, 'lt', 'Code', 'Kodas'),
(38, 'lt', 'No.', 'Nr.'),
(39, 'lt', 'Update Settings', 'Atnaujinti nustatymus'),
(40, 'lt', 'Clear Cache', 'Išvalyti Talpykla'),
(41, 'lt', 'Create a backup', 'Sukurti DB kopiją'),
(42, 'lt', 'Files', 'Failai'),
(43, 'lt', 'File list', 'Failų sąrašas'),
(44, 'lt', 'Select a file:', 'Pasirinkite failą:'),
(45, 'lt', 'Upload file', 'Įkelti failą'),
(46, 'lt', 'Preview', 'Peržiūra'),
(47, 'lt', 'Copy url', 'Kopijuoti url'),
(48, 'lt', 'Contact form', 'Kontaktinė forma'),
(49, 'lt', 'Key', 'Raktas'),
(50, 'lt', 'Value', 'Vertė'),
(51, 'lt', 'Save settings', 'Išsaugoti nustatymus'),
(52, 'lt', 'HTML Code', 'HTML kodas'),
(53, 'lt', 'Menu Place', 'Meniu vieta'),
(54, 'lt', 'Place', 'Vieta'),
(55, 'lt', 'Log off', 'Atsijungti'),
(56, 'lt', 'Log In', 'Prisijungti'),
(57, 'lt', 'Sign up', 'Registruotis'),
(58, 'lt', 'or', 'arba'),
(59, 'lt', 'Page Menu', 'Puslapio meniu'),
(60, 'lt', 'Page URL', 'Puslapio url'),
(61, 'lt', 'Template', 'Šablonas'),
(62, 'lt', 'Position', 'Pozicija'),
(63, 'lt', 'Are you sure you want to delete this menu?', 'Ar tikrai norite ištrinti šį meniu?'),
(64, 'lt', 'Menu item successfully added.', 'Meniu punktas sėkmingai pridėtas.'),
(65, 'lt', 'Error adding menu item. Try again.', 'Klaida pridedant meniu punktą. Bandykite dar kartą.'),
(66, 'lt', 'Menu Name', 'Meniu pavadinimas'),
(67, 'lt', 'Add Menu', 'Pridėti meniu'),
(68, 'lt', 'Edit Menu', 'Redaguoti meniu'),
(69, 'lt', 'Place Name', 'Vietos pavadinimas'),
(70, 'lt', 'Posts on pages', 'Įrašai puslapiuose'),
(71, 'lt', 'Title', 'Antraštė'),
(72, 'lt', 'Content', 'Turinys'),
(73, 'lt', 'Author', 'Autorius'),
(74, 'lt', 'Public', 'Rodomas'),
(75, 'lt', 'Existing Tag\'s', 'Esančios žymos'),
(76, 'lt', 'Tags', 'Žymos'),
(77, 'lt', 'Page status', 'Puslapio būsena'),
(78, 'lt', 'Published', 'Publikuotas'),
(79, 'lt', 'Draft', 'Juodraštis'),
(80, 'lt', 'List of backups', 'Atsarginių kopijų sąrašas'),
(81, 'lt', 'No backups', 'Nėra atsarginių kopijų.'),
(82, 'lt', 'Custom Blocks', 'Įvairūs Blokai'),
(83, 'lt', 'Record successfully added.', 'Įrašas sėkmingai sukurtas.'),
(84, 'lt', 'Error adding Record. Try again.', 'Pridedant įrašą įvyko klaida. Bandyk iš naujo.'),
(85, 'lt', 'The record has been updated successfully.', 'Įrašas sėkmingai atnaujintas.'),
(86, 'lt', 'Error updating post. Try again.', 'Klaida atnaujinant įrašą. Bandyk iš naujo.'),
(87, 'lt', 'place successfully updated.', 'Vieta sėkmingai atnaujinta.'),
(88, 'lt', 'Backup deleted successfully!', 'Atsarginė kopija sėkmingai ištrinta!'),
(89, 'lt', 'Failed to delete backup.', 'Nepavyko ištrinti atsarginės kopijos.'),
(90, 'lt', 'Error: Please specify a file name.', 'Klaida: Prašome nurodyti failo pavadinimą.'),
(91, 'lt', 'Confirm deletion', 'Patvirtinkite šalinimą'),
(92, 'lt', 'place successfully deleted.', 'Vieta sėkmingai ištrinta.'),
(93, 'lt', 'Error deleting place. Try again.', 'Klaida trinant maketo vietą. Bandykite dar kartą.'),
(94, 'lt', 'Edit Place', 'Redaguoti Vietą'),
(95, 'lt', 'File not found.', 'Failas nerastas.'),
(96, 'lt', 'Surname', 'Pavardė'),
(97, 'lt', 'Phone', 'Telefonas'),
(98, 'lt', 'Email', 'El.paštas'),
(99, 'lt', 'Role', 'Teisės'),
(100, 'lt', 'Update User', 'Atnaujinti vartotoją'),
(101, 'lt', 'Cancel', 'Atšaukti'),
(102, 'lt', 'Password', 'Slaptažodis'),
(103, 'lt', 'Confirm Password', 'Patvirtinti slaptažodį'),
(104, 'lt', 'User successfully updated.', 'Vartotojas sėkmingai atnaujintas.'),
(105, 'lt', 'Error updating user. Try again.', 'Klaida atnaujinant naudotoją. Bandyk iš naujo.'),
(106, 'lt', 'Confirm new password', 'Patvirtinti naują slaptažodį'),
(107, 'lt', 'Enter new password', 'Įveskite naują slaptažodį'),
(108, 'lt', 'Admin', 'Adminas'),
(109, 'lt', 'Moderator', 'Moderatorius'),
(110, 'lt', 'User', 'Vartotojas'),
(111, 'lt', 'User not found.', 'Vartotojas nerastas.'),
(112, 'lt', 'The passwords do not match. Try again.', 'Slaptažodžiai nesutampa. Bandyk iš naujo.'),
(113, 'lt', 'Error deleting Custom Block. Try again.', 'Klaida ištrinant pasirinktinį bloką. Bandyk iš naujo.'),
(114, 'lt', 'Custom Block successfully deleted.', 'Pasirinktinis blokas sėkmingai ištrintas.'),
(115, 'lt', 'Menu item successfully deleted.', 'Meniu punktas sėkmingai ištrintas.'),
(116, 'lt', 'Error deleting menu item. Try again.', 'Klaida trinant meniu punktą. Bandykite dar kartą.'),
(117, 'lt', 'Page deleted successfully.', 'Puslapis sėkmingai ištrintas.'),
(118, 'lt', 'Error deleting page. Try again.', 'Klaida trinant puslapį. Bandykite dar kartą.'),
(119, 'lt', 'Failed to delete translation.', 'Nepavyko ištrinti vertimo.'),
(120, 'lt', 'Translation successfully deleted.', 'Vertimas sėkmingai ištrintas.'),
(121, 'lt', 'Error: Please specify translation ID.', 'Klaida: Prašome nurodyti vertimo ID.'),
(122, 'lt', 'Error: Please specify a file name.', 'Klaida: Prašome nurodyti failo pavadinimą.'),
(123, 'lt', 'File', 'Failas'),
(124, 'lt', 'deleted successfully.', 'sėkmingai ištrintas.'),
(125, 'lt', 'Error deleting file from database.', 'Klaida trinant failą iš duomenų bazės.'),
(126, 'lt', 'Error deleting file from system.', 'Klaida trinant failą iš sistemos.'),
(127, 'lt', 'No such file found.', 'Toks failas nerastas.'),
(128, 'lt', 'No file ID specified.', 'Nenurodytas failo ID.'),
(129, 'lt', 'The menu item has been updated successfully.', 'Meniu punktas sėkmingai atnaujintas.'),
(130, 'lt', 'Error updating menu item. Try again.', 'Klaida atnaujinant meniu punktą. Bandykite dar kartą.'),
(131, 'lt', 'Error updating post. Try again.', 'Klaida atnaujinant įrašą. Bandyk iš naujo.'),
(132, 'lt', 'The record has been updated successfully.', 'Įrašas sėkmingai atnaujintas.'),
(133, 'lt', 'User successfully updated.', 'Vartotojas sėkmingai atnaujintas.'),
(134, 'lt', 'Error updating user. Try again.', 'Klaida atnaujinant naudotoją. Bandyk iš naujo.'),
(135, 'lt', 'uploaded successfully.', 'sėkmingai įkeltas.'),
(136, 'lt', 'Error loading file.', 'Klaida įkeliant failą.'),
(137, 'lt', 'Are you sure you want to delete this User?', 'Ar tikrai norite ištrinti šį naudotoją?'),
(138, 'lt', 'Confirm the removal', 'Patvirtinkite pašalinimą'),
(139, 'lt', 'Invalid Login Name/email or password.', 'Neteisingas Prisijungimo Vardas/el. paštas arba slaptažodis.'),
(140, 'lt', 'Login system', 'Prisijungimo sistema'),
(141, 'lt', 'The content management system is intended for personal websites', 'Turinio valdymo sistema skirta asmeninėms svetainėms'),
(142, 'lt', 'Login', 'Prisijungti'),
(143, 'lt', 'Home page', 'Pagrindinis puslapis'),
(144, 'lt', 'Connect to page', 'Prisijungimas'),
(145, 'lt', 'User Name', 'Vartotojo Vardas'),
(146, 'lt', 'Back to', 'Grįžti į'),
(147, 'lt', 'That Name is already taken. Choose another.', 'Toks Vardas jau užimtas. Pasirinkite kitą.'),
(148, 'lt', 'User registration failed. Try again.', 'Vartotojo registracija nepavyko. Bandykite dar kartą.'),
(149, 'lt', 'Passwords do not match. Try again.', 'Slaptažodžiai nesutampa. Bandykite dar kartą.'),
(150, 'lt', 'Registration system', 'Registracijos sistema'),
(151, 'lt', 'Content management system for personal websites', 'Turinio valdymo sistema skirta asmeninėms svetainėms'),
(152, 'lt', 'Registration', 'Registracija'),
(153, 'lt', 'Repeat the password', 'Pakartokite slaptažodį'),
(154, 'lt', 'Register', 'Registruotis'),
(155, 'lt', 'Sign out', 'Atsijungti'),
(156, 'lt', 'Log In', 'Prisijungti'),
(157, 'lt', 'Sign up', 'Registruotis'),
(158, 'lt', 'Hello!', 'Sveiki!'),
(159, 'lt', 'Front page', 'Puslapio priekis'),
(160, 'lt', 'Log out', 'Atsijungti'),
(161, 'lt', 'or', 'arba'),
(162, 'lt', 'Post status', 'Įrašo būsena'),
(163, 'lt', 'Update Post', 'Atnaujinti įrašą'),
(164, 'lt', 'Add Post', 'Pridėti įrašą'),
(165, 'lt', 'Back', 'Grįžti'),
(166, 'lt', 'Search translations...', 'Ieškoti vertimo...'),
(167, 'lt', 'Cache cleared successfully!', 'Talpykla sėkmingai išvalyta!'),
(168, 'lt', 'Failed to clear cache, APCu is not installed!', 'Nepavyko išvalyti cache, APCu nėra įdiegta!'),
(169, 'lt', 'Backup successfully created.', 'Atsarginė kopija sėkmingai sukurta.'),
(170, 'lt', 'Failed to create a backup.', 'Nepavyko sukurti atsarginės kopijos.'),
(171, 'lt', 'Website Name', 'Svetainės pavadinimas'),
(172, 'lt', 'file uploaded successfully.', 'failas sėkmingai įkeltas.'),
(173, 'lt', 'Error loading file.', 'Įkeliant failą įvyko klaida.'),
(174, 'lt', 'Failed to clear cache, APCu is not installed!', 'Nepavyko išvalyti talpyklos, APCu neįdiegtas!'),
(175, 'lt', 'Create', 'Sukurti'),
(176, 'lt', 'Error adding place. Try again.', 'Klaida pridedant vietą. Bandyk iš naujo.'),
(177, 'lt', 'Place successfully added.', 'Vieta sėkmingai pridėta.'),
(178, 'lt', 'place successfully updated.', 'Vieta sėkmingai atnaujinta.'),
(179, 'lt', 'place with this name already exists. Try a different name.', 'Vieta tokiu pavadinimu jau yra. Pabandykite kitą pavadinimą.'),
(180, 'lt', 'Error updating place. Try again.', 'Klaida atnaujinant Vietą. Bandyk iš naujo.'),
(181, 'lt', 'Please fill in all fields.', 'Klaida: užpildykite visus laukus.'),
(182, 'lt', 'Translation added successfully.', 'Vertimas sėkmingai pridėtas.'),
(183, 'lt', 'Error: Translation word already exists.', 'Klaida: verčiamas žodis jau yra.'),
(184, 'lt', 'Block', 'Blokai'),
(185, 'lt', 'Core Settings', 'Sistemos įrankiai'),
(186, 'lt', 'Lines per page:', 'Eilučių per puslapį:'),
(187, 'lt', 'Add new code', 'Pridėti naują kodą'),
(188, 'lt', 'That Name or Login Name is already taken. Choose another.', 'Tas vardas arba prisijungimo vardas jau užimtas. Pasirinkite kitą.'),
(189, 'lt', 'Invalid CSRF token. Try again.', 'Neteisingas CSRF žetonas. Bandykite dar kartą.'),
(190, 'lt', 'Login Name', 'Prisijungimo Vardas'),
(191, 'lt', 'Login Name or Email', 'Prisijungimo Vardas / El.paštas'),
(192, 'lt', 'Add Place', 'Pridėti Vietą'),
(193, 'lt', 'Posts per page', 'Įrašai per puslapį'),
(194, 'lt', 'Layout Places', 'Maketo Vietos'),
(195, 'lt', 'Profile', 'Profilis'),
(196, 'lt', 'User Area', 'Vartotojo aplinka'),
(197, 'lt', 'You\'ve wandered off into tropical limbo! Nothing to see here.', 'Jūs nuklydote į tropinę nežinią! Nieko jūs čia nepamatysite.'),
(198, 'lt', 'to return back home.', 'kad grįžti atgal į pagrindinį puslapį'),
(199, 'lt', 'Click', 'Spauskite'),
(200, 'lt', 'here', 'čia'),
(201, 'lt', 'Show', 'Rodomas'),
(202, 'lt', 'Parent', 'Tėvinis puslapis'),
(203, 'lt', 'User registration successful. You can now log in.', 'Vartotojo registracija sėkminga. Dabar galite prisijungti.'),
(204, 'lt', 'Registration Enabled', 'Registracija leidžiama'),
(205, 'lt', 'Session lifetime in minutes', 'Sesijos trukmė minutėmis'),
(206, 'lt', 'META Default keywords', 'META Numatytieji raktažodžiai'),
(207, 'lt', 'No tags have been created', 'Nėra sukurta nei vieno Tag žymos'),
(208, 'lt', 'Edit your Tags', 'Redaguokite savo žymas'),
(209, 'lt', 'Registration is currently suspended. Please try again later', 'Šiuo metu registracija sustabdyta. Pabandykite dar kartą vėliau'),
(211, 'lt', 'Addons', 'Papildiniai'),
(212, 'lt', 'AddOns', 'Papildiniai'),
(213, 'lt', 'Themes', 'Išvaizda'),
(214, 'lt', 'No addons found in the system.', 'Sistemoje nerasta jokių priedų.'),
(215, 'lt', 'Website addons', 'Svetainės papildiniai'),
(216, 'lt', 'To all pages', 'Visuose puslapiuose'),
(217, 'lt', 'All pages', 'Visi puslapiai'),
(218, 'lt', 'Contact', 'Kontaktai'),
(219, 'lt', 'HOMES', 'Pagrindinis'),
(223, 'it', 'HOMES', 'CASA'),
(224, 'it', 'Dashboard', 'Pannello'),
(225, 'lt', 'Media item&nbsp;', 'Žiniasklaidos elementas&nbsp;'),
(226, 'lt', 'Gallery name', 'Galerijos pavadinimas'),
(227, 'lt', 'Add content in another language', 'Pridėti turinį kita kalba'),
(228, 'lt', 'Other languages Title', 'Antraštė kita kalba'),
(229, 'lt', 'Search for posts or pages', 'Įrašų arba puslapių paieška'),
(230, 'lt', 'Per page:', 'Puslapyje:'),
(231, 'lt', 'Search post...', 'Ieškoti įrašą...'),
(232, 'lt', 'Next Language', 'Kita kalba'),
(233, 'lt', 'Add new', 'Pridėti naują'),
(234, 'lt', 'Edit post', 'Redaguoti įrašą'),
(235, 'lt', 'Edit Addon', 'Redaguoti papildinį'),
(236, 'lt', 'Add Addon', 'Pridėti papildinį');

-- --------------------------------------------------------

--
-- Table structure for table `flussi_users`
--

CREATE TABLE `flussi_users` (
  `id` int(11) NOT NULL,
  `login_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flussi_users`
--

INSERT INTO `flussi_users` (`id`, `login_name`, `username`, `surname`, `phone`, `email`, `password`, `role`) VALUES
(1, 'Tester', 'Admin', 'tester', '8615523111', 'tests@gl.com', '$2y$10$4xw8Ssej8MPQBGHRnqXlieHU6qlKQUKpDgTIj8ZqJg0sCWU6WXIOa', 'admin'),
(22, 'Redag', 'Redaguojantysis', 'tester 2', '8615523111', 'tests2@gl.com', '$2y$10$4xw8Ssej8MPQBGHRnqXlieHU6qlKQUKpDgTIj8ZqJg0sCWU6WXIOa', 'moderator');

-- --------------------------------------------------------

--
-- Table structure for table `flussi_v_custom_blocks`
--

CREATE TABLE `flussi_v_custom_blocks` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `place_id` int(10) UNSIGNED DEFAULT NULL,
  `html_code` text DEFAULT NULL,
  `lang_custom_name` text DEFAULT NULL,
  `lang_custom_content` text DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `flussi_v_custom_blocks`
--

INSERT INTO `flussi_v_custom_blocks` (`id`, `name`, `menu_id`, `place_id`, `html_code`, `lang_custom_name`, `lang_custom_content`, `updated`, `created`) VALUES
(36, 'testing area', 0, 12, 'test area content', NULL, NULL, '2023-09-05 18:55:20', '2023-09-13 19:33:08'),
(38, NULL, 6, 15, ' &lt;h1 class=&quot;pulse animated&quot;&gt;Your Website&lt;/h1&gt;&lt;span class=&quot;pulse animated subheading&quot;&gt;This is your web&lt;/span&gt;', NULL, ' &lt;h1 class=&quot;pulse animated&quot;&gt;Your Website&lt;/h1&gt;&lt;span class=&quot;pulse animated subheading&quot;&gt;This is your web En&lt;/span&gt;', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `info_media_gallery`
--

CREATE TABLE `info_media_gallery` (
  `id` int(11) UNSIGNED NOT NULL,
  `gallery_name` text DEFAULT NULL,
  `gallery_css_style_settings` text NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `img_w` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_media_gallery`
--

INSERT INTO `info_media_gallery` (`id`, `gallery_name`, `gallery_css_style_settings`, `menu_id`, `place_id`, `addon_id`, `img_w`, `created`, `updated`) VALUES
(1, 'testas 2', 'light', 6, 18, 19, 400, '2023-09-13 18:42:37', '2023-09-14 17:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `info_media_gallery_item`
--

CREATE TABLE `info_media_gallery_item` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` text DEFAULT NULL,
  `media_description` text NOT NULL,
  `lang_en_title` text DEFAULT NULL,
  `lang_en_media_description` text DEFAULT NULL,
  `hyperlink` text NOT NULL,
  `media_file_id` int(11) DEFAULT NULL,
  `id_info_media_gallery` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_media_gallery_item`
--

INSERT INTO `info_media_gallery_item` (`id`, `title`, `media_description`, `lang_en_title`, `lang_en_media_description`, `hyperlink`, `media_file_id`, `id_info_media_gallery`, `created`, `updated`) VALUES
(1, 'tess', 'Kas yra Lorem Ipsum?\n\nLorem ipsum - tai fiktyvus tekstas naudojamas spaudos ir grafinio dizaino pasaulyje jau nuo XVI a. pradžios. Lorem Ipsum tapo standartiniu fiktyviu tekstu, kai nežinomas spaustuvininkas atsitiktine tvarka išdėliojo raides atspaudų prese ir tokiu būdu sukūrė raidžių egzempliorių. Šis tekstas išliko beveik nepasikeitęs ne tik penkis amžius, bet ir įžengė i kopiuterinio grafinio dizaino laikus. Jis išpopuliarėjo XX a. šeštajame dešimtmetyje, kai buvo išleisti Letraset lapai su Lorem Ipsum ištraukomis, o vėliau -leidybinė sistema AldusPageMaker, kurioje buvo ir Lorem Ipsum versija.', 'ccccc 3', 'bbbbbbbbb 4', 'dfgsd4444', 27, 1, '2023-09-13 18:42:37', '2023-09-13 19:13:19'),
(2, 'tesssrrr', 'Kas yra Lorem Ipsum?\n\nLorem ipsum - tai fiktyvus tekstas naudojamas spaudos ir grafinio dizaino pasaulyje jau nuo XVI a. pradžios. Lorem Ipsum tapo standartiniu fiktyviu tekstu, kai nežinomas spaustuvininkas atsitiktine tvarka išdėliojo raides atspaudų prese ir tokiu būdu sukūrė raidžių egzempliorių. Šis tekstas išliko beveik nepasikeitęs ne tik penkis amžius, bet ir įžengė i kopiuterinio grafinio dizaino laikus. Jis išpopuliarėjo XX a. šeštajame dešimtmetyje, kai buvo išleisti Letraset lapai su Lorem Ipsum ištraukomis, o vėliau -leidybinė sistema AldusPageMaker, kurioje buvo ir Lorem Ipsum versija.', 'aaaaaaaaa 1', 'uuuuuuuuuuuu 8', 'dfgsd777', 28, 1, '2023-09-13 18:42:37', '2023-09-13 19:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `jd_simple_zer`
--

CREATE TABLE `jd_simple_zer` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `lang_en_title` text DEFAULT NULL,
  `lang_en_description` text DEFAULT NULL,
  `img_url` varchar(255) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `readmore` varchar(255) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jd_simple_zer`
--

INSERT INTO `jd_simple_zer` (`id`, `title`, `description`, `lang_en_title`, `lang_en_description`, `img_url`, `img_name`, `readmore`, `menu_id`, `place_id`, `addon_id`, `created`, `updated`) VALUES
(1, 'My History', 'Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.', 'My History tes', 'Testas test test test', 'http://localhost/uploads/jd_simple_zer_img/7646653_f9f1c35fca142b93.jpg', '7646653_f9f1c35fca142b93.jpg', 'contacts', 6, 16, 14, '2023-08-08 17:00:50', '2023-09-14 17:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `social_block_links`
--

CREATE TABLE `social_block_links` (
  `id` int(11) UNSIGNED NOT NULL,
  `profiles_name` text DEFAULT NULL,
  `social_profiles_link_url` text NOT NULL,
  `fa_icone_code` text NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_block_links`
--

INSERT INTO `social_block_links` (`id`, `profiles_name`, `social_profiles_link_url`, `fa_icone_code`, `menu_id`, `place_id`, `addon_id`, `created`, `updated`) VALUES
(14, 'Facebook,Github', 'https://facebook.com,https://github.com/', '&lt;span class=&quot;fa-stack fa-lg&quot;&gt;&lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;&lt;i class=&quot;fa fa-facebook fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;&lt;/span&gt;,&lt;span class=&quot;fa-stack fa-lg&quot;&gt;&lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;&lt;i class=&quot;fa fa-github fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;&lt;/span&gt;', 0, 14, 16, '2023-09-01 16:44:28', '2023-09-09 02:37:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `callendar_users_member`
--
ALTER TABLE `callendar_users_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_callendar`
--
ALTER TABLE `event_callendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_callendar_holidays`
--
ALTER TABLE `event_callendar_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_callendar_item`
--
ALTER TABLE `event_callendar_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_callendar_laboratories`
--
ALTER TABLE `event_callendar_laboratories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_reservation_time`
--
ALTER TABLE `event_reservation_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_contact_form_settings`
--
ALTER TABLE `flussi_contact_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_files`
--
ALTER TABLE `flussi_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_menu`
--
ALTER TABLE `flussi_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_places`
--
ALTER TABLE `flussi_places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_posts`
--
ALTER TABLE `flussi_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `flussi_sidebar`
--
ALTER TABLE `flussi_sidebar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `flussi_tjd_addons`
--
ALTER TABLE `flussi_tjd_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_translations`
--
ALTER TABLE `flussi_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flussi_users`
--
ALTER TABLE `flussi_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login_name` (`login_name`);

--
-- Indexes for table `flussi_v_custom_blocks`
--
ALTER TABLE `flussi_v_custom_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `info_media_gallery`
--
ALTER TABLE `info_media_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_media_gallery_item`
--
ALTER TABLE `info_media_gallery_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jd_simple_zer`
--
ALTER TABLE `jd_simple_zer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_block_links`
--
ALTER TABLE `social_block_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `callendar_users_member`
--
ALTER TABLE `callendar_users_member`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_callendar`
--
ALTER TABLE `event_callendar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_callendar_holidays`
--
ALTER TABLE `event_callendar_holidays`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_callendar_item`
--
ALTER TABLE `event_callendar_item`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_callendar_laboratories`
--
ALTER TABLE `event_callendar_laboratories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_reservation_time`
--
ALTER TABLE `event_reservation_time`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `flussi_contact_form_settings`
--
ALTER TABLE `flussi_contact_form_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flussi_files`
--
ALTER TABLE `flussi_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `flussi_menu`
--
ALTER TABLE `flussi_menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `flussi_places`
--
ALTER TABLE `flussi_places`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `flussi_posts`
--
ALTER TABLE `flussi_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `flussi_sidebar`
--
ALTER TABLE `flussi_sidebar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `flussi_tjd_addons`
--
ALTER TABLE `flussi_tjd_addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `flussi_translations`
--
ALTER TABLE `flussi_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `flussi_users`
--
ALTER TABLE `flussi_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `flussi_v_custom_blocks`
--
ALTER TABLE `flussi_v_custom_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `info_media_gallery`
--
ALTER TABLE `info_media_gallery`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `info_media_gallery_item`
--
ALTER TABLE `info_media_gallery_item`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jd_simple_zer`
--
ALTER TABLE `jd_simple_zer`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `social_block_links`
--
ALTER TABLE `social_block_links`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flussi_sidebar`
--
ALTER TABLE `flussi_sidebar`
  ADD CONSTRAINT `flussi_sidebar_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `flussi_sidebar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
