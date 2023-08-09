<?php
$configurations = require $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';

// Duomenų gavimas iš duomenų bazės
$prefix = $configurations['prefix'];

$databaseScript = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_jd_simple_zer (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    img_url VARCHAR(255) NOT NULL,
    img_name VARCHAR(255) NOT NULL,
    readmore VARCHAR(255) NOT NULL,
    menu_id int(11) DEFAULT NULL,
    place_id int(11) DEFAULT NULL,
    addon_id int(11) DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$databaseDropScript = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_jd_simple_zer";