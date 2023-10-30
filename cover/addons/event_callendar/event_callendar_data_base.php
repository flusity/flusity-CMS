<?php

$createTable1 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_event_callendar (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    callendar_name TEXT DEFAULT NULL,
    work_dayStart  TIME DEFAULT NULL,
    work_dayEnd  TIME DEFAULT NULL,
    lunch_breakStart  TIME DEFAULT NULL,
    lunch_breakEnd  TIME DEFAULT NULL,
    prepare_time INT(11) DEFAULT NULL,
    registration_end_date INT(11) DEFAULT NULL,
    menu_id INT(11) DEFAULT NULL,
    place_id INT(11) DEFAULT NULL,
    addon_id INT(11) DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$createTable2 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_event_callendar_item (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    laboratories_id INT(11) DEFAULT NULL,
    title TEXT NOT NULL,
    short_description TEXT DEFAULT NULL,
    methodical_material TEXT DEFAULT NULL,
    time_limit INT(11) DEFAULT NULL,
    target_audience TEXT DEFAULT NULL,
    metodic_file_id INT(11) DEFAULT NULL,
    image_id INT(11) DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


$createTable3 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_event_callendar_laboratories (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    callendar_id INT(11) DEFAULT NULL,
    event_name TEXT DEFAULT NULL,
    managers VARCHAR(255) DEFAULT NULL,
    when_event_will_start DATE DEFAULT NULL,
    event_days TEXT NOT NULL,
    event_color TEXT DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$createTable4 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_event_callendar_holidays (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    month INT(11) DEFAULT NULL,
    holiday INT(11) DEFAULT NULL,
    holiday_name TEXT DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$createTable5 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_event_reservation_time (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_laboratory_id INT(11) DEFAULT NULL,
    event_item_id INT(11) DEFAULT NULL,
    event_target_audience TEXT DEFAULT NULL,
    reserve_event_time TIME DEFAULT NULL,
    reserve_date date DEFAULT NULL,
    reservation_description TEXT DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$createTable6 = "CREATE TABLE IF NOT EXISTS {$prefix['table_prefix']}_callendar_users_member (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    member_login_name TEXT NOT NULL,
    member_first_name TEXT NOT NULL,
    member_last_name TEXT NOT NULL,
    member_telephone TEXT NOT NULL,
    member_email TEXT NOT NULL,
    member_email_ok INT(11) DEFAULT NULL,
    member_institution TEXT DEFAULT NULL,
    member_address_institution TEXT DEFAULT NULL,
    member_invoice TEXT DEFAULT NULL,
    member_employee_position TEXT DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

$dropTable1 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_event_callendar"; 
$dropTable2 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_event_callendar_item";
$dropTable3 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_event_callendar_laboratories";
$dropTable4 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_event_callendar_holidays";
$dropTable5 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_event_reservation_time";
$dropTable6 = "DROP TABLE IF EXISTS {$prefix['table_prefix']}_callendar_users_member";


$databaseDropScripts = [$dropTable1, $dropTable2, $dropTable3, $dropTable4, $dropTable5, $dropTable6];

foreach ($databaseDropScripts as $databaseDropScript) {
    $stmt = $db->prepare($databaseDropScript);
    $stmt->execute();
    if ($stmt->execute() === false) {
        error_log("Klaida vykdant SQL užklausą: " . $stmt->errorInfo()[2]);
    }
}


$databaseScripts = [$createTable1, $createTable2, $createTable3, $createTable4, $createTable5, $createTable6];

foreach ($databaseScripts as $databaseScript) {
    $stmt = $db->prepare($databaseScript);
    $stmt->execute();
    if ($stmt->execute() === false) {
        error_log("Klaida vykdant SQL užklausą: " . $stmt->errorInfo()[2]);
    }
}