DROP TABLE IF EXISTS categories;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO categories VALUES("79","dd7777777","2023-04-14 18:01:16","2023-04-16 15:26:49");
INSERT INTO categories VALUES("80","testuoju","2023-04-14 18:12:13","2023-04-14 18:12:13");
INSERT INTO categories VALUES("83","fffffddd","2023-04-14 18:20:38","2023-04-14 18:29:15");
INSERT INTO categories VALUES("85","dogas","2023-04-14 18:33:23","2023-04-14 19:04:56");
INSERT INTO categories VALUES("86","kika","2023-04-14 19:04:47","2023-04-14 19:04:47");
INSERT INTO categories VALUES("87","testuoju 55","2023-04-15 11:09:50","2023-04-15 11:09:50");
INSERT INTO categories VALUES("92","fff","2023-04-19 22:49:36","2023-04-19 22:49:36");



DROP TABLE IF EXISTS contact_form_settings;

CREATE TABLE `contact_form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO contact_form_settings VALUES("1","ssssdfff","dddddddd");



DROP TABLE IF EXISTS custom_blocks;

CREATE TABLE `custom_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `html_code` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `custom_blocks_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  CONSTRAINT `custom_blocks_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO custom_blocks VALUES("2","bcvbcv","3","80","cxvv");
INSERT INTO custom_blocks VALUES("3","ffff","1","79","ffbbbbsssss");
INSERT INTO custom_blocks VALUES("7","fghgfh777","6","79","ghghfggh 777777");
INSERT INTO custom_blocks VALUES("8","fff","6","79","fghfh");
INSERT INTO custom_blocks VALUES("9","ghgh","1","79","ghg");



DROP TABLE IF EXISTS files;

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO files VALUES("19","logo_dbc3f8c0e5c17ee1.png","http://localhost/uploads/logo_dbc3f8c0e5c17ee1.png","2023-04-21 13:12:25");
INSERT INTO files VALUES("20","bg23_a1506a0d8103819f.png","http://localhost/uploads/bg23_a1506a0d8103819f.png","2023-04-21 20:15:43");



DROP TABLE IF EXISTS menu;

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO menu VALUES("1","Dokumentai","dokumentai","3","template_left_content","2023-04-15 12:00:19","2023-04-20 13:49:49");
INSERT INTO menu VALUES("3","NAUJIENOS","news","2","template_naujienos","2023-04-16 00:29:51","2023-04-19 23:32:46");
INSERT INTO menu VALUES("6","HOME","index","1","template_index","2023-04-16 15:35:26","2023-04-19 23:38:55");
INSERT INTO menu VALUES("12","Contact","contacts","5","template_contacts","2023-04-21 17:28:01","2023-04-21 17:28:01");



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
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO posts VALUES("1","ggnn","bcncvbvcbsrgfsgf dfgfd","2","admin","2023-04-15 16:08:31","draft","1","ddddfdfddd","2023-04-19 19:17:29");
INSERT INTO posts VALUES("4","Naujas bandymas 3","Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ultricies justo ut purus efficitur, eleifend pellentesque risus cursus. Maecenas ex massa, sagittis id metus non, convallis scelerisque ligula. Vivamus aliquam risus accumsan lacinia eleifend. Nunc vestibulum massa a mauris egestas, quis sollicitudin est posuere. Duis lobortis tincidunt leo, vitae condimentum odio mollis at. Nullam mollis lobortis erat, lobortis mollis mi commodo ac. Nunc in lectus vitae mauris imperdiet varius in id neque. Vestibulum orci risus, posuere in velit eget, ullamcorper convallis augue. Mauris nulla dui, iaculis ac ultrices quis, scelerisque a libero.","2","admin","0000-00-00 00:00:00","published","6","nnnn","2023-04-19 21:36:31");
INSERT INTO posts VALUES("5","fthhj","gfhjgfhjfghjgfhj","2","user","0000-00-00 00:00:00","draft","1","aaa","2023-04-19 19:17:29");
INSERT INTO posts VALUES("8","test www","dfgdfgfg dfgfg","2","user","0000-00-00 00:00:00","draft","3","","2023-04-19 19:17:29");
INSERT INTO posts VALUES("10","test www","tervvr re eshh          šįyįš yįęįšudhhdf  dfhfh fghd","2","user","0000-00-00 00:00:00","published","3","nnnu","2023-04-19 19:17:29");
INSERT INTO posts VALUES("11","sdsrrrrrr","fghghgfbfghb fg hh dh dh gfhgfhdfghgf fhj trtyėį  tėįrsh   jjgdjgj","2","user","0000-00-00 00:00:00","published","1","","2023-04-19 19:17:29");
INSERT INTO posts VALUES("28","sdfsdf","sdfsdf","2","admin","2023-04-19 18:18:44","published","3","aaa","2023-04-19 18:18:44");
INSERT INTO posts VALUES("29","hh","hhh","2","admin","2023-04-19 20:56:21","draft","6","h","2023-04-19 20:56:21");
INSERT INTO posts VALUES("30","nnn","xcvx","2","admin","2023-04-19 21:11:47","draft","3","nnn","2023-04-19 21:49:14");



DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
  `site_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `footer_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO settings VALUES("JD website","JD website description","JD website Footer");



DROP TABLE IF EXISTS translations;

CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(5) NOT NULL,
  `translation_key` varchar(255) NOT NULL,
  `translation_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO translations VALUES("1","lt","Language","Kalba");
INSERT INTO translations VALUES("2","lt","Users","Vartotojai");
INSERT INTO translations VALUES("4","lt","Dashboard","Prietaisų skydelis");
INSERT INTO translations VALUES("5","lt","Translation Key","Verčiamas žodis");
INSERT INTO translations VALUES("6","lt","Translation Value","Išverstas įrašas");
INSERT INTO translations VALUES("7","lt","Categories","Kategorijos");
INSERT INTO translations VALUES("8","lt","Posts","Įrašai");
INSERT INTO translations VALUES("9","lt","Menu","Meniu");
INSERT INTO translations VALUES("10","lt","Block","Blokai");
INSERT INTO translations VALUES("11","lt","Contact Form","Kontaktinė forma");
INSERT INTO translations VALUES("12","lt","Files","Failai");
INSERT INTO translations VALUES("13","lt","Settings","Nustatymai");
INSERT INTO translations VALUES("15","lt","Add","Pridėti");
INSERT INTO translations VALUES("16","lt","Add/Edit","Pridėti/ Redaguoti");
INSERT INTO translations VALUES("17","lt","Translation updated successfully.","Vertimas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("18","lt","Error: Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO translations VALUES("19","lt","Actions","Veiksmai");
INSERT INTO translations VALUES("20","lt","Language Code","Kalbos Kodas");
INSERT INTO translations VALUES("21","lt","Code","Kodas");
INSERT INTO translations VALUES("22","lt","No.","Nr.");
INSERT INTO translations VALUES("23","lt","Delete","Ištrinti");
INSERT INTO translations VALUES("24","lt","Edit","Redaguoti");
INSERT INTO translations VALUES("25","lt","Translation form","Vertimo forma");



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES("2","Darius","ddddd","+3706128848","test@gmail.com","$argon2i$v=19$m=65536,t=4,p=1$MGRmSFR4c0RPMmUvaGdKMg$Pf8H8eqOlanOnqZv2wM/hDFqJIAiddCfFZMvMmKHpLU","admin");
INSERT INTO users VALUES("4","Petras2","Petraitis","+37061366848","test2@gmail.com","$argon2i$v=19$m=65536,t=4,p=1$endPWlNsNDY1R2FFQ09meA$qoMAOJPjxm2XESQ3b4JYs9ZO5I0eB729ebHwTnLB12Q","user");
INSERT INTO users VALUES("9","Vladas","Girinis","+37055557848","test3@gmail.com","$argon2i$v=19$m=131072,t=4,p=2$MTFPa0QwQkNlYnk5T253NA$a1OJXgqleVfIoAFcI8fVlqGzUOctY3DI7wcOaEVWCPI","moderator");
INSERT INTO users VALUES("10","Darius4","44444","+3706124184","test4@gmail.com","$argon2i$v=19$m=131072,t=4,p=2$WXE1VDRpWC50cWY3cUNlaw$5HbcS6+i44OIw7r0H9RIG0nLxt5KUojv7hLZU0foBZ8","user");
INSERT INTO users VALUES("11","Dariusxz","zxdc","+370612174848","test5@gmail.com","$argon2i$v=19$m=131072,t=4,p=2$bE5OZjdCN1MyQWxveG5waQ$hsEm0sa4d626N9admI9eTx3m1DbcNF5Npgl6M7sPnPo","user");



