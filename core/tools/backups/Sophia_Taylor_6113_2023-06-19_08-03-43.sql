SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS contact_form_settings;

CREATE TABLE `contact_form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS files;

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS menu;

CREATE TABLE `menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS places;

CREATE TABLE `places` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS posts;

CREATE TABLE `posts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
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

DROP TABLE IF EXISTS sidebar;

CREATE TABLE `sidebar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `sidebar_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `sidebar` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS tjd_addons;

CREATE TABLE `tjd_addons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_addon` varchar(255) DEFAULT NULL,
  `description_addon` text DEFAULT NULL,
  `sidebar_id` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `version` varchar(50) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `show_front` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sidebar_id` (`sidebar_id`),
  CONSTRAINT `tjd_addons_ibfk_1` FOREIGN KEY (`sidebar_id`) REFERENCES `sidebar` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS translations;

CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(5) NOT NULL,
  `translation_key` varchar(255) NOT NULL,
  `translation_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS v_custom_blocks;

CREATE TABLE `v_custom_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `place_id` int(10) unsigned DEFAULT NULL,
  `html_code` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `place_id` (`place_id`),
  CONSTRAINT `v_custom_blocks_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  CONSTRAINT `v_custom_blocks_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO contact_form_settings VALUES("1","raktas_457","raktas_457_test");



INSERT INTO files VALUES("1","logo_dbc3f8c0e5c17ee1.png","http://localhost/uploads/logo_dbc3f8c0e5c17ee1.png","2023-04-21 13:12:25");
INSERT INTO files VALUES("2","bg23_a1506a0d8103819f.png","http://localhost/uploads/bg23_a1506a0d8103819f.png","2023-04-21 20:15:43");
INSERT INTO files VALUES("3","pexels-paashuu-15526366_71c26724e8db22dc.jpg","http://localhost/uploads/pexels-paashuu-15526366_71c26724e8db22dc.jpg","2023-05-25 21:51:55");
INSERT INTO files VALUES("4","pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","http://localhost/uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","2023-05-28 15:59:43");
INSERT INTO files VALUES("5","pexels-quang-nguyen_8ca6b53cdb562332.jpg","http://localhost/uploads/pexels-quang-nguyen_8ca6b53cdb562332.jpg","2023-05-28 17:18:46");
INSERT INTO files VALUES("6","user-profile_6567794c785fa46b.png","http://localhost/uploads/user-profile_6567794c785fa46b.png","2023-06-11 18:54:40");
INSERT INTO files VALUES("7","flusity-b_b6928c680436df02.png","http://localhost/uploads/flusity-b_b6928c680436df02.png","2023-06-11 22:42:54");



INSERT INTO menu VALUES("1","Dokumentai","dokumentai","3","template_left_content","2023-04-15 12:00:19","2023-06-16 08:53:35","1",NULL);
INSERT INTO menu VALUES("3","NAUJIENOS","news","2","template_naujienos","2023-04-16 00:29:51","2023-06-16 08:53:37","1",NULL);
INSERT INTO menu VALUES("6","HOMES","index","1","template_index","2023-04-16 15:35:26","2023-06-16 08:53:40","1",NULL);
INSERT INTO menu VALUES("12","Kontaktai","contacts","5","template_contacts","2023-04-21 17:28:01","2023-06-16 08:53:43","1",NULL);
INSERT INTO menu VALUES("15","Testuoju2","test","7","template_left_content","2023-06-03 21:09:36","2023-06-04 00:37:33","0","1");



INSERT INTO places VALUES("1","head-box-one","2023-04-14 18:01:16","2023-05-28 11:27:20");
INSERT INTO places VALUES("2","news-right-5","2023-04-14 18:12:13","2023-05-28 11:21:48");
INSERT INTO places VALUES("3","home-right-5","2023-04-14 18:20:38","2023-05-28 11:15:56");
INSERT INTO places VALUES("4","doc-right-5","2023-04-14 18:33:23","2023-05-28 11:20:16");
INSERT INTO places VALUES("5","home-left-7","2023-04-19 22:49:36","2023-05-28 11:24:53");
INSERT INTO places VALUES("6","head-box-two","2023-05-28 11:27:28","2023-05-28 11:27:28");
INSERT INTO places VALUES("7","contact-right-5","2023-05-28 11:28:19","2023-05-28 11:28:19");
INSERT INTO places VALUES("8","contact-left-7","2023-05-28 11:30:01","2023-05-28 11:30:01");
INSERT INTO places VALUES("9","doc-left-7","2023-05-28 11:30:21","2023-05-28 11:30:21");
INSERT INTO places VALUES("10","home-col-down-12","2023-05-28 15:26:33","2023-05-28 15:26:33");



