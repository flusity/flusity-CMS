SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS flussi_contact_form_settings;

CREATE TABLE `flussi_contact_form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(255) NOT NULL,
  `email_body` text NOT NULL,
  `email_success_message` varchar(255) NOT NULL,
  `email_error_message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS flussi_files;

CREATE TABLE `flussi_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS flussi_menu;

CREATE TABLE `flussi_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS flussi_places;

CREATE TABLE `flussi_places` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS flussi_posts;

CREATE TABLE `flussi_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `menu_id` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `priority` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS flussi_settings;

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
  `table_prefix` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS flussi_sidebar;

CREATE TABLE `flussi_sidebar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `flussi_sidebar_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `flussi_sidebar` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS flussi_tjd_addons;

CREATE TABLE `flussi_tjd_addons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_addon` varchar(255) DEFAULT NULL,
  `description_addon` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `version` varchar(50) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `show_front` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS flussi_translations;

CREATE TABLE `flussi_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(5) NOT NULL,
  `translation_key` varchar(255) NOT NULL,
  `translation_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS flussi_users;

CREATE TABLE `flussi_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `login_name` (`login_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS flussi_v_custom_blocks;

CREATE TABLE `flussi_v_custom_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `place_id` int(10) unsigned DEFAULT NULL,
  `html_code` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `place_id` (`place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS jd_simple;

CREATE TABLE `jd_simple` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `img_url` varchar(255) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS jd_simple_zer;

CREATE TABLE `jd_simple_zer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `img_url` varchar(255) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO flussi_contact_form_settings VALUES("1","New message from Contact Form","We received a message from:","Email has been sent successfully","Failed to send the email");



INSERT INTO flussi_files VALUES("4","pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","http://localhost/uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","2023-05-28 15:59:43");
INSERT INTO flussi_files VALUES("5","pexels-quang-nguyen_8ca6b53cdb562332.jpg","http://localhost/uploads/pexels-quang-nguyen_8ca6b53cdb562332.jpg","2023-05-28 17:18:46");
INSERT INTO flussi_files VALUES("18","flusity-b_a252d067e7fe12f7.png","http://localhost/uploads/flusity-b_a252d067e7fe12f7.png","2023-06-28 11:12:37");
INSERT INTO flussi_files VALUES("19","pexels-fauxels-3184285_04daf37625bd4ad7.jpg","http://localhost/uploads/pexels-fauxels-3184285_04daf37625bd4ad7.jpg","2023-07-02 10:46:44");



INSERT INTO flussi_menu VALUES("6","HOMES","index","1","template_index","2023-04-16 15:35:26","2023-06-20 22:59:31","1","0");
INSERT INTO flussi_menu VALUES("12","Kontaktai","contacts","5","template_contacts","2023-04-21 17:28:01","2023-06-16 08:53:43","1",NULL);



INSERT INTO flussi_places VALUES("1","head-box-one","2023-04-14 18:01:16","2023-05-28 11:27:20");
INSERT INTO flussi_places VALUES("2","news-right-5","2023-04-14 18:12:13","2023-05-28 11:21:48");
INSERT INTO flussi_places VALUES("3","home-right-5","2023-04-14 18:20:38","2023-05-28 11:15:56");
INSERT INTO flussi_places VALUES("4","doc-right-5","2023-04-14 18:33:23","2023-05-28 11:20:16");
INSERT INTO flussi_places VALUES("5","home-left-7","2023-04-19 22:49:36","2023-05-28 11:24:53");
INSERT INTO flussi_places VALUES("6","head-box-two","2023-05-28 11:27:28","2023-05-28 11:27:28");
INSERT INTO flussi_places VALUES("7","contact-right-5","2023-05-28 11:28:19","2023-05-28 11:28:19");
INSERT INTO flussi_places VALUES("8","contact-left-7","2023-05-28 11:30:01","2023-05-28 11:30:01");
INSERT INTO flussi_places VALUES("9","doc-left-7","2023-05-28 11:30:21","2023-05-28 11:30:21");
INSERT INTO flussi_places VALUES("10","home-col-down-12","2023-05-28 15:26:33","2023-05-28 15:26:33");



INSERT INTO flussi_posts VALUES("1","ggnn","bcncvbvcbsrgfsgf dfgfd","2","admin","2023-04-15 16:08:31","draft","1",NULL,"2023-06-06 22:17:18",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("2","Naujas bandymas 3","&lt;b&gt;Lorem&lt;/b&gt; ipsum dolor sit amet, consectetur adipiscing elit. &lt;img src=&quot;uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg&quot; width=&quot;250px&quot; height=&quot;auto&quot; align=&quot;left&quot; hspace=&quot;15&quot; vspace=&quot;15&quot;/&gt;\n\n\n\nAliquam ultricies justo ut purus efficitur, eleifend pellentesque risus cursus. Maecenas ex massa, sagittis id metus non, convallis scelerisque ligula. Vivamus aliquam risus accumsan lacinia eleifend. Nunc vestibulum massa a mauris egestas, quis sollicitudin est posuere. Duis lobortis tincidunt leo, vitae condimentum odio mollis at. Nullam mollis lobortis erat, lobortis mollis mi commodo ac. Nunc in lectus vitae mauris imperdiet varius in id neque. Vestibulum orci risus, posuere in velit eget, ullamcorper convallis augue. Mauris nulla dui, iaculis ac ultrices quis, scelerisque a libero.","2","admin","2023-01-01 11:03:58","published","6","news","2023-06-10 18:28:38","Flusity is a contemporary PHP CMS project utilizing MVC architecture, MySQL database, and Bootstrap front-end framework. It includes the management of users, posts, menu, blocks and other elements, as well as security and SEO features.","free cms flusity, php cms, cms, website","1");
INSERT INTO flussi_posts VALUES("3","fthhj","gfhjgfhjfghjgfhj","2","admin","2023-01-01 02:04:48","draft","1",NULL,"2023-06-06 22:17:29",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("4","test www","dfgdfgfg dfgfg","2","admin","2023-01-01 00:02:48","draft","3",NULL,"2023-06-06 22:17:43",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("5","test www","tervvr re eshh       &lt;b&gt;   šįyįš yįęįšudhhdf  dfhfh fghd&lt;/b&gt;","2","admin","2023-01-01 00:02:40","published","3",NULL,"2023-06-04 23:22:48",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("6","sdsrrrrrr","fghghgfbfghb fg hh dh dh gfhgfhdfghgf fhj trtyėį  tėįrsh   jjgdjgj","2","admin","2023-01-01 00:02:20","published","1",NULL,"2023-05-26 19:21:26",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("7","sdfsdf","sdfsdf","2","admin","2023-04-19 18:18:44","published","3",NULL,"2023-06-06 22:28:48",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("8","hh","hhhccccccc","2","admin","2023-04-19 20:56:21","draft","6",NULL,"2023-06-06 09:54:31",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("9","nnneeeee","xcvxerter e er","2","admin","2023-04-19 21:11:47","draft","3",NULL,"2023-06-06 22:28:42",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("10","asda","&lt;b&gt;adasdasdas&lt;/b&gt;","2","admin","2023-05-26 13:58:04","published","1",NULL,"2023-06-06 22:17:59",NULL,NULL,"0");
INSERT INTO flussi_posts VALUES("11","xxxxx","&lt;b&gt;xcvxcvxcvxcv&lt;/b&gt;&lt;mark&gt;&lt;/mark&gt;","2","admin","2023-06-03 20:31:21","published","6",NULL,"2023-06-20 17:09:05","sdfsdf sdvgsdfsdfddddddddd","sdfdsfdf sdfv","0");
INSERT INTO flussi_posts VALUES("12","zzzzzzzzzzzzz","xzczxczx x zx zxv erge","2","admin","2023-06-05 23:40:09","draft","6",NULL,"2023-06-20 17:08:20","zxc x","zzz","0");



INSERT INTO flussi_settings VALUES("Free CMS flusity","Flusity is a contemporary PHP CMS project utilizing MVC architecture, MySQL database, and Bootstrap front-end framework. It includes the management of users, posts, menu, blocks and other elements, as well as security and SEO features.","Copyright &copy; flusity JD Theme 2023","1","lt","10","0","30","free cms, php, free website, cms, content management system, free cms flusity, php cms, website ","flusity-cms","flusity-b_a252d067e7fe12f7.png","jdfsite");



INSERT INTO flussi_sidebar VALUES("1","Dashboard","fas fa-tachometer-alt","/admin.php",NULL,"1");
INSERT INTO flussi_sidebar VALUES("2","Posts","fas fa-newspaper","/core/tools/posts.php",NULL,"2");
INSERT INTO flussi_sidebar VALUES("3","Block","fas fa-shapes","/core/tools/customblock.php",NULL,"3");
INSERT INTO flussi_sidebar VALUES("4","Files","fas fa-folder","/core/tools/files.php",NULL,"4");
INSERT INTO flussi_sidebar VALUES("5","Core Settings","fas fa-cog",NULL,NULL,"5");
INSERT INTO flussi_sidebar VALUES("6","Users","fas fa-users","/core/tools/users.php","5","1");
INSERT INTO flussi_sidebar VALUES("7","Menu","fas fa-bars","/core/tools/menu.php","5","2");
INSERT INTO flussi_sidebar VALUES("8","AddOns","fas fa-puzzle-piece","/core/tools/addons.php","5","3");
INSERT INTO flussi_sidebar VALUES("9","Contact Form","fas fa-message","/core/tools/contact_form.php","5","5");
INSERT INTO flussi_sidebar VALUES("10","Layout Places","fas fa-tags","/core/tools/places.php","5","6");
INSERT INTO flussi_sidebar VALUES("11","Themes","fa-solid fa-brush","/core/tools/themes.php","5","7");
INSERT INTO flussi_sidebar VALUES("12","Settings","fas fa-cog","/core/tools/settings.php","5","8");
INSERT INTO flussi_sidebar VALUES("13","Language","fas fa-language","/core/tools/language.php","5","4");



INSERT INTO flussi_tjd_addons VALUES("10","jd_simple","This test addon","1","1v","JD Flusite","2023-07-02 10:06:18","2023-07-02 10:06:24","1");
INSERT INTO flussi_tjd_addons VALUES("12","jd_simple_zer","This test addon","1","1v","JD Flusite Zer","2023-07-02 10:55:53","2023-07-02 10:59:53","1");



INSERT INTO flussi_translations VALUES("1","lt","Language","Kalba");
INSERT INTO flussi_translations VALUES("2","lt","Users","Vartotojai");
INSERT INTO flussi_translations VALUES("4","lt","Dashboard","Prietaisų skydelis");
INSERT INTO flussi_translations VALUES("5","lt","Translation Key","Verčiamas žodis");
INSERT INTO flussi_translations VALUES("6","lt","Translation Value","Išverstas įrašas");
INSERT INTO flussi_translations VALUES("7","lt","Language Code","Kalbos Kodas");
INSERT INTO flussi_translations VALUES("8","lt","Translation form","Vertimo forma");
INSERT INTO flussi_translations VALUES("9","lt","Settings successfully updated!","Nustatymai sėkmingai atnaujinti!");
INSERT INTO flussi_translations VALUES("10","lt","Page Name","Puslapio pavadinimas");
INSERT INTO flussi_translations VALUES("11","lt","Settings","Nustatymai");
INSERT INTO flussi_translations VALUES("12","lt","Contact Form","Kontaktų forma");
INSERT INTO flussi_translations VALUES("13","lt","Posts","Įrašai");
INSERT INTO flussi_translations VALUES("14","lt","Menu","Meniu");
INSERT INTO flussi_translations VALUES("15","lt","Username","Vardas");
INSERT INTO flussi_translations VALUES("16","lt","META description","META aprašymas");
INSERT INTO flussi_translations VALUES("17","lt","Footer text","Apačios tekstas");
INSERT INTO flussi_translations VALUES("18","lt","Pretty URL","Gražus URL");
INSERT INTO flussi_translations VALUES("19","lt","Home Page","Puslapio priekis");
INSERT INTO flussi_translations VALUES("20","lt","Menu items","Meniu vienetai");
INSERT INTO flussi_translations VALUES("21","lt","User\'s","Vartotojai");
INSERT INTO flussi_translations VALUES("22","lt","Administration tools","Administravimo įrankiai");
INSERT INTO flussi_translations VALUES("23","lt","Post\'s","Įrašai");
INSERT INTO flussi_translations VALUES("24","lt","Block\'s","Blokai");
INSERT INTO flussi_translations VALUES("25","lt","Usename","Vartotojo Vardas");
INSERT INTO flussi_translations VALUES("26","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("27","lt","Actions","Veiksmas");
INSERT INTO flussi_translations VALUES("28","lt","Places","Vietos");
INSERT INTO flussi_translations VALUES("29","lt","Name","Pavadinimas");
INSERT INTO flussi_translations VALUES("30","lt","Translation added successfully.","Vertimas sėkmingai pridėtas.");
INSERT INTO flussi_translations VALUES("31","lt","Error: Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO flussi_translations VALUES("32","lt","Are you sure you want to delete this place?","Ar tikrai norite ištrinti šią Vietą?");
INSERT INTO flussi_translations VALUES("33","lt","Add/Edit","Pridėti/Redaguoti");
INSERT INTO flussi_translations VALUES("34","lt","Translation updated successfully.","Vertimas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("35","lt","Edit","Redaguoti");
INSERT INTO flussi_translations VALUES("36","lt","Delete","Ištrinti");
INSERT INTO flussi_translations VALUES("37","lt","Code","Kodas");
INSERT INTO flussi_translations VALUES("38","lt","No.","Nr.");
INSERT INTO flussi_translations VALUES("39","lt","Update Settings","Atnaujinti nustatymus");
INSERT INTO flussi_translations VALUES("40","lt","Clear Cache","Išvalyti Talpykla");
INSERT INTO flussi_translations VALUES("41","lt","Create a backup","Sukurti DB kopiją");
INSERT INTO flussi_translations VALUES("42","lt","Files","Failai");
INSERT INTO flussi_translations VALUES("43","lt","File list","Failų sąrašas");
INSERT INTO flussi_translations VALUES("44","lt","Select a file:","Pasirinkite failą:");
INSERT INTO flussi_translations VALUES("45","lt","Upload file","Įkelti failą");
INSERT INTO flussi_translations VALUES("46","lt","Preview","Peržiūra");
INSERT INTO flussi_translations VALUES("47","lt","Copy url","Kopijuoti url");
INSERT INTO flussi_translations VALUES("48","lt","Contact form","Kontaktinė forma");
INSERT INTO flussi_translations VALUES("49","lt","Key","Raktas");
INSERT INTO flussi_translations VALUES("50","lt","Value","Vertė");
INSERT INTO flussi_translations VALUES("51","lt","Save settings","Išsaugoti nustatymus");
INSERT INTO flussi_translations VALUES("52","lt","HTML Code","HTML kodas");
INSERT INTO flussi_translations VALUES("53","lt","Menu Place","Meniu vieta");
INSERT INTO flussi_translations VALUES("54","lt","Place","Vieta");
INSERT INTO flussi_translations VALUES("55","lt","Log off","Atsijungti");
INSERT INTO flussi_translations VALUES("56","lt","Log In","Prisijungti");
INSERT INTO flussi_translations VALUES("57","lt","Sign up","Registruotis");
INSERT INTO flussi_translations VALUES("58","lt","or","arba");
INSERT INTO flussi_translations VALUES("59","lt","Page Menu","Puslapio meniu");
INSERT INTO flussi_translations VALUES("60","lt","Page URL","Puslapio url");
INSERT INTO flussi_translations VALUES("61","lt","Template","Šablonas");
INSERT INTO flussi_translations VALUES("62","lt","Position","Pozicija");
INSERT INTO flussi_translations VALUES("63","lt","Are you sure you want to delete this menu?","Ar tikrai norite ištrinti šį meniu?");
INSERT INTO flussi_translations VALUES("64","lt","Menu item successfully added.","Meniu punktas sėkmingai pridėtas.");
INSERT INTO flussi_translations VALUES("65","lt","Error adding menu item. Try again.","Klaida pridedant meniu punktą. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("66","lt","Menu Name","Meniu pavadinimas");
INSERT INTO flussi_translations VALUES("67","lt","Add Menu","Pridėti meniu");
INSERT INTO flussi_translations VALUES("68","lt","Edit Menu","Redaguoti meniu");
INSERT INTO flussi_translations VALUES("69","lt","Place Name","Vietos pavadinimas");
INSERT INTO flussi_translations VALUES("70","lt","Posts on pages","Įrašai puslapiuose");
INSERT INTO flussi_translations VALUES("71","lt","Title","Antraštė");
INSERT INTO flussi_translations VALUES("72","lt","Content","Turinys");
INSERT INTO flussi_translations VALUES("73","lt","Author","Autorius");
INSERT INTO flussi_translations VALUES("74","lt","Public","Rodomas");
INSERT INTO flussi_translations VALUES("75","lt","Existing Tag\'s","Esančios žymos");
INSERT INTO flussi_translations VALUES("76","lt","Tags","Žymos");
INSERT INTO flussi_translations VALUES("77","lt","Page status","Puslapio būsena");
INSERT INTO flussi_translations VALUES("78","lt","Published","Publikuotas");
INSERT INTO flussi_translations VALUES("79","lt","Draft","Juodraštis");
INSERT INTO flussi_translations VALUES("80","lt","List of backups","Atsarginių kopijų sąrašas");
INSERT INTO flussi_translations VALUES("81","lt","No backups","Nėra atsarginių kopijų.");
INSERT INTO flussi_translations VALUES("82","lt","Custom Blocks","Įvairūs Blokai");
INSERT INTO flussi_translations VALUES("83","lt","Record successfully added.","Įrašas sėkmingai sukurtas.");
INSERT INTO flussi_translations VALUES("84","lt","Error adding Record. Try again.","Pridedant įrašą įvyko klaida. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("85","lt","The record has been updated successfully.","Įrašas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("86","lt","Error updating post. Try again.","Klaida atnaujinant įrašą. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("87","lt","place successfully updated.","Vieta sėkmingai atnaujinta.");
INSERT INTO flussi_translations VALUES("88","lt","Backup deleted successfully!","Atsarginė kopija sėkmingai ištrinta!");
INSERT INTO flussi_translations VALUES("89","lt","Failed to delete backup.","Nepavyko ištrinti atsarginės kopijos.");
INSERT INTO flussi_translations VALUES("90","lt","Error: Please specify a file name.","Klaida: Prašome nurodyti failo pavadinimą.");
INSERT INTO flussi_translations VALUES("91","lt","Confirm deletion","Patvirtinkite šalinimą");
INSERT INTO flussi_translations VALUES("92","lt","place successfully deleted.","Vieta sėkmingai ištrinta.");
INSERT INTO flussi_translations VALUES("93","lt","Error deleting place. Try again.","Klaida trinant maketo vietą. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("94","lt","Edit Place","Redaguoti Vietą");
INSERT INTO flussi_translations VALUES("95","lt","File not found.","Failas nerastas.");
INSERT INTO flussi_translations VALUES("96","lt","Surname","Pavardė");
INSERT INTO flussi_translations VALUES("97","lt","Phone","Telefonas");
INSERT INTO flussi_translations VALUES("98","lt","Email","El.paštas");
INSERT INTO flussi_translations VALUES("99","lt","Role","Teisės");
INSERT INTO flussi_translations VALUES("100","lt","Update User","Atnaujinti vartotoją");
INSERT INTO flussi_translations VALUES("101","lt","Cancel","Atšaukti");
INSERT INTO flussi_translations VALUES("102","lt","Password","Slaptažodis");
INSERT INTO flussi_translations VALUES("103","lt","Confirm Password","Patvirtinti slaptažodį");
INSERT INTO flussi_translations VALUES("104","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("105","lt","Error updating user. Try again.","Klaida atnaujinant naudotoją. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("106","lt","Confirm new password","Patvirtinti naują slaptažodį");
INSERT INTO flussi_translations VALUES("107","lt","Enter new password","Įveskite naują slaptažodį");
INSERT INTO flussi_translations VALUES("108","lt","Admin","Adminas");
INSERT INTO flussi_translations VALUES("109","lt","Moderator","Moderatorius");
INSERT INTO flussi_translations VALUES("110","lt","User","Vartotojas");
INSERT INTO flussi_translations VALUES("111","lt","User not found.","Vartotojas nerastas.");
INSERT INTO flussi_translations VALUES("112","lt","The passwords do not match. Try again.","Slaptažodžiai nesutampa. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("113","lt","Error deleting Custom Block. Try again.","Klaida ištrinant pasirinktinį bloką. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("114","lt","Custom Block successfully deleted.","Pasirinktinis blokas sėkmingai ištrintas.");
INSERT INTO flussi_translations VALUES("115","lt","Menu item successfully deleted.","Meniu punktas sėkmingai ištrintas.");
INSERT INTO flussi_translations VALUES("116","lt","Error deleting menu item. Try again.","Klaida trinant meniu punktą. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("117","lt","Page deleted successfully.","Puslapis sėkmingai ištrintas.");
INSERT INTO flussi_translations VALUES("118","lt","Error deleting page. Try again.","Klaida trinant puslapį. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("119","lt","Failed to delete translation.","Nepavyko ištrinti vertimo.");
INSERT INTO flussi_translations VALUES("120","lt","Translation successfully deleted.","Vertimas sėkmingai ištrintas.");
INSERT INTO flussi_translations VALUES("121","lt","Error: Please specify translation ID.","Klaida: Prašome nurodyti vertimo ID.");
INSERT INTO flussi_translations VALUES("122","lt","Error: Please specify a file name.","Klaida: Prašome nurodyti failo pavadinimą.");
INSERT INTO flussi_translations VALUES("123","lt","File","Failas");
INSERT INTO flussi_translations VALUES("124","lt","deleted successfully.","sėkmingai ištrintas.");
INSERT INTO flussi_translations VALUES("125","lt","Error deleting file from database.","Klaida trinant failą iš duomenų bazės.");
INSERT INTO flussi_translations VALUES("126","lt","Error deleting file from system.","Klaida trinant failą iš sistemos.");
INSERT INTO flussi_translations VALUES("127","lt","No such file found.","Toks failas nerastas.");
INSERT INTO flussi_translations VALUES("128","lt","No file ID specified.","Nenurodytas failo ID.");
INSERT INTO flussi_translations VALUES("129","lt","The menu item has been updated successfully.","Meniu punktas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("130","lt","Error updating menu item. Try again.","Klaida atnaujinant meniu punktą. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("131","lt","Error updating post. Try again.","Klaida atnaujinant įrašą. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("132","lt","The record has been updated successfully.","Įrašas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("133","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO flussi_translations VALUES("134","lt","Error updating user. Try again.","Klaida atnaujinant naudotoją. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("135","lt","uploaded successfully.","sėkmingai įkeltas.");
INSERT INTO flussi_translations VALUES("136","lt","Error loading file.","Klaida įkeliant failą.");
INSERT INTO flussi_translations VALUES("137","lt","Are you sure you want to delete this User?","Ar tikrai norite ištrinti šį naudotoją?");
INSERT INTO flussi_translations VALUES("138","lt","Confirm the removal","Patvirtinkite pašalinimą");
INSERT INTO flussi_translations VALUES("139","lt","Invalid Login Name/email or password.","Neteisingas Prisijungimo Vardas/el. paštas arba slaptažodis.");
INSERT INTO flussi_translations VALUES("140","lt","Login system","Prisijungimo sistema");
INSERT INTO flussi_translations VALUES("141","lt","The content management system is intended for personal websites","Turinio valdymo sistema skirta asmeninėms svetainėms");
INSERT INTO flussi_translations VALUES("142","lt","Login","Prisijungti");
INSERT INTO flussi_translations VALUES("143","lt","Home page","Pagrindinis puslapis");
INSERT INTO flussi_translations VALUES("144","lt","Connect to page","Prisijungimas");
INSERT INTO flussi_translations VALUES("145","lt","User Name","Vartotojo Vardas");
INSERT INTO flussi_translations VALUES("146","lt","Back to","Grįžti į");
INSERT INTO flussi_translations VALUES("147","lt","That Name is already taken. Choose another.","Toks Vardas jau užimtas. Pasirinkite kitą.");
INSERT INTO flussi_translations VALUES("148","lt","User registration failed. Try again.","Vartotojo registracija nepavyko. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("149","lt","Passwords do not match. Try again.","Slaptažodžiai nesutampa. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("150","lt","Registration system","Registracijos sistema");
INSERT INTO flussi_translations VALUES("151","lt","Content management system for personal websites","Turinio valdymo sistema skirta asmeninėms svetainėms");
INSERT INTO flussi_translations VALUES("152","lt","Registration","Registracija");
INSERT INTO flussi_translations VALUES("153","lt","Repeat the password","Pakartokite slaptažodį");
INSERT INTO flussi_translations VALUES("154","lt","Register","Registruotis");
INSERT INTO flussi_translations VALUES("155","lt","Sign out","Atsijungti");
INSERT INTO flussi_translations VALUES("156","lt","Log In","Prisijungti");
INSERT INTO flussi_translations VALUES("157","lt","Sign up","Registruotis");
INSERT INTO flussi_translations VALUES("158","lt","Hello!","Sveiki!");
INSERT INTO flussi_translations VALUES("159","lt","Front page","Puslapio priekis");
INSERT INTO flussi_translations VALUES("160","lt","Log out","Atsijungti");
INSERT INTO flussi_translations VALUES("161","lt","or","arba");
INSERT INTO flussi_translations VALUES("162","lt","Post status","Įrašo būsena");
INSERT INTO flussi_translations VALUES("163","lt","Update Post","Atnaujinti įrašą");
INSERT INTO flussi_translations VALUES("164","lt","Add Post","Pridėti įrašą");
INSERT INTO flussi_translations VALUES("165","lt","Back","Grįžti");
INSERT INTO flussi_translations VALUES("166","lt","Search translations...","Ieškoti vertimo...");
INSERT INTO flussi_translations VALUES("167","lt","Cache cleared successfully!","Talpykla sėkmingai išvalyta!");
INSERT INTO flussi_translations VALUES("168","lt","Failed to clear cache, APCu is not installed!","Nepavyko išvalyti cache, APCu nėra įdiegta!");
INSERT INTO flussi_translations VALUES("169","lt","Backup successfully created.","Atsarginė kopija sėkmingai sukurta.");
INSERT INTO flussi_translations VALUES("170","lt","Failed to create a backup.","Nepavyko sukurti atsarginės kopijos.");
INSERT INTO flussi_translations VALUES("171","lt","Website Name","Svetainės pavadinimas");
INSERT INTO flussi_translations VALUES("172","lt","file uploaded successfully.","failas sėkmingai įkeltas.");
INSERT INTO flussi_translations VALUES("173","lt","Error loading file.","Įkeliant failą įvyko klaida.");
INSERT INTO flussi_translations VALUES("174","lt","Failed to clear cache, APCu is not installed!","Nepavyko išvalyti talpyklos, APCu neįdiegtas!");
INSERT INTO flussi_translations VALUES("175","lt","Create","Sukurti");
INSERT INTO flussi_translations VALUES("176","lt","Error adding place. Try again.","Klaida pridedant vietą. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("177","lt","Place successfully added.","Vieta sėkmingai pridėta.");
INSERT INTO flussi_translations VALUES("178","lt","place successfully updated.","Vieta sėkmingai atnaujinta.");
INSERT INTO flussi_translations VALUES("179","lt","place with this name already exists. Try a different name.","Vieta tokiu pavadinimu jau yra. Pabandykite kitą pavadinimą.");
INSERT INTO flussi_translations VALUES("180","lt","Error updating place. Try again.","Klaida atnaujinant Vietą. Bandyk iš naujo.");
INSERT INTO flussi_translations VALUES("181","lt","Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO flussi_translations VALUES("182","lt","Translation added successfully.","Vertimas sėkmingai pridėtas.");
INSERT INTO flussi_translations VALUES("183","lt","Error: Translation word already exists.","Klaida: verčiamas žodis jau yra.");
INSERT INTO flussi_translations VALUES("184","lt","Block","Blokai");
INSERT INTO flussi_translations VALUES("185","lt","Core Settings","Sistemos įrankiai");
INSERT INTO flussi_translations VALUES("186","lt","Lines per page:","Eilučių per puslapį:");
INSERT INTO flussi_translations VALUES("187","lt","Add new code","Pridėti naują kodą");
INSERT INTO flussi_translations VALUES("188","lt","That Name or Login Name is already taken. Choose another.","Tas vardas arba prisijungimo vardas jau užimtas. Pasirinkite kitą.");
INSERT INTO flussi_translations VALUES("189","lt","Invalid CSRF token. Try again.","Neteisingas CSRF žetonas. Bandykite dar kartą.");
INSERT INTO flussi_translations VALUES("190","lt","Login Name","Prisijungimo Vardas");
INSERT INTO flussi_translations VALUES("191","lt","Login Name or Email","Prisijungimo Vardas / El.paštas");
INSERT INTO flussi_translations VALUES("192","lt","Add Place","Pridėti Vietą");
INSERT INTO flussi_translations VALUES("193","lt","Posts per page","Įrašai per puslapį");
INSERT INTO flussi_translations VALUES("194","lt","Layout Places","Maketo Vietos");
INSERT INTO flussi_translations VALUES("195","lt","Profile","Profilis");
INSERT INTO flussi_translations VALUES("196","lt","User Area","Vartotojo aplinka");
INSERT INTO flussi_translations VALUES("197","lt","You\'ve wandered off into tropical limbo! Nothing to see here.","Jūs nuklydote į tropinę nežinią! Nieko jūs čia nepamatysite.");
INSERT INTO flussi_translations VALUES("198","lt","to return back home.","kad grįžti atgal į pagrindinį puslapį");
INSERT INTO flussi_translations VALUES("199","lt","Click","Spauskite");
INSERT INTO flussi_translations VALUES("200","lt","here","čia");
INSERT INTO flussi_translations VALUES("201","lt","Show","Rodomas");
INSERT INTO flussi_translations VALUES("202","lt","Parent","Tėvinis puslapis");
INSERT INTO flussi_translations VALUES("203","lt","User registration successful. You can now log in.","Vartotojo registracija sėkminga. Dabar galite prisijungti.");
INSERT INTO flussi_translations VALUES("204","lt","Registration Enabled","Registracija leidžiama");
INSERT INTO flussi_translations VALUES("205","lt","Session lifetime in minutes","Sesijos trukmė minutėmis");
INSERT INTO flussi_translations VALUES("206","lt","META Default keywords","META Numatytieji raktažodžiai");
INSERT INTO flussi_translations VALUES("207","lt","No tags have been created","Nėra sukurta nei vieno Tag žymos");
INSERT INTO flussi_translations VALUES("208","lt","Edit your Tags","Redaguokite savo žymas");
INSERT INTO flussi_translations VALUES("209","lt","Registration is currently suspended. Please try again later","Šiuo metu registracija sustabdyta. Pabandykite dar kartą vėliau");
INSERT INTO flussi_translations VALUES("211","lt","Addons","Papildiniai");
INSERT INTO flussi_translations VALUES("212","lt","AddOns","Papildiniai");
INSERT INTO flussi_translations VALUES("213","lt","Themes","Išvaizda");
INSERT INTO flussi_translations VALUES("214","lt","No addons found in the system.","Sistemoje nerasta jokių priedų.");
INSERT INTO flussi_translations VALUES("215","lt","Website addons","Svetainės papildiniai");



INSERT INTO flussi_users VALUES("1","Tester","Admin","tester","8615523111","tests@gl.com","$2y$10$4xw8Ssej8MPQBGHRnqXlieHU6qlKQUKpDgTIj8ZqJg0sCWU6WXIOa","admin");
INSERT INTO flussi_users VALUES("12","Darius","Bester","Petraitis","370524879522","jakius@gail.com","$2y$10$ba9nOVjX/z23XlnEawyJyusfVrtZaJgwVpxFdzBsdNFsuo6lkKvy2","admin");



INSERT INTO flussi_v_custom_blocks VALUES("1"," Box test","6","1"," <h2 class=\"box__title\">Antraštė pirma</h2>\n\n\n\n\n\n\n\n<p class=\"box__text\">Trumpas tekstas box dalis pirmas</p>\n\n\n\n\n\n\n\n   <a href=\"/\" class=\"box__link linkbox\">Box Nuoroda 1</a>");
INSERT INTO flussi_v_custom_blocks VALUES("2","News col 5","3","2","Testuoju News skyrių");
INSERT INTO flussi_v_custom_blocks VALUES("3","Pridėtas Blokas col-sm-5","6","3","Testuoju bloko pridėjimą į col-sm-5 dalį");
INSERT INTO flussi_v_custom_blocks VALUES("4","Testuoju dokumentus","1","4","Bandomas tekstas dokumentuose");
INSERT INTO flussi_v_custom_blocks VALUES("5","Test Contact col 5","12","7","Test Contact block col-sm-5 ");
INSERT INTO flussi_v_custom_blocks VALUES("6","Testuoju home-col-down-12","6","10","Pridedamas bandomasis turinys į home-col-down-12");
INSERT INTO flussi_v_custom_blocks VALUES("7","Box test 2","6","6"," <h2 class=\"box__title\">Antraštė angtra</h2>\n\n\n\n <p class=\"box__text\">Trumpas tekstas box dalis antras</p>\n\n\n\n <a href=\"#\" class=\"box__link linkbox\">Box Nuoroda 2</a>");



INSERT INTO jd_simple VALUES("1","dgdfg","fdgdfg","http://localhost/uploads/jd_simple_img/flusity-b_a252d067e7fe12f7.png","flusity-b_a252d067e7fe12f7.png","6","10","10","2023-07-02 10:59:05","2023-07-02 10:59:05");



INSERT INTO jd_simple_zer VALUES("2","dfsd","dsf","http://localhost/uploads/jd_simple_zer_img/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","1","9","12","2023-07-02 11:01:03","2023-07-02 11:04:40");





SET FOREIGN_KEY_CHECKS=1;