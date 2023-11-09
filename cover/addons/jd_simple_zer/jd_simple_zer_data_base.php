<?php

$createTable1 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_jd_simple_zer (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    lang_en_title TEXT DEFAULT NULL,
    lang_en_description TEXT DEFAULT NULL,
    img_url VARCHAR(255) NOT NULL,
    img_name VARCHAR(255) NOT NULL,
    readmore VARCHAR(255) NOT NULL,
    menu_id int(11) DEFAULT NULL,
    place_id int(11) DEFAULT NULL,
    addon_id int(11) DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$dropTable1 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_jd_simple_zer";


$databaseDropScripts = [$dropTable1];

foreach ($databaseDropScripts as $databaseDropScript) {
    $stmt = $db->prepare($databaseDropScript);
    $stmt->execute();
    if ($stmt->execute() === false) {
        error_log("Klaida vykdant SQL užklausą: " . $stmt->errorInfo()[2]);
    }
}


$databaseScripts = [$createTable1];

foreach ($databaseScripts as $databaseScript) {
    $stmt = $db->prepare($databaseScript);
    $stmt->execute();
    if ($stmt->execute() === false) {
        error_log("Klaida vykdant SQL užklausą: " . $stmt->errorInfo()[2]);
    }
}