INSERT INTO posts VALUES("1","ggnn","bcncvbvcbsrgfsgf dfgfd","2","admin","2023-04-15 16:08:31","draft","1",NULL,"2023-06-06 22:17:18",NULL,NULL,"0");
INSERT INTO posts VALUES("2","Naujas bandymas 3","&lt;b&gt;Lorem&lt;/b&gt; ipsum dolor sit amet, consectetur adipiscing elit. &lt;img src=&quot;uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg&quot; width=&quot;250px&quot; height=&quot;auto&quot; align=&quot;left&quot; hspace=&quot;15&quot; vspace=&quot;15&quot;/&gt;\n\n\n\nAliquam ultricies justo ut purus efficitur, eleifend pellentesque risus cursus. Maecenas ex massa, sagittis id metus non, convallis scelerisque ligula. Vivamus aliquam risus accumsan lacinia eleifend. Nunc vestibulum massa a mauris egestas, quis sollicitudin est posuere. Duis lobortis tincidunt leo, vitae condimentum odio mollis at. Nullam mollis lobortis erat, lobortis mollis mi commodo ac. Nunc in lectus vitae mauris imperdiet varius in id neque. Vestibulum orci risus, posuere in velit eget, ullamcorper convallis augue. Mauris nulla dui, iaculis ac ultrices quis, scelerisque a libero.","2","admin","2023-01-01 11:03:58","published","6","news","2023-06-10 18:28:38","Flusity is a contemporary PHP CMS project utilizing MVC architecture, MySQL database, and Bootstrap front-end framework. It includes the management of users, posts, menu, blocks and other elements, as well as security and SEO features.","free cms flusity, php cms, cms, website","1");
INSERT INTO posts VALUES("3","fthhj","gfhjgfhjfghjgfhj","2","admin","2023-01-01 02:04:48","draft","1",NULL,"2023-06-06 22:17:29",NULL,NULL,"0");
INSERT INTO posts VALUES("4","test www","dfgdfgfg dfgfg","2","admin","2023-01-01 00:02:48","draft","3",NULL,"2023-06-06 22:17:43",NULL,NULL,"0");
INSERT INTO posts VALUES("5","test www","tervvr re eshh       &lt;b&gt;   šįyįš yįęįšudhhdf  dfhfh fghd&lt;/b&gt;","2","admin","2023-01-01 00:02:40","published","3",NULL,"2023-06-04 23:22:48",NULL,NULL,"0");
INSERT INTO posts VALUES("6","sdsrrrrrr","fghghgfbfghb fg hh dh dh gfhgfhdfghgf fhj trtyėį  tėįrsh   jjgdjgj","2","admin","2023-01-01 00:02:20","published","1",NULL,"2023-05-26 19:21:26",NULL,NULL,"0");
INSERT INTO posts VALUES("7","sdfsdf","sdfsdf","2","admin","2023-04-19 18:18:44","published","3",NULL,"2023-06-06 22:28:48",NULL,NULL,"0");
INSERT INTO posts VALUES("8","hh","hhhccccccc","2","admin","2023-04-19 20:56:21","draft","6",NULL,"2023-06-06 09:54:31",NULL,NULL,"0");
INSERT INTO posts VALUES("9","nnneeeee","xcvxerter e er","2","admin","2023-04-19 21:11:47","draft","3",NULL,"2023-06-06 22:28:42",NULL,NULL,"0");
INSERT INTO posts VALUES("10","asda","&lt;b&gt;adasdasdas&lt;/b&gt;","2","admin","2023-05-26 13:58:04","published","1",NULL,"2023-06-06 22:17:59",NULL,NULL,"0");
INSERT INTO posts VALUES("11","xxxxx","&lt;b&gt;xcvxcvxcvxcv&lt;/b&gt;","2","admin","2023-06-03 20:31:21","published","6",NULL,"2023-06-08 05:54:45","sdfsdf sdvgsdfsdfddddddddd","sdfdsfdf sdfv","0");
INSERT INTO posts VALUES("12","zzzzzzzzzzzzz","xzczxczx x zx zxv erge","2","admin","2023-06-05 23:40:09","draft","6","demo","2023-06-16 19:26:27","zxc x","zzz","0");



