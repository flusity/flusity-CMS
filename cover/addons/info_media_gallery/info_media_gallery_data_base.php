<?php

$createTable1 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_info_media_gallery (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
gallery_name TEXT DEFAULT NULL,
gallery_css_style_settings TEXT NOT NULL,
menu_id int(11) DEFAULT NULL,
place_id int(11) DEFAULT NULL,
addon_id int(11) DEFAULT NULL,
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

$createTable2 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_info_media_gallery_item (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title TEXT DEFAULT NULL,
    media_description TEXT NOT NULL,
    hyperlink TEXT NOT NULL,
    media_file_id  int(11) DEFAULT NULL,
    id_info_media_gallery int(11) DEFAULT NULL,    
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";


$dropTable1 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_info_media_gallery"; 
$dropTable2 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_info_media_gallery_item";


$databaseDropScripts = [$dropTable1, $dropTable2];

foreach ($databaseDropScripts as $databaseDropScript) {
    $stmt = $db->prepare($databaseDropScript);
    $stmt->execute();
    if ($stmt->execute() === false) {
        error_log("Klaida vykdant SQL užklausą: " . $stmt->errorInfo()[2]);
    }
}


$databaseScripts = [$createTable1, $createTable2];

foreach ($databaseScripts as $databaseScript) {
    $stmt = $db->prepare($databaseScript);
    $stmt->execute();
    if ($stmt->execute() === false) {
        error_log("Klaida vykdant SQL užklausą: " . $stmt->errorInfo()[2]);
    }
}