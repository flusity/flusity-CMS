DROP TABLE IF EXISTS contact_form_settings;

CREATE TABLE `contact_form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO contact_form_settings VALUES("1","raktas_457","ratest_8956214");



DROP TABLE IF EXISTS custom_blocks;

CREATE TABLE `custom_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `place_id` int(10) unsigned DEFAULT NULL,
  `html_code` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `place_id` (`place_id`),
  CONSTRAINT `custom_blocks_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  CONSTRAINT `custom_blocks_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO custom_blocks VALUES("2","News col 5","3","80","Testuoju News skyrių");
INSERT INTO custom_blocks VALUES("7","Pridėtas Blokas col-sm-5","6","83","Testuoju bloko pridėjimą į col-sm-5 dalį");
INSERT INTO custom_blocks VALUES("9","Testuoju dokumentus","1","85","Bandomas tekstas dokumentuose");
INSERT INTO custom_blocks VALUES("11","Test Contact col 5","12","101","Test Contact block col-sm-5 ");
INSERT INTO custom_blocks VALUES("13"," Box test","6","79"," <h2 class=\"box__title\">Antraštė pirma</h2>\n<p class=\"box__text\">Trumpas tekstas box dalis pirmas</p>\n   <a href=\"#\" class=\"box__link\">Box Nuoroda 1</a>");
INSERT INTO custom_blocks VALUES("14","Testuoju home-col-down-12","6","104","Pridedamas bandomasis turinys į home-col-down-12");
INSERT INTO custom_blocks VALUES("15","Box test 2","6","100"," <h2 class=\"box__title\">Antraštė angtra</h2>\n <p class=\"box__text\">Trumpas tekstas box dalis antras</p>\n <a href=\"#\" class=\"box__link\">Box Nuoroda 2</a>");



DROP TABLE IF EXISTS files;

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO files VALUES("19","logo_dbc3f8c0e5c17ee1.png","http://localhost/uploads/logo_dbc3f8c0e5c17ee1.png","2023-04-21 13:12:25");
INSERT INTO files VALUES("20","bg23_a1506a0d8103819f.png","http://localhost/uploads/bg23_a1506a0d8103819f.png","2023-04-21 20:15:43");
INSERT INTO files VALUES("22","pexels-paashuu-15526366_71c26724e8db22dc.jpg","http://localhost/uploads/pexels-paashuu-15526366_71c26724e8db22dc.jpg","2023-05-25 21:51:55");
INSERT INTO files VALUES("24","pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","http://localhost/uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg","2023-05-28 15:59:43");
INSERT INTO files VALUES("25","pexels-quang-nguyen_8ca6b53cdb562332.jpg","http://localhost/uploads/pexels-quang-nguyen_8ca6b53cdb562332.jpg","2023-05-28 17:18:46");



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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO menu VALUES("1","Dokumentai","dokumentai","3","template_left_content","2023-04-15 12:00:19","2023-04-20 13:49:49");
INSERT INTO menu VALUES("3","NAUJIENOS","news","2","template_naujienos","2023-04-16 00:29:51","2023-04-19 23:32:46");
INSERT INTO menu VALUES("6","HOME","index","1","template_index","2023-04-16 15:35:26","2023-04-19 23:38:55");
INSERT INTO menu VALUES("12","Kontaktai","contacts","5","template_contacts","2023-04-21 17:28:01","2023-05-22 22:41:19");



DROP TABLE IF EXISTS places;