INSERT INTO settings VALUES("Free CMS flusity","Flusity is a contemporary PHP CMS project utilizing MVC architecture, MySQL database, and Bootstrap front-end framework. It includes the management of users, posts, menu, blocks and other elements, as well as security and SEO features.","Copyright &copy; flusity JD Theme 2023","1","lt","10","0","30","free cms, php, free website, cms, content management system, free cms flusity, php cms, website ","flusity","flusity-b_b6928c680436df02.png","jdfsite");



INSERT INTO sidebar VALUES("1","Dashboard","fas fa-tachometer-alt","/admin.php",NULL,"1");
INSERT INTO sidebar VALUES("2","Posts","fas fa-newspaper","/core/tools/posts.php",NULL,"2");
INSERT INTO sidebar VALUES("3","Block","fas fa-shapes","/core/tools/customblock.php",NULL,"3");
INSERT INTO sidebar VALUES("4","Files","fas fa-folder","/core/tools/files.php",NULL,"4");
INSERT INTO sidebar VALUES("5","Core Settings","fas fa-cog",NULL,NULL,"5");
INSERT INTO sidebar VALUES("6","Users","fas fa-users","/core/tools/users.php","5","1");
INSERT INTO sidebar VALUES("7","Menu","fas fa-bars","/core/tools/menu.php","5","2");
INSERT INTO sidebar VALUES("8","AddOns","fas fa-puzzle-piece","/core/tools/addons.php","5","3");
INSERT INTO sidebar VALUES("9","Contact Form","fas fa-message","/core/tools/contact_form.php","5","5");
INSERT INTO sidebar VALUES("10","Layout Places","fas fa-tags","/core/tools/places.php","5","6");
INSERT INTO sidebar VALUES("11","Themes","fa-solid fa-brush","/core/tools/themes.php","5","7");
INSERT INTO sidebar VALUES("12","Settings","fas fa-cog","/core/tools/settings.php","5","8");
INSERT INTO sidebar VALUES("13","Language","fas fa-language","/core/tools/language.php","5","4");



INSERT INTO tjd_addons VALUES("1","jd_simple2","This test addon","8","1","1.1v","JD Flusite","2023-06-18 12:42:36","2023-06-19 09:03:04","0");
INSERT INTO tjd_addons VALUES("2","jd_simple","This test addon","8","1","1v","JD Flusite","2023-06-18 16:55:41","2023-06-19 09:03:09","1");



