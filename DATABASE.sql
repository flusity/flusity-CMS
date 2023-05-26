-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2023 at 02:04 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jdbas`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(79, 'dd7777777', '2023-04-14 15:01:16', '2023-04-16 12:26:49'),
(80, 'testuoju', '2023-04-14 15:12:13', '2023-04-14 15:12:13'),
(83, 'fffffddd', '2023-04-14 15:20:38', '2023-04-14 15:29:15'),
(85, 'dogas', '2023-04-14 15:33:23', '2023-04-14 16:04:56'),
(86, 'kika', '2023-04-14 16:04:47', '2023-04-14 16:04:47'),
(87, 'testuoju 55', '2023-04-15 08:09:50', '2023-04-15 08:09:50'),
(92, 'fff', '2023-04-19 19:49:36', '2023-04-19 19:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_settings`
--

CREATE TABLE `contact_form_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_form_settings`
--

INSERT INTO `contact_form_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'ssssdfff', 'dddddddd');

-- --------------------------------------------------------

--
-- Table structure for table `custom_blocks`
--

CREATE TABLE `custom_blocks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `html_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `custom_blocks`
--

INSERT INTO `custom_blocks` (`id`, `name`, `menu_id`, `category_id`, `html_code`) VALUES
(2, 'bcvbcv', 3, 80, 'cxvv'),
(3, 'ffff', 1, 79, 'ffbbbbsssss'),
(7, 'fghgfh777', 6, 79, 'ghghfggh 777777'),
(8, 'fff', 6, 79, 'fghfh'),
(9, 'ghgh', 1, 79, 'ghg'),
(10, 'bbbb', 1, 85, 'ssddfsxxxx'),
(11, 'dd', 12, 79, 'fdgdf');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `url`, `uploaded_at`) VALUES
(19, 'logo_dbc3f8c0e5c17ee1.png', 'http://localhost/uploads/logo_dbc3f8c0e5c17ee1.png', '2023-04-21 13:12:25'),
(20, 'bg23_a1506a0d8103819f.png', 'http://localhost/uploads/bg23_a1506a0d8103819f.png', '2023-04-21 20:15:43'),
(22, 'pexels-paashuu-15526366_71c26724e8db22dc.jpg', 'http://localhost/uploads/pexels-paashuu-15526366_71c26724e8db22dc.jpg', '2023-05-25 21:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `page_url`, `position`, `template`, `created_at`, `updated_at`) VALUES
(1, 'Dokumentai', 'dokumentai', 3, 'template_left_content', '2023-04-15 09:00:19', '2023-04-20 10:49:49'),
(3, 'NAUJIENOS', 'news', 2, 'template_naujienos', '2023-04-15 21:29:51', '2023-04-19 20:32:46'),
(6, 'HOME', 'index', 1, 'template_index', '2023-04-16 12:35:26', '2023-04-19 20:38:55'),
(12, 'Kontaktai', 'contacts', 5, 'template_contacts', '2023-04-21 14:28:01', '2023-05-22 19:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `menu_id` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author_id`, `role`, `created_at`, `status`, `menu_id`, `tags`, `updated_at`) VALUES
(1, 'ggnn', 'bcncvbvcbsrgfsgf dfgfd', 2, 'admin', '2023-04-15 16:08:31', 'draft', 1, 'ddddfdfddd', '2023-04-19 16:17:29'),
(4, 'Naujas bandymas 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ultricies justo ut purus efficitur, eleifend pellentesque risus cursus. Maecenas ex massa, sagittis id metus non, convallis scelerisque ligula. Vivamus aliquam risus accumsan lacinia eleifend. Nunc vestibulum massa a mauris egestas, quis sollicitudin est posuere. Duis lobortis tincidunt leo, vitae condimentum odio mollis at. Nullam mollis lobortis erat, lobortis mollis mi commodo ac. Nunc in lectus vitae mauris imperdiet varius in id neque. Vestibulum orci risus, posuere in velit eget, ullamcorper convallis augue. Mauris nulla dui, iaculis ac ultrices quis, scelerisque a libero.', 2, 'admin', '0000-00-00 00:00:00', 'published', 6, 'nnnn', '2023-04-19 18:36:31'),
(5, 'fthhj', 'gfhjgfhjfghjgfhj', 2, 'user', '0000-00-00 00:00:00', 'draft', 1, 'aaa', '2023-04-19 16:17:29'),
(8, 'test www', 'dfgdfgfg dfgfg', 2, 'admin', '0000-00-00 00:00:00', 'draft', 3, 'wwwc', '2023-05-25 09:36:58'),
(10, 'test www', 'tervvr re eshh          šįyįš yįęįšudhhdf  dfhfh fghd', 2, 'admin', '0000-00-00 00:00:00', 'published', 3, 'nnnu', '2023-05-25 09:48:58'),
(11, 'sdsrrrrrr', 'fghghgfbfghb fg hh dh dh gfhgfhdfghgf fhj trtyėį  tėįrsh   jjgdjgj', 2, 'user', '0000-00-00 00:00:00', 'published', 1, '', '2023-04-19 16:17:29'),
(28, 'sdfsdf', 'sdfsdf', 2, 'admin', '2023-04-19 18:18:44', 'published', 3, 'aaa', '2023-05-25 09:25:46'),
(29, 'hh', 'hhhccccccc', 2, 'admin', '2023-04-19 20:56:21', 'draft', 6, 'hddzf', '2023-05-25 09:28:47'),
(30, 'nnneeeee', 'xcvxerter e er', 2, 'admin', '2023-04-19 21:11:47', 'draft', 3, 'nnnf', '2023-05-26 10:56:16'),
(31, 'asda', 'adasdasdas', 2, 'admin', '2023-05-26 13:58:04', 'published', 1, 'nnnn', '2023-05-26 10:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `site_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `footer_text` text NOT NULL,
  `pretty_url` int(1) NOT NULL DEFAULT 0,
  `language` varchar(2) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`site_title`, `meta_description`, `footer_text`, `pretty_url`, `language`) VALUES
('JD website', 'JD website description', 'JD website Footer', 1, 'lt');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `translation_key` varchar(255) NOT NULL,
  `translation_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `language_code`, `translation_key`, `translation_value`) VALUES
(1, 'lt', 'Language', 'Kalba'),
(2, 'lt', 'Users', 'Vartotojai'),
(4, 'lt', 'Dashboard', 'Prietaisų skydelis'),
(5, 'lt', 'Translation Key', 'Verčiamas žodis'),
(6, 'lt', 'Translation Value', 'Išverstas įrašas'),
(7, 'lt', 'Categories', 'Kategorijos'),
(26, 'lt', 'Language Code', 'Kalbos Kodas'),
(27, 'lt', 'Translation form', 'Vertimo forma'),
(28, 'lt', 'Settings successfully updated!', 'Nustatymai sėkmingai atnaujinti!'),
(29, 'lt', 'Page Name', 'Puslapio pavadinimas'),
(30, 'lt', 'Settings', 'Nustatymai'),
(31, 'lt', 'Files', 'Failai'),
(32, 'lt', 'Contact Form', 'Kontaktų forma'),
(33, 'lt', 'Posts', 'Įrašai'),
(34, 'lt', 'Menu', 'Meniu'),
(35, 'lt', 'Username', 'Vardas'),
(36, 'lt', 'META description', 'META aprašymas'),
(37, 'lt', 'Footer text', 'Apačios tekstas'),
(38, 'lt', 'Pretty URL', 'Gražus URL'),
(39, 'lt', 'Home Page', 'Puslapio priekis'),
(40, 'lt', 'Menu items', 'Meniu vienetai'),
(41, 'lt', 'User\'s', 'Vartotojai'),
(42, 'lt', 'Administration tools', 'Administravimo įrankiai'),
(43, 'lt', 'Post\'s', 'Įrašai'),
(44, 'lt', 'Block\'s', 'Blokai'),
(45, 'lt', 'Usename', 'Vartotojo Vardas'),
(46, 'lt', 'User successfully updated.', 'Vartotojas sėkmingai atnaujintas.'),
(47, 'lt', 'Add Category', 'Pridėti kategoriją'),
(48, 'lt', 'Actions', 'Veiksmas'),
(49, 'lt', 'Categories', 'Kategorijos'),
(50, 'lt', 'Name', 'Pavadinimas'),
(51, 'lt', 'Translation added successfully.', 'Vertimas sėkmingai pridėtas.'),
(52, 'lt', 'Error: Please fill in all fields.', 'Klaida: užpildykite visus laukus.'),
(53, 'lt', 'Edit Category', 'Redaguoti kategoriją'),
(54, 'lt', 'Are you sure you want to delete this category?', 'Ar tikrai norite ištrinti šią kategoriją?'),
(55, 'lt', 'Add/Edit', 'Pridėti/Redaguoti'),
(56, 'lt', 'Translation updated successfully.', 'Vertimas sėkmingai atnaujintas.'),
(57, 'lt', 'Edit', 'Redaguoti'),
(58, 'lt', 'Delete', 'Ištrinti'),
(59, 'lt', 'Code', 'Kodas'),
(60, 'lt', 'No.', 'Nr.'),
(61, 'lt', 'Update Settings', 'Atnaujinti nustatymus'),
(62, 'lt', 'Clear Cache', 'Išvalyti Talpykla'),
(63, 'lt', 'Create a backup', 'Sukurti DB kopiją'),
(64, 'lt', 'Files', 'Failai'),
(65, 'lt', 'File list', 'Failų sąrašas'),
(66, 'lt', 'Select a file:', 'Pasirinkite failą:'),
(67, 'lt', 'Upload file', 'Įkelti failą'),
(68, 'lt', 'Preview', 'Peržiūra'),
(69, 'lt', 'Copy url', 'Kopijuoti url'),
(70, 'lt', 'Contact form', 'Kontaktinė forma'),
(71, 'lt', 'Key', 'Raktas'),
(72, 'lt', 'Value', 'Vertė'),
(73, 'lt', 'Save settings', 'Išsaugoti nustatymus'),
(74, 'lt', 'HTML Code', 'HTML kodas'),
(75, 'lt', 'Menu Place', 'Meniu vieta'),
(76, 'lt', 'Category', 'Kategorija'),
(77, 'lt', 'Log off', 'Atsijungti'),
(78, 'lt', 'Log In', 'Prisijungti'),
(79, 'lt', 'Sign up', 'Registruotis'),
(80, 'lt', 'or', 'arba'),
(81, 'lt', 'Page Menu', 'Puslapio mniu'),
(82, 'lt', 'Page URL', 'Puslapio url'),
(83, 'lt', 'Template', 'Šablonas'),
(84, 'lt', 'Position', 'Pozicija'),
(85, 'lt', 'Add Menu', 'Pridėti meniu'),
(86, 'lt', 'Confirm deletion', 'Patvirtinkite šalinimą'),
(87, 'lt', 'Are you sure you want to delete this menu?', 'Ar tikrai norite ištrinti šį meniu?'),
(88, 'lt', 'Menu item successfully added.', 'Meniu punktas sėkmingai pridėtas.'),
(89, 'lt', 'Error adding menu item. Try again.', 'Klaida pridedant meniu punktą. Bandykite dar kartą.'),
(90, 'lt', 'Menu Name', 'Meniu pavadinimas'),
(91, 'lt', 'Add Menu', 'Pridėti meniu'),
(92, 'lt', 'Edit Menu', 'Redaguoti meniu'),
(93, 'lt', 'Category Name', 'Kategorijos pavadinimas'),
(94, 'lt', 'Add Category', 'Pridėti kategoriją'),
(95, 'lt', 'Posts on pages', 'Įrašai puslapiuose'),
(96, 'lt', 'Title', 'Antraštė'),
(97, 'lt', 'Content', 'Turinys'),
(98, 'lt', 'Author', 'Autorius'),
(99, 'lt', 'Public', 'Rodomas'),
(100, 'lt', 'Existing Tag\'s', 'Esančios žymos'),
(101, 'lt', 'Tags', 'Žymos'),
(102, 'lt', 'Page status', 'Puslapio būsena'),
(103, 'lt', 'Published', 'Publikuotas'),
(104, 'lt', 'Draft', 'Juodraštis'),
(105, 'lt', 'List of backups', 'Atsarginių kopijų sąrašas'),
(106, 'lt', 'No backups', 'Nėra atsarginių kopijų.'),
(107, 'lt', 'Custom Blocks', 'Įvairūs Blokai'),
(108, 'lt', 'Category successfully added.', 'Kategorijos pridėjimas pavyko.'),
(109, 'lt', 'Error adding category. Try again.', 'Klaida pridedant kategoriją. Bandykite dar kartą.'),
(110, 'lt', 'Record successfully added.', 'Įrašas sėkmingai sukurtas.'),
(111, 'lt', 'Error adding Record. Try again.', 'Pridedant įrašą įvyko klaida. Bandyk iš naujo.'),
(112, 'lt', 'The record has been updated successfully.', 'Įrašas sėkmingai atnaujintas.'),
(113, 'lt', 'Error updating post. Try again.', 'Klaida atnaujinant įrašą. Bandyk iš naujo.'),
(114, 'lt', 'Category successfully updated.', 'Kategorija sėkmingai atnaujinta.'),
(115, 'lt', 'Error updating category. Try again.', 'Klaida atnaujinant kategoriją. Bandykite dar kartą.'),
(116, 'lt', 'Backup deleted successfully!', 'Atsarginė kopija sėkmingai ištrinta!'),
(117, 'lt', 'Failed to delete backup.', 'Nepavyko ištrinti atsarginės kopijos.'),
(118, 'lt', 'Error: Please specify a file name.', 'Klaida: Prašome nurodyti failo pavadinimą.'),
(119, 'lt', 'Add Category', 'Pridėti kategoriją'),
(120, 'lt', 'Confirm deletion', 'Patvirtinkite šalinimą'),
(121, 'lt', 'Category successfully deleted.', 'Kategorija sėkmingai ištrinta.'),
(122, 'lt', 'Error deleting category. Try again.', 'Klaida trinant kategoriją. Bandykite dar kartą.'),
(123, 'lt', 'Edit Category', 'Redaguoti kategoriją'),
(124, 'lt', 'File not found.', 'Failas nerastas.'),
(125, 'lt', 'Surname', 'Pavardė'),
(126, 'lt', 'Phone', 'Telefonas'),
(127, 'lt', 'Email', 'El.paštas'),
(128, 'lt', 'Role', 'Teisės'),
(129, 'lt', 'Update User', 'Atnaujinti vartotoją'),
(130, 'lt', 'Cancel', 'Atšaukti'),
(131, 'lt', 'Password', 'Slaptažodis'),
(132, 'lt', 'Confirm Password', 'Patvirtinti slaptažodį'),
(133, 'lt', 'User successfully updated.', 'Vartotojas sėkmingai atnaujintas.'),
(134, 'lt', 'Error updating user. Try again.', 'Klaida atnaujinant naudotoją. Bandyk iš naujo.'),
(135, 'lt', 'Confirm new password', 'Patvirtinti naują slaptažodį'),
(136, 'lt', 'Enter new password', 'Įveskite naują slaptažodį'),
(137, 'lt', 'Admin', 'Adminas'),
(138, 'lt', 'Moderator', 'Moderatorius'),
(139, 'lt', 'User', 'Vartotojas'),
(140, 'lt', 'User not found.', 'Vartotojas nerastas.'),
(141, 'lt', 'The passwords do not match. Try again.', 'Slaptažodžiai nesutampa. Bandyk iš naujo.'),
(142, 'lt', 'Error deleting Custom Block. Try again.', 'Klaida ištrinant pasirinktinį bloką. Bandyk iš naujo.'),
(143, 'lt', 'Custom Block successfully deleted.', 'Pasirinktinis blokas sėkmingai ištrintas.'),
(144, 'lt', 'Menu item successfully deleted.', 'Meniu punktas sėkmingai ištrintas.'),
(145, 'lt', 'Error deleting menu item. Try again.', 'Klaida trinant meniu punktą. Bandykite dar kartą.'),
(146, 'lt', 'Page deleted successfully.', 'Puslapis sėkmingai ištrintas.'),
(147, 'lt', 'Error deleting page. Try again.', 'Klaida trinant puslapį. Bandykite dar kartą.'),
(148, 'lt', 'Failed to delete translation.', 'Nepavyko ištrinti vertimo.'),
(149, 'lt', 'Translation successfully deleted.', 'Vertimas sėkmingai ištrintas.'),
(150, 'lt', 'Error: Please specify translation ID.', 'Klaida: Prašome nurodyti vertimo ID.'),
(151, 'lt', 'Error: Please specify a file name.', 'Klaida: Prašome nurodyti failo pavadinimą.'),
(152, 'lt', 'File', 'Failas'),
(153, 'lt', 'deleted successfully.', 'sėkmingai ištrintas.'),
(154, 'lt', 'Error deleting file from database.', 'Klaida trinant failą iš duomenų bazės.'),
(155, 'lt', 'Error deleting file from system.', 'Klaida trinant failą iš sistemos.'),
(156, 'lt', 'No such file found.', 'Toks failas nerastas.'),
(157, 'lt', 'No file ID specified.', 'Nenurodytas failo ID.'),
(158, 'lt', 'The menu item has been updated successfully.', 'Meniu punktas sėkmingai atnaujintas.'),
(159, 'lt', 'Error updating menu item. Try again.', 'Klaida atnaujinant meniu punktą. Bandykite dar kartą.'),
(160, 'lt', 'Error updating post. Try again.', 'Klaida atnaujinant įrašą. Bandyk iš naujo.'),
(161, 'lt', 'The record has been updated successfully.', 'Įrašas sėkmingai atnaujintas.'),
(162, 'lt', 'User successfully updated.', 'Vartotojas sėkmingai atnaujintas.'),
(163, 'lt', 'Error updating user. Try again.', 'Klaida atnaujinant naudotoją. Bandyk iš naujo.'),
(164, 'lt', 'uploaded successfully.', 'sėkmingai įkeltas.'),
(165, 'lt', 'Error loading file.', 'Klaida įkeliant failą.'),
(166, 'lt', 'Are you sure you want to delete this User?', 'Ar tikrai norite ištrinti šį naudotoją?'),
(167, 'lt', 'Confirm the removal', 'Patvirtinkite pašalinimą'),
(168, 'lt', 'Invalid username or password.', 'Neteisingas vartotojo vardas arba slaptažodis.'),
(169, 'lt', 'Login system', 'Prisijungimo sistema'),
(170, 'lt', 'The content management system is intended for personal websites', 'Turinio valdymo sistema skirta asmeninėms svetainėms'),
(171, 'lt', 'Login', 'Prisijungti'),
(172, 'lt', 'Home page', 'Pagrindinis puslapis'),
(173, 'lt', 'Connect to page', 'Prisijungimas'),
(174, 'lt', 'User Name', 'Vartotojo Vardas'),
(175, 'lt', 'Back to', 'Grįžti į'),
(176, 'lt', 'That Name is already taken. Choose another.', 'Toks Vardas jau užimtas. Pasirinkite kitą.'),
(177, 'lt', 'User registration failed. Try again.', 'Vartotojo registracija nepavyko. Bandykite dar kartą.'),
(178, 'lt', 'Passwords do not match. Try again.', 'Slaptažodžiai nesutampa. Bandykite dar kartą.'),
(179, 'lt', 'Registration system', 'Registracijos sistema'),
(180, 'lt', 'Content management system for personal websites', 'Turinio valdymo sistema skirta asmeninėms svetainėms'),
(181, 'lt', 'Registration', 'Registracija'),
(182, 'lt', 'Repeat the password', 'Pakartokite slaptažodį'),
(183, 'lt', 'Register', 'Registruotis'),
(184, 'lt', 'Sign out', 'Atsijungti'),
(185, 'lt', 'Log In', 'Prisijungti'),
(186, 'lt', 'Sign up', 'Registruotis'),
(187, 'lt', 'Hello', 'Sveiki'),
(188, 'lt', 'Front page', 'Puslapio priekis'),
(189, 'lt', 'Log out', 'Atsijungti'),
(190, 'lt', 'or', 'arba'),
(191, 'lt', 'Post status', 'Įrašo būsena'),
(192, 'lt', 'Update Post', 'Atnaujinti įrašą'),
(193, 'lt', 'Add Post', 'Pridėti įrašą'),
(194, 'lt', 'Back', 'Grįžti'),
(195, 'lt', 'Search translations...', 'Ieškoti vertimo...');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `surname`, `phone`, `email`, `password`, `role`) VALUES
(2, 'Darius', 'dsssiixxxxc', '+37061287842', 'teggfffst@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$MGRmSFR4c0RPMmUvaGdKMg$Pf8H8eqOlanOnqZv2wM/hDFqJIAiddCfFZMvMmKHpLU', 'admin'),
(4, 'Petras2', 'Petraitis', '+37061366841', 'test2@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$endPWlNsNDY1R2FFQ09meA$qoMAOJPjxm2XESQ3b4JYs9ZO5I0eB729ebHwTnLB12Q', 'user'),
(9, 'Vladas', 'Girinis5', '+37055557847', 'test3@gmail.com', '$2y$10$.CW7FIIzJ9j2Posl5yggU.602/ZXNpJM/eOpj0G54zTcmtdJPW6WC', 'moderator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form_settings`
--
ALTER TABLE `contact_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_blocks`
--
ALTER TABLE `custom_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `contact_form_settings`
--
ALTER TABLE `contact_form_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `custom_blocks`
--
ALTER TABLE `custom_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_blocks`
--
ALTER TABLE `custom_blocks`
  ADD CONSTRAINT `custom_blocks_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `custom_blocks_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