CREATE TABLE `places` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO places VALUES("79","head-box-one","2023-04-14 18:01:16","2023-05-28 11:27:20");
INSERT INTO places VALUES("80","news-right-5","2023-04-14 18:12:13","2023-05-28 11:21:48");
INSERT INTO places VALUES("83","home-right-5","2023-04-14 18:20:38","2023-05-28 11:15:56");
INSERT INTO places VALUES("85","doc-right-5","2023-04-14 18:33:23","2023-05-28 11:20:16");
INSERT INTO places VALUES("92","home-left-7","2023-04-19 22:49:36","2023-05-28 11:24:53");
INSERT INTO places VALUES("100","head-box-two","2023-05-28 11:27:28","2023-05-28 11:27:28");
INSERT INTO places VALUES("101","contact-right-5","2023-05-28 11:28:19","2023-05-28 11:28:19");
INSERT INTO places VALUES("102","contact-left-7","2023-05-28 11:30:01","2023-05-28 11:30:01");
INSERT INTO places VALUES("103","doc-left-7","2023-05-28 11:30:21","2023-05-28 11:30:21");
INSERT INTO places VALUES("104","home-col-down-12","2023-05-28 15:26:33","2023-05-28 15:26:33");



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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO posts VALUES("1","ggnn","bcncvbvcbsrgfsgf dfgfd","2","admin","2023-04-15 16:08:31","draft","1","ddddfdfddd","2023-04-19 19:17:29");
INSERT INTO posts VALUES("4","Naujas bandymas 3","&lt;b&gt;Lorem&lt;/b&gt; ipsum dolor sit amet, consectetur adipiscing elit. &lt;img src=&quot;uploads/pexels-dominika-roseclay_2b7dd92bc8d188b4.jpg&quot; width=&quot;250px&quot; height=&quot;auto&quot; align=&quot;left&quot; hspace=&quot;15&quot; vspace=&quot;15&quot;/&gt;\nAliquam ultricies justo ut purus efficitur, eleifend pellentesque risus cursus. Maecenas ex massa, sagittis id metus non, convallis scelerisque ligula. Vivamus aliquam risus accumsan lacinia eleifend. Nunc vestibulum massa a mauris egestas, quis sollicitudin est posuere. Duis lobortis tincidunt leo, vitae condimentum odio mollis at. Nullam mollis lobortis erat, lobortis mollis mi commodo ac. Nunc in lectus vitae mauris imperdiet varius in id neque. Vestibulum orci risus, posuere in velit eget, ullamcorper convallis augue. Mauris nulla dui, iaculis ac ultrices quis, scelerisque a libero.","2","admin","0000-00-00 00:00:00","published","6","nnnn","2023-06-02 13:38:31");
INSERT INTO posts VALUES("5","fthhj","gfhjgfhjfghjgfhj","2","user","0000-00-00 00:00:00","draft","1","aaa","2023-04-19 19:17:29");
INSERT INTO posts VALUES("8","test www","dfgdfgfg dfgfg","2","admin","0000-00-00 00:00:00","draft","3","wwwc","2023-05-25 12:36:58");
INSERT INTO posts VALUES("10","test www","tervvr re eshh          šįyįš yįęįšudhhdf  dfhfh fghd","2","admin","0000-00-00 00:00:00","published","3","nnnu","2023-05-25 12:48:58");
INSERT INTO posts VALUES("11","sdsrrrrrr","fghghgfbfghb fg hh dh dh gfhgfhdfghgf fhj trtyėį  tėįrsh   jjgdjgj","2","admin","0000-00-00 00:00:00","published","1","","2023-05-26 19:21:26");
INSERT INTO posts VALUES("28","sdfsdf","sdfsdf","2","admin","2023-04-19 18:18:44","published","3","aaa","2023-05-25 12:25:46");
INSERT INTO posts VALUES("29","hh","hhhccccccc","2","admin","2023-04-19 20:56:21","draft","6","hddzf","2023-05-26 19:21:11");
INSERT INTO posts VALUES("30","nnneeeee","xcvxerter e er","2","admin","2023-04-19 21:11:47","draft","3","nnnf","2023-05-26 13:56:16");
INSERT INTO posts VALUES("31","asda","adasdasdas","2","admin","2023-05-26 13:58:04","published","1","nnnn","2023-05-26 19:18:54");



DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
  `site_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `footer_text` text NOT NULL,
  `pretty_url` int(1) NOT NULL DEFAULT 0,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `posts_per_page` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO settings VALUES("JD website","JD website description","Copyright &copy; JD Theme 2023","1","lt","10");



DROP TABLE IF EXISTS translations;

CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(5) NOT NULL,
  `translation_key` varchar(255) NOT NULL,
  `translation_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO translations VALUES("1","lt","Language","Kalba");
INSERT INTO translations VALUES("2","lt","Users","Vartotojai");
INSERT INTO translations VALUES("4","lt","Dashboard","Prietaisų skydelis");
INSERT INTO translations VALUES("5","lt","Translation Key","Verčiamas žodis");
INSERT INTO translations VALUES("6","lt","Translation Value","Išverstas įrašas");
INSERT INTO translations VALUES("26","lt","Language Code","Kalbos Kodas");
INSERT INTO translations VALUES("27","lt","Translation form","Vertimo forma");
INSERT INTO translations VALUES("28","lt","Settings successfully updated!","Nustatymai sėkmingai atnaujinti!");
INSERT INTO translations VALUES("29","lt","Page Name","Puslapio pavadinimas");
INSERT INTO translations VALUES("30","lt","Settings","Nustatymai");
INSERT INTO translations VALUES("31","lt","Files","Failai");
INSERT INTO translations VALUES("32","lt","Contact Form","Kontaktų forma");
INSERT INTO translations VALUES("33","lt","Posts","Įrašai");
INSERT INTO translations VALUES("34","lt","Menu","Meniu");
INSERT INTO translations VALUES("35","lt","Username","Vardas");
INSERT INTO translations VALUES("36","lt","META description","META aprašymas");
INSERT INTO translations VALUES("37","lt","Footer text","Apačios tekstas");
INSERT INTO translations VALUES("38","lt","Pretty URL","Gražus URL");
INSERT INTO translations VALUES("39","lt","Home Page","Puslapio priekis");
INSERT INTO translations VALUES("40","lt","Menu items","Meniu vienetai");
INSERT INTO translations VALUES("41","lt","User\'s","Vartotojai");
INSERT INTO translations VALUES("42","lt","Administration tools","Administravimo įrankiai");
INSERT INTO translations VALUES("43","lt","Post\'s","Įrašai");
INSERT INTO translations VALUES("44","lt","Block\'s","Blokai");
INSERT INTO translations VALUES("45","lt","Usename","Vartotojo Vardas");
INSERT INTO translations VALUES("46","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("48","lt","Actions","Veiksmas");
INSERT INTO translations VALUES("49","lt","Places","Vietos");
INSERT INTO translations VALUES("50","lt","Name","Pavadinimas");
INSERT INTO translations VALUES("51","lt","Translation added successfully.","Vertimas sėkmingai pridėtas.");
INSERT INTO translations VALUES("52","lt","Error: Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO translations VALUES("54","lt","Are you sure you want to delete this place?","Ar tikrai norite ištrinti šią Vietą?");
INSERT INTO translations VALUES("55","lt","Add/Edit","Pridėti/Redaguoti");
INSERT INTO translations VALUES("56","lt","Translation updated successfully.","Vertimas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("57","lt","Edit","Redaguoti");
INSERT INTO translations VALUES("58","lt","Delete","Ištrinti");
INSERT INTO translations VALUES("59","lt","Code","Kodas");
INSERT INTO translations VALUES("60","lt","No.","Nr.");
INSERT INTO translations VALUES("61","lt","Update Settings","Atnaujinti nustatymus");
INSERT INTO translations VALUES("62","lt","Clear Cache","Išvalyti Talpykla");
INSERT INTO translations VALUES("63","lt","Create a backup","Sukurti DB kopiją");
INSERT INTO translations VALUES("64","lt","Files","Failai");
INSERT INTO translations VALUES("65","lt","File list","Failų sąrašas");
INSERT INTO translations VALUES("66","lt","Select a file:","Pasirinkite failą:");
INSERT INTO translations VALUES("67","lt","Upload file","Įkelti failą");
INSERT INTO translations VALUES("68","lt","Preview","Peržiūra");
INSERT INTO translations VALUES("69","lt","Copy url","Kopijuoti url");
INSERT INTO translations VALUES("70","lt","Contact form","Kontaktinė forma");
INSERT INTO translations VALUES("71","lt","Key","Raktas");
INSERT INTO translations VALUES("72","lt","Value","Vertė");
INSERT INTO translations VALUES("73","lt","Save settings","Išsaugoti nustatymus");
INSERT INTO translations VALUES("74","lt","HTML Code","HTML kodas");
INSERT INTO translations VALUES("75","lt","Menu Place","Meniu vieta");
INSERT INTO translations VALUES("76","lt","Place","Vieta");
INSERT INTO translations VALUES("77","lt","Log off","Atsijungti");
INSERT INTO translations VALUES("78","lt","Log In","Prisijungti");
INSERT INTO translations VALUES("79","lt","Sign up","Registruotis");
INSERT INTO translations VALUES("80","lt","or","arba");
INSERT INTO translations VALUES("81","lt","Page Menu","Puslapio meniu");
INSERT INTO translations VALUES("82","lt","Page URL","Puslapio url");
INSERT INTO translations VALUES("83","lt","Template","Šablonas");
INSERT INTO translations VALUES("84","lt","Position","Pozicija");
INSERT INTO translations VALUES("86","lt","Confirm deletion","Patvirtinkite šalinimą");
INSERT INTO translations VALUES("87","lt","Are you sure you want to delete this menu?","Ar tikrai norite ištrinti šį meniu?");
INSERT INTO translations VALUES("88","lt","Menu item successfully added.","Meniu punktas sėkmingai pridėtas.");
INSERT INTO translations VALUES("89","lt","Error adding menu item. Try again.","Klaida pridedant meniu punktą. Bandykite dar kartą.");
INSERT INTO translations VALUES("90","lt","Menu Name","Meniu pavadinimas");
INSERT INTO translations VALUES("91","lt","Add Menu","Pridėti meniu");
INSERT INTO translations VALUES("92","lt","Edit Menu","Redaguoti meniu");
INSERT INTO translations VALUES("93","lt","Place Name","Vietos pavadinimas");
INSERT INTO translations VALUES("95","lt","Posts on pages","Įrašai puslapiuose");
INSERT INTO translations VALUES("96","lt","Title","Antraštė");
INSERT INTO translations VALUES("97","lt","Content","Turinys");
INSERT INTO translations VALUES("98","lt","Author","Autorius");
INSERT INTO translations VALUES("99","lt","Public","Rodomas");
INSERT INTO translations VALUES("100","lt","Existing Tag\'s","Esančios žymos");
INSERT INTO translations VALUES("101","lt","Tags","Žymos");
INSERT INTO translations VALUES("102","lt","Page status","Puslapio būsena");
INSERT INTO translations VALUES("103","lt","Published","Publikuotas");
INSERT INTO translations VALUES("104","lt","Draft","Juodraštis");
INSERT INTO translations VALUES("105","lt","List of backups","Atsarginių kopijų sąrašas");
INSERT INTO translations VALUES("106","lt","No backups","Nėra atsarginių kopijų.");
INSERT INTO translations VALUES("107","lt","Custom Blocks","Įvairūs Blokai");
INSERT INTO translations VALUES("109","lt","Error adding place. Try again.","Klaida pridedant Place. Bandykite dar kartą.");
INSERT INTO translations VALUES("110","lt","Record successfully added.","Įrašas sėkmingai sukurtas.");
INSERT INTO translations VALUES("111","lt","Error adding Record. Try again.","Pridedant įrašą įvyko klaida. Bandyk iš naujo.");
INSERT INTO translations VALUES("112","lt","The record has been updated successfully.","Įrašas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("113","lt","Error updating post. Try again.","Klaida atnaujinant įrašą. Bandyk iš naujo.");
INSERT INTO translations VALUES("114","lt","place successfully updated.","Vieta sėkmingai atnaujinta.");
INSERT INTO translations VALUES("116","lt","Backup deleted successfully!","Atsarginė kopija sėkmingai ištrinta!");
INSERT INTO translations VALUES("117","lt","Failed to delete backup.","Nepavyko ištrinti atsarginės kopijos.");
INSERT INTO translations VALUES("118","lt","Error: Please specify a file name.","Klaida: Prašome nurodyti failo pavadinimą.");
INSERT INTO translations VALUES("120","lt","Confirm deletion","Patvirtinkite šalinimą");
INSERT INTO translations VALUES("121","lt","place successfully deleted.","Vieta sėkmingai ištrinta.");
INSERT INTO translations VALUES("122","lt","Error deleting place. Try again.","Klaida trinant Place. Bandykite dar kartą.");
INSERT INTO translations VALUES("123","lt","Edit Place","Redaguoti Vietą");
INSERT INTO translations VALUES("124","lt","File not found.","Failas nerastas.");
INSERT INTO translations VALUES("125","lt","Surname","Pavardė");
INSERT INTO translations VALUES("126","lt","Phone","Telefonas");
INSERT INTO translations VALUES("127","lt","Email","El.paštas");
INSERT INTO translations VALUES("128","lt","Role","Teisės");
INSERT INTO translations VALUES("129","lt","Update User","Atnaujinti vartotoją");
INSERT INTO translations VALUES("130","lt","Cancel","Atšaukti");
INSERT INTO translations VALUES("131","lt","Password","Slaptažodis");
INSERT INTO translations VALUES("132","lt","Confirm Password","Patvirtinti slaptažodį");
INSERT INTO translations VALUES("133","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("134","lt","Error updating user. Try again.","Klaida atnaujinant naudotoją. Bandyk iš naujo.");
INSERT INTO translations VALUES("135","lt","Confirm new password","Patvirtinti naują slaptažodį");
INSERT INTO translations VALUES("136","lt","Enter new password","Įveskite naują slaptažodį");
INSERT INTO translations VALUES("137","lt","Admin","Adminas");
INSERT INTO translations VALUES("138","lt","Moderator","Moderatorius");
INSERT INTO translations VALUES("139","lt","User","Vartotojas");
INSERT INTO translations VALUES("140","lt","User not found.","Vartotojas nerastas.");
INSERT INTO translations VALUES("141","lt","The passwords do not match. Try again.","Slaptažodžiai nesutampa. Bandyk iš naujo.");
INSERT INTO translations VALUES("142","lt","Error deleting Custom Block. Try again.","Klaida ištrinant pasirinktinį bloką. Bandyk iš naujo.");
INSERT INTO translations VALUES("143","lt","Custom Block successfully deleted.","Pasirinktinis blokas sėkmingai ištrintas.");
INSERT INTO translations VALUES("144","lt","Menu item successfully deleted.","Meniu punktas sėkmingai ištrintas.");
INSERT INTO translations VALUES("145","lt","Error deleting menu item. Try again.","Klaida trinant meniu punktą. Bandykite dar kartą.");
INSERT INTO translations VALUES("146","lt","Page deleted successfully.","Puslapis sėkmingai ištrintas.");
INSERT INTO translations VALUES("147","lt","Error deleting page. Try again.","Klaida trinant puslapį. Bandykite dar kartą.");
INSERT INTO translations VALUES("148","lt","Failed to delete translation.","Nepavyko ištrinti vertimo.");
INSERT INTO translations VALUES("149","lt","Translation successfully deleted.","Vertimas sėkmingai ištrintas.");
INSERT INTO translations VALUES("150","lt","Error: Please specify translation ID.","Klaida: Prašome nurodyti vertimo ID.");
INSERT INTO translations VALUES("151","lt","Error: Please specify a file name.","Klaida: Prašome nurodyti failo pavadinimą.");
INSERT INTO translations VALUES("152","lt","File","Failas");
INSERT INTO translations VALUES("153","lt","deleted successfully.","sėkmingai ištrintas.");
INSERT INTO translations VALUES("154","lt","Error deleting file from database.","Klaida trinant failą iš duomenų bazės.");
INSERT INTO translations VALUES("155","lt","Error deleting file from system.","Klaida trinant failą iš sistemos.");
INSERT INTO translations VALUES("156","lt","No such file found.","Toks failas nerastas.");
INSERT INTO translations VALUES("157","lt","No file ID specified.","Nenurodytas failo ID.");
INSERT INTO translations VALUES("158","lt","The menu item has been updated successfully.","Meniu punktas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("159","lt","Error updating menu item. Try again.","Klaida atnaujinant meniu punktą. Bandykite dar kartą.");
INSERT INTO translations VALUES("160","lt","Error updating post. Try again.","Klaida atnaujinant įrašą. Bandyk iš naujo.");
INSERT INTO translations VALUES("161","lt","The record has been updated successfully.","Įrašas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("162","lt","User successfully updated.","Vartotojas sėkmingai atnaujintas.");
INSERT INTO translations VALUES("163","lt","Error updating user. Try again.","Klaida atnaujinant naudotoją. Bandyk iš naujo.");
INSERT INTO translations VALUES("164","lt","uploaded successfully.","sėkmingai įkeltas.");
INSERT INTO translations VALUES("165","lt","Error loading file.","Klaida įkeliant failą.");
INSERT INTO translations VALUES("166","lt","Are you sure you want to delete this User?","Ar tikrai norite ištrinti šį naudotoją?");
INSERT INTO translations VALUES("167","lt","Confirm the removal","Patvirtinkite pašalinimą");
INSERT INTO translations VALUES("168","lt","Invalid Login Name/email or password.","Neteisingas Prisijungimo Vardas/el. paštas arba slaptažodis.");
INSERT INTO translations VALUES("169","lt","Login system","Prisijungimo sistema");
INSERT INTO translations VALUES("170","lt","The content management system is intended for personal websites","Turinio valdymo sistema skirta asmeninėms svetainėms");
INSERT INTO translations VALUES("171","lt","Login","Prisijungti");
INSERT INTO translations VALUES("172","lt","Home page","Pagrindinis puslapis");
INSERT INTO translations VALUES("173","lt","Connect to page","Prisijungimas");
INSERT INTO translations VALUES("174","lt","User Name","Vartotojo Vardas");
INSERT INTO translations VALUES("175","lt","Back to","Grįžti į");
INSERT INTO translations VALUES("176","lt","That Name is already taken. Choose another.","Toks Vardas jau užimtas. Pasirinkite kitą.");
INSERT INTO translations VALUES("177","lt","User registration failed. Try again.","Vartotojo registracija nepavyko. Bandykite dar kartą.");
INSERT INTO translations VALUES("178","lt","Passwords do not match. Try again.","Slaptažodžiai nesutampa. Bandykite dar kartą.");
INSERT INTO translations VALUES("179","lt","Registration system","Registracijos sistema");
INSERT INTO translations VALUES("180","lt","Content management system for personal websites","Turinio valdymo sistema skirta asmeninėms svetainėms");
INSERT INTO translations VALUES("181","lt","Registration","Registracija");
INSERT INTO translations VALUES("182","lt","Repeat the password","Pakartokite slaptažodį");
INSERT INTO translations VALUES("183","lt","Register","Registruotis");
INSERT INTO translations VALUES("184","lt","Sign out","Atsijungti");
INSERT INTO translations VALUES("185","lt","Log In","Prisijungti");
INSERT INTO translations VALUES("186","lt","Sign up","Registruotis");
INSERT INTO translations VALUES("187","lt","Hello","Sveiki");
INSERT INTO translations VALUES("188","lt","Front page","Puslapio priekis");
INSERT INTO translations VALUES("189","lt","Log out","Atsijungti");
INSERT INTO translations VALUES("190","lt","or","arba");
INSERT INTO translations VALUES("191","lt","Post status","Įrašo būsena");
INSERT INTO translations VALUES("192","lt","Update Post","Atnaujinti įrašą");
INSERT INTO translations VALUES("193","lt","Add Post","Pridėti įrašą");
INSERT INTO translations VALUES("194","lt","Back","Grįžti");
INSERT INTO translations VALUES("195","lt","Search translations...","Ieškoti vertimo...");
INSERT INTO translations VALUES("196","lt","Cache cleared successfully!","Talpykla sėkmingai išvalyta!");
INSERT INTO translations VALUES("197","lt","Failed to clear cache, APCu is not installed!","Nepavyko išvalyti cache, APCu nėra įdiegta!");
INSERT INTO translations VALUES("198","lt","Backup successfully created.","Atsarginė kopija sėkmingai sukurta.");
INSERT INTO translations VALUES("199","lt","Failed to create a backup.","Nepavyko sukurti atsarginės kopijos.");
INSERT INTO translations VALUES("200","lt","Website Name","Svetainės pavadinimas");
INSERT INTO translations VALUES("201","lt","file uploaded successfully.","failas sėkmingai įkeltas.");
INSERT INTO translations VALUES("202","lt","Error loading file.","Įkeliant failą įvyko klaida.");
INSERT INTO translations VALUES("203","lt","Failed to clear cache, APCu is not installed!","Nepavyko išvalyti talpyklos, APCu neįdiegtas!");
INSERT INTO translations VALUES("204","lt","Create","Sukurti");
INSERT INTO translations VALUES("206","lt","Error adding place. Try again.","Klaida pridedant Place. Bandyk iš naujo.");
INSERT INTO translations VALUES("207","lt","Place successfully added.","Vieta sėkmingai pridėta.");
INSERT INTO translations VALUES("208","lt","place successfully updated.","Vieta sėkmingai atnaujinta.");
INSERT INTO translations VALUES("209","lt","place with this name already exists. Try a different name.","Vieta tokiu pavadinimu jau yra. Pabandykite kitą pavadinimą.");
INSERT INTO translations VALUES("210","lt","Error updating place. Try again.","Klaida atnaujinant Vietą. Bandyk iš naujo.");
INSERT INTO translations VALUES("212","lt","Please fill in all fields.","Klaida: užpildykite visus laukus.");
INSERT INTO translations VALUES("214","lt","Translation added successfully.","Vertimas sėkmingai pridėtas.");
INSERT INTO translations VALUES("215","lt","Error: Translation word already exists.","Klaida: verčiamas žodis jau yra.");
INSERT INTO translations VALUES("216","lt","Block","Blokai");
INSERT INTO translations VALUES("217","lt","Core Settings","Pagrindiniai nustatymai");
INSERT INTO translations VALUES("218","lt","Lines per page:","Eilučių per puslapį:");
INSERT INTO translations VALUES("219","lt","Add new code","Pridėti naują kodą");
INSERT INTO translations VALUES("220","lt","That Name or Login Name is already taken. Choose another.","Tas vardas arba prisijungimo vardas jau užimtas. Pasirinkite kitą.");
INSERT INTO translations VALUES("221","lt","Invalid CSRF token. Try again.","Neteisingas CSRF žetonas. Bandykite dar kartą.");
INSERT INTO translations VALUES("222","lt","Login Name","Prisijungimo Vardas");
INSERT INTO translations VALUES("223","lt","Login Name or Email","Prisijungimo Vardas / El.paštas");
INSERT INTO translations VALUES("224","lt","Add Place","Pridėti Vietą");



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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES("2","Admin7","Admin","Administratorius","+37061287842","admin@js.com","$argon2i$v=19$m=131072,t=4,p=2$VW5lSlRCcENXWTUuQmpqdA$N2fXosH8kiamXeZkmrXuykMuGbKjjuyBWb97M9eH1mM","admin");
INSERT INTO users VALUES("4","User11","User","Petraitis","+37061366841","test2@gmail.com","$argon2i$v=19$m=131072,t=4,p=2$Sm9aWWFZcGFkWnJqTG5wbA$TYxEvzRh3tRU/CYXqQdSvHgAtjHZjgf/HqnpoCL77mY","user");
INSERT INTO users VALUES("9","Moder4","Moderator","Girinis5","+37055557847","test3@gmail.com","$argon2i$v=19$m=131072,t=4,p=2$Q09rY1p5bExBcnouWnBjag$4lj8EPZIAjowxL2qEYOn9+F1f9dIzqFCign/nVFfcaI","moderator");
INSERT INTO users VALUES("14","Darkon","Darius","Jakaitis","+370678654645","testusers@userv.com","$argon2i$v=19$m=131072,t=4,p=2$Y2dxZkR6TFdUY1pjSC5ZVQ$14ajUVQnKVzLxMlxwkcJApTGfVWDiOxa6xrkEcm/Xh0","admin");
INSERT INTO users VALUES("16","TestuojuV","Sokis","Getraitis5","370613664555","testre@js.com","$argon2i$v=19$m=131072,t=4,p=2$ZzFVYnlFSHFmUWg1dGFSTQ$/fh96Kx+jPHiM4l75iiDyaYO9av0i5bFHA7ibWUBK/o","user");