INSERT INTO translations VALUES("1","lt","Language","Kalba");
INSERT INTO translations VALUES("2","lt","Users","Vartotojai");
INSERT INTO translations VALUES("4","lt","Dashboard","Prietaisų skydelis");
INSERT INTO translations VALUES("5","lt","Translation Key","Verčiamas žodis");
INSERT INTO translations VALUES("6","lt","Translation Value","Išverstas įrašas");
INSERT INTO translations VALUES("7","lt","Language Code","Kalbos Kodas");
INSERT INTO translations VALUES("8","lt","Translation form","Vertimo forma");
INSERT INTO translations VALUES("9","lt","Settings successfully updated!","Nustatymai sėkmingai atnaujinti!");
INSERT INTO translations VALUES("10","lt","Page Name","Puslapio pavadinimas");
INSERT INTO translations VALUES("11","lt","Settings","Nustatymai");
INSERT INTO translations VALUES("12","lt","Contact Form","Kontaktų forma");
INSERT INTO translations VALUES("13","lt","Posts","Įrašai");
INSERT INTO translations VALUES("14","lt","Menu","Meniu");
INSERT INTO translations VALUES("15","lt","Username","Vardas");
INSERT INTO translations VALUES("16","lt","META description","META aprašymas");
INSERT INTO translations VALUES("17","lt","Footer text","Apačios tekstas");
INSERT INTO translations VALUES("18","lt","Pretty URL","Gražus URL");
INSERT INTO translations VALUES("19","lt","Home Page","Puslapio priekis");
INSERT INTO translations VALUES("20","lt","Menu items","Meniu vienetai");
INSERT INTO translations VALUES("21","lt","User\'s","Vartotojai");
INSERT INTO translations VALUES("22","lt","Administration tools","Administravimo įrankiai");
INSERT INTO translations VALUES("23","lt","Post\'s","Įrašai");
INSERT INTO translations VALUES("24","lt","Block\'s","Blokai");
INSERT INTO translations VALUES("25","lt","Usename","Vartotojo Vardas");
INSERT INTO translations VALUES("26","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("27","lt","Actions","Veiksmas");
INSERT INTO translations VALUES("28","lt","Places","Vietos");
INSERT INTO translations VALUES("29","lt","Name","Pavadinimas");
INSERT INTO translations VALUES("30","lt","Translation added successfully.","Vertimas sėkmingai pridėtas.");
INSERT INTO translations VALUES("31","lt","Error: Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO translations VALUES("32","lt","Are you sure you want to delete this place?","Ar tikrai norite ištrinti šią Vietą?");
INSERT INTO translations VALUES("33","lt","Add/Edit","Pridėti/Redaguoti");
INSERT INTO translations VALUES("34","lt","Translation updated successfully.","Vertimas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("35","lt","Edit","Redaguoti");
INSERT INTO translations VALUES("36","lt","Delete","Ištrinti");
INSERT INTO translations VALUES("37","lt","Code","Kodas");
INSERT INTO translations VALUES("38","lt","No.","Nr.");
INSERT INTO translations VALUES("39","lt","Update Settings","Atnaujinti nustatymus");
INSERT INTO translations VALUES("40","lt","Clear Cache","Išvalyti Talpykla");
INSERT INTO translations VALUES("41","lt","Create a backup","Sukurti DB kopiją");
INSERT INTO translations VALUES("42","lt","Files","Failai");
INSERT INTO translations VALUES("43","lt","File list","Failų sąrašas");
INSERT INTO translations VALUES("44","lt","Select a file:","Pasirinkite failą:");
INSERT INTO translations VALUES("45","lt","Upload file","Įkelti failą");
INSERT INTO translations VALUES("46","lt","Preview","Peržiūra");
INSERT INTO translations VALUES("47","lt","Copy url","Kopijuoti url");
INSERT INTO translations VALUES("48","lt","Contact form","Kontaktinė forma");
INSERT INTO translations VALUES("49","lt","Key","Raktas");
INSERT INTO translations VALUES("50","lt","Value","Vertė");
INSERT INTO translations VALUES("51","lt","Save settings","Išsaugoti nustatymus");
INSERT INTO translations VALUES("52","lt","HTML Code","HTML kodas");
INSERT INTO translations VALUES("53","lt","Menu Place","Meniu vieta");
INSERT INTO translations VALUES("54","lt","Place","Vieta");
INSERT INTO translations VALUES("55","lt","Log off","Atsijungti");
INSERT INTO translations VALUES("56","lt","Log In","Prisijungti");
INSERT INTO translations VALUES("57","lt","Sign up","Registruotis");
INSERT INTO translations VALUES("58","lt","or","arba");
INSERT INTO translations VALUES("59","lt","Page Menu","Puslapio meniu");
INSERT INTO translations VALUES("60","lt","Page URL","Puslapio url");
INSERT INTO translations VALUES("61","lt","Template","Šablonas");
INSERT INTO translations VALUES("62","lt","Position","Pozicija");
INSERT INTO translations VALUES("63","lt","Are you sure you want to delete this menu?","Ar tikrai norite ištrinti šį meniu?");
INSERT INTO translations VALUES("64","lt","Menu item successfully added.","Meniu punktas sėkmingai pridėtas.");
INSERT INTO translations VALUES("65","lt","Error adding menu item. Try again.","Klaida pridedant meniu punktą. Bandykite dar kartą.");
INSERT INTO translations VALUES("66","lt","Menu Name","Meniu pavadinimas");
INSERT INTO translations VALUES("67","lt","Add Menu","Pridėti meniu");
INSERT INTO translations VALUES("68","lt","Edit Menu","Redaguoti meniu");
INSERT INTO translations VALUES("69","lt","Place Name","Vietos pavadinimas");
INSERT INTO translations VALUES("70","lt","Posts on pages","Įrašai puslapiuose");
INSERT INTO translations VALUES("71","lt","Title","Antraštė");
INSERT INTO translations VALUES("72","lt","Content","Turinys");
INSERT INTO translations VALUES("73","lt","Author","Autorius");
INSERT INTO translations VALUES("74","lt","Public","Rodomas");
INSERT INTO translations VALUES("75","lt","Existing Tag\'s","Esančios žymos");
INSERT INTO translations VALUES("76","lt","Tags","Žymos");
INSERT INTO translations VALUES("77","lt","Page status","Puslapio būsena");
INSERT INTO translations VALUES("78","lt","Published","Publikuotas");
INSERT INTO translations VALUES("79","lt","Draft","Juodraštis");
INSERT INTO translations VALUES("80","lt","List of backups","Atsarginių kopijų sąrašas");
INSERT INTO translations VALUES("81","lt","No backups","Nėra atsarginių kopijų.");
INSERT INTO translations VALUES("82","lt","Custom Blocks","Įvairūs Blokai");
INSERT INTO translations VALUES("83","lt","Record successfully added.","Įrašas sėkmingai sukurtas.");
INSERT INTO translations VALUES("84","lt","Error adding Record. Try again.","Pridedant įrašą įvyko klaida. Bandyk iš naujo.");
INSERT INTO translations VALUES("85","lt","The record has been updated successfully.","Įrašas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("86","lt","Error updating post. Try again.","Klaida atnaujinant įrašą. Bandyk iš naujo.");
INSERT INTO translations VALUES("87","lt","place successfully updated.","Vieta sėkmingai atnaujinta.");
INSERT INTO translations VALUES("88","lt","Backup deleted successfully!","Atsarginė kopija sėkmingai ištrinta!");
INSERT INTO translations VALUES("89","lt","Failed to delete backup.","Nepavyko ištrinti atsarginės kopijos.");
INSERT INTO translations VALUES("90","lt","Error: Please specify a file name.","Klaida: Prašome nurodyti failo pavadinimą.");
INSERT INTO translations VALUES("91","lt","Confirm deletion","Patvirtinkite šalinimą");
INSERT INTO translations VALUES("92","lt","place successfully deleted.","Vieta sėkmingai ištrinta.");
INSERT INTO translations VALUES("93","lt","Error deleting place. Try again.","Klaida trinant maketo vietą. Bandykite dar kartą.");
INSERT INTO translations VALUES("94","lt","Edit Place","Redaguoti Vietą");
INSERT INTO translations VALUES("95","lt","File not found.","Failas nerastas.");
INSERT INTO translations VALUES("96","lt","Surname","Pavardė");
INSERT INTO translations VALUES("97","lt","Phone","Telefonas");
INSERT INTO translations VALUES("98","lt","Email","El.paštas");
INSERT INTO translations VALUES("99","lt","Role","Teisės");
INSERT INTO translations VALUES("100","lt","Update User","Atnaujinti vartotoją");
INSERT INTO translations VALUES("101","lt","Cancel","Atšaukti");
INSERT INTO translations VALUES("102","lt","Password","Slaptažodis");
INSERT INTO translations VALUES("103","lt","Confirm Password","Patvirtinti slaptažodį");
INSERT INTO translations VALUES("104","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("105","lt","Error updating user. Try again.","Klaida atnaujinant naudotoją. Bandyk iš naujo.");
INSERT INTO translations VALUES("106","lt","Confirm new password","Patvirtinti naują slaptažodį");
INSERT INTO translations VALUES("107","lt","Enter new password","Įveskite naują slaptažodį");
INSERT INTO translations VALUES("108","lt","Admin","Adminas");
INSERT INTO translations VALUES("109","lt","Moderator","Moderatorius");
INSERT INTO translations VALUES("110","lt","User","Vartotojas");
INSERT INTO translations VALUES("111","lt","User not found.","Vartotojas nerastas.");
INSERT INTO translations VALUES("112","lt","The passwords do not match. Try again.","Slaptažodžiai nesutampa. Bandyk iš naujo.");
INSERT INTO translations VALUES("113","lt","Error deleting Custom Block. Try again.","Klaida ištrinant pasirinktinį bloką. Bandyk iš naujo.");
INSERT INTO translations VALUES("114","lt","Custom Block successfully deleted.","Pasirinktinis blokas sėkmingai ištrintas.");
INSERT INTO translations VALUES("115","lt","Menu item successfully deleted.","Meniu punktas sėkmingai ištrintas.");
INSERT INTO translations VALUES("116","lt","Error deleting menu item. Try again.","Klaida trinant meniu punktą. Bandykite dar kartą.");
INSERT INTO translations VALUES("117","lt","Page deleted successfully.","Puslapis sėkmingai ištrintas.");
INSERT INTO translations VALUES("118","lt","Error deleting page. Try again.","Klaida trinant puslapį. Bandykite dar kartą.");
INSERT INTO translations VALUES("119","lt","Failed to delete translation.","Nepavyko ištrinti vertimo.");
INSERT INTO translations VALUES("120","lt","Translation successfully deleted.","Vertimas sėkmingai ištrintas.");
INSERT INTO translations VALUES("121","lt","Error: Please specify translation ID.","Klaida: Prašome nurodyti vertimo ID.");
INSERT INTO translations VALUES("122","lt","Error: Please specify a file name.","Klaida: Prašome nurodyti failo pavadinimą.");
INSERT INTO translations VALUES("123","lt","File","Failas");
INSERT INTO translations VALUES("124","lt","deleted successfully.","sėkmingai ištrintas.");
INSERT INTO translations VALUES("125","lt","Error deleting file from database.","Klaida trinant failą iš duomenų bazės.");
INSERT INTO translations VALUES("126","lt","Error deleting file from system.","Klaida trinant failą iš sistemos.");
INSERT INTO translations VALUES("127","lt","No such file found.","Toks failas nerastas.");
INSERT INTO translations VALUES("128","lt","No file ID specified.","Nenurodytas failo ID.");
INSERT INTO translations VALUES("129","lt","The menu item has been updated successfully.","Meniu punktas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("130","lt","Error updating menu item. Try again.","Klaida atnaujinant meniu punktą. Bandykite dar kartą.");
INSERT INTO translations VALUES("131","lt","Error updating post. Try again.","Klaida atnaujinant įrašą. Bandyk iš naujo.");
INSERT INTO translations VALUES("132","lt","The record has been updated successfully.","Įrašas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("133","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("134","lt","Error updating user. Try again.","Klaida atnaujinant naudotoją. Bandyk iš naujo.");
INSERT INTO translations VALUES("135","lt","uploaded successfully.","sėkmingai įkeltas.");
INSERT INTO translations VALUES("136","lt","Error loading file.","Klaida įkeliant failą.");
INSERT INTO translations VALUES("137","lt","Are you sure you want to delete this User?","Ar tikrai norite ištrinti šį naudotoją?");
INSERT INTO translations VALUES("138","lt","Confirm the removal","Patvirtinkite pašalinimą");
INSERT INTO translations VALUES("139","lt","Invalid Login Name/email or password.","Neteisingas Prisijungimo Vardas/el. paštas arba slaptažodis.");
INSERT INTO translations VALUES("140","lt","Login system","Prisijungimo sistema");
INSERT INTO translations VALUES("141","lt","The content management system is intended for personal websites","Turinio valdymo sistema skirta asmeninėms svetainėms");
INSERT INTO translations VALUES("142","lt","Login","Prisijungti");
INSERT INTO translations VALUES("143","lt","Home page","Pagrindinis puslapis");
INSERT INTO translations VALUES("144","lt","Connect to page","Prisijungimas");
INSERT INTO translations VALUES("145","lt","User Name","Vartotojo Vardas");
INSERT INTO translations VALUES("146","lt","Back to","Grįžti į");
INSERT INTO translations VALUES("147","lt","That Name is already taken. Choose another.","Toks Vardas jau užimtas. Pasirinkite kitą.");
INSERT INTO translations VALUES("148","lt","User registration failed. Try again.","Vartotojo registracija nepavyko. Bandykite dar kartą.");
INSERT INTO translations VALUES("149","lt","Passwords do not match. Try again.","Slaptažodžiai nesutampa. Bandykite dar kartą.");
INSERT INTO translations VALUES("150","lt","Registration system","Registracijos sistema");
INSERT INTO translations VALUES("151","lt","Content management system for personal websites","Turinio valdymo sistema skirta asmeninėms svetainėms");
INSERT INTO translations VALUES("152","lt","Registration","Registracija");
INSERT INTO translations VALUES("153","lt","Repeat the password","Pakartokite slaptažodį");
INSERT INTO translations VALUES("154","lt","Register","Registruotis");
INSERT INTO translations VALUES("155","lt","Sign out","Atsijungti");
INSERT INTO translations VALUES("156","lt","Log In","Prisijungti");
INSERT INTO translations VALUES("157","lt","Sign up","Registruotis");
INSERT INTO translations VALUES("158","lt","Hello!","Sveiki!");
INSERT INTO translations VALUES("159","lt","Front page","Puslapio priekis");
INSERT INTO translations VALUES("160","lt","Log out","Atsijungti");
INSERT INTO translations VALUES("161","lt","or","arba");
INSERT INTO translations VALUES("162","lt","Post status","Įrašo būsena");
INSERT INTO translations VALUES("163","lt","Update Post","Atnaujinti įrašą");
INSERT INTO translations VALUES("164","lt","Add Post","Pridėti įrašą");
INSERT INTO translations VALUES("165","lt","Back","Grįžti");
INSERT INTO translations VALUES("166","lt","Search translations...","Ieškoti vertimo...");
INSERT INTO translations VALUES("167","lt","Cache cleared successfully!","Talpykla sėkmingai išvalyta!");
INSERT INTO translations VALUES("168","lt","Failed to clear cache, APCu is not installed!","Nepavyko išvalyti cache, APCu nėra įdiegta!");
INSERT INTO translations VALUES("169","lt","Backup successfully created.","Atsarginė kopija sėkmingai sukurta.");
INSERT INTO translations VALUES("170","lt","Failed to create a backup.","Nepavyko sukurti atsarginės kopijos.");
INSERT INTO translations VALUES("171","lt","Website Name","Svetainės pavadinimas");
INSERT INTO translations VALUES("172","lt","file uploaded successfully.","failas sėkmingai įkeltas.");
INSERT INTO translations VALUES("173","lt","Error loading file.","Įkeliant failą įvyko klaida.");
INSERT INTO translations VALUES("174","lt","Failed to clear cache, APCu is not installed!","Nepavyko išvalyti talpyklos, APCu neįdiegtas!");
INSERT INTO translations VALUES("175","lt","Create","Sukurti");
INSERT INTO translations VALUES("176","lt","Error adding place. Try again.","Klaida pridedant vietą. Bandyk iš naujo.");
INSERT INTO translations VALUES("177","lt","Place successfully added.","Vieta sėkmingai pridėta.");
INSERT INTO translations VALUES("178","lt","place successfully updated.","Vieta sėkmingai atnaujinta.");
INSERT INTO translations VALUES("179","lt","place with this name already exists. Try a different name.","Vieta tokiu pavadinimu jau yra. Pabandykite kitą pavadinimą.");
INSERT INTO translations VALUES("180","lt","Error updating place. Try again.","Klaida atnaujinant Vietą. Bandyk iš naujo.");
INSERT INTO translations VALUES("181","lt","Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO translations VALUES("182","lt","Translation added successfully.","Vertimas sėkmingai pridėtas.");
INSERT INTO translations VALUES("183","lt","Error: Translation word already exists.","Klaida: verčiamas žodis jau yra.");
INSERT INTO translations VALUES("184","lt","Block","Blokai");
INSERT INTO translations VALUES("185","lt","Core Settings","Sistemos įrankiai");
INSERT INTO translations VALUES("186","lt","Lines per page:","Eilučių per puslapį:");
INSERT INTO translations VALUES("187","lt","Add new code","Pridėti naują kodą");
INSERT INTO translations VALUES("188","lt","That Name or Login Name is already taken. Choose another.","Tas vardas arba prisijungimo vardas jau užimtas. Pasirinkite kitą.");
INSERT INTO translations VALUES("189","lt","Invalid CSRF token. Try again.","Neteisingas CSRF žetonas. Bandykite dar kartą.");
INSERT INTO translations VALUES("190","lt","Login Name","Prisijungimo Vardas");
INSERT INTO translations VALUES("191","lt","Login Name or Email","Prisijungimo Vardas / El.paštas");
INSERT INTO translations VALUES("192","lt","Add Place","Pridėti Vietą");
INSERT INTO translations VALUES("193","lt","Posts per page","Įrašai per puslapį");
INSERT INTO translations VALUES("194","lt","Layout Places","Maketo Vietos");
INSERT INTO translations VALUES("195","lt","Profile","Profilis");
INSERT INTO translations VALUES("196","lt","User Area","Vartotojo aplinka");
INSERT INTO translations VALUES("197","lt","You\'ve wandered off into tropical limbo! Nothing to see here.","Jūs nuklydote į tropinę nežinią! Nieko jūs čia nepamatysite.");
INSERT INTO translations VALUES("198","lt","to return back home.","kad grįžti atgal į pagrindinį puslapį");
INSERT INTO translations VALUES("199","lt","Click","Spauskite");
INSERT INTO translations VALUES("200","lt","here","čia");
INSERT INTO translations VALUES("201","lt","Show","Rodomas");
INSERT INTO translations VALUES("202","lt","Parent","Tėvinis puslapis");
INSERT INTO translations VALUES("203","lt","User registration successful. You can now log in.","Vartotojo registracija sėkminga. Dabar galite prisijungti.");
INSERT INTO translations VALUES("204","lt","Registration Enabled","Registracija leidžiama");
INSERT INTO translations VALUES("205","lt","Session lifetime in minutes","Sesijos trukmė minutėmis");
INSERT INTO translations VALUES("206","lt","META Default keywords","META Numatytieji raktažodžiai");
INSERT INTO translations VALUES("207","lt","No tags have been created","Nėra sukurta nei vieno Tag žymos");
INSERT INTO translations VALUES("208","lt","Edit your Tags","Redaguokite savo žymas");
INSERT INTO translations VALUES("209","lt","Registration is currently suspended. Please try again later","Šiuo metu registracija sustabdyta. Pabandykite dar kartą vėliau");



INSERT INTO users VALUES("1","Tester","Admin","test","8615523111","tests@gl.com","$2y$10$i6zaNIMSIhdC5qnxBRUEKOX7NrT3nQU0uVBZsM1PO5RK4MDO/M9zO","admin");



INSERT INTO v_custom_blocks VALUES("1"," Box test","6","1"," <h2 class=\"box__title\">Antraštė pirma</h2>\n\n\n\n<p class=\"box__text\">Trumpas tekstas box dalis pirmas</p>\n\n\n\n   <a href=\"/\" class=\"box__link linkbox\">Box Nuoroda 1</a>");
INSERT INTO v_custom_blocks VALUES("2","News col 5","3","2","Testuoju News skyrių");
INSERT INTO v_custom_blocks VALUES("3","Pridėtas Blokas col-sm-5","6","3","Testuoju bloko pridėjimą į col-sm-5 dalį");
INSERT INTO v_custom_blocks VALUES("4","Testuoju dokumentus","1","4","Bandomas tekstas dokumentuose");
INSERT INTO v_custom_blocks VALUES("5","Test Contact col 5","12","7","Test Contact block col-sm-5 ");
INSERT INTO v_custom_blocks VALUES("6","Testuoju home-col-down-12","6","10","Pridedamas bandomasis turinys į home-col-down-12");
INSERT INTO v_custom_blocks VALUES("7","Box test 2","6","6"," <h2 class=\"box__title\">Antraštė angtra</h2>\n\n\n\n <p class=\"box__text\">Trumpas tekstas box dalis antras</p>\n\n\n\n <a href=\"#\" class=\"box__link linkbox\">Box Nuoroda 2</a>");





SET FOREIGN_KEY_CHECKS=1;