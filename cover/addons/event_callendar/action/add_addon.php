<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{ 
    $id = intval($_POST['id']); 

    // Čia yra papildomi laukai
    $callendar_name = $_POST['callendar_name'];
    $work_dayStart = $_POST['work_dayStart'];
    $work_dayEnd = $_POST['work_dayEnd'];
    $lunch_breakStart = $_POST['lunch_breakStart'];
    $lunch_breakEnd = $_POST['lunch_breakEnd'];
    $prepare_time = $_POST['prepare_time'];
    $registration_end_date = $_POST['registration_end_date'];
    $menu_id = intval($_POST['addon_menu_id']);
    $place_id = intval($_POST['addon_place_id']);

    try {
        $sql = "INSERT INTO " .  $prefix['table_prefix'] . "_event_callendar (callendar_name, work_dayStart, work_dayEnd, lunch_breakStart, lunch_breakEnd, prepare_time, registration_end_date, menu_id, place_id, addon_id) VALUES (:callendar_name, :work_dayStart, :work_dayEnd, :lunch_breakStart, :lunch_breakEnd, :prepare_time, :registration_end_date, :menu_id, :place_id, :addon_id)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':callendar_name', $callendar_name, PDO::PARAM_STR);
        $stmt->bindParam(':work_dayStart', $work_dayStart, PDO::PARAM_STR);
        $stmt->bindParam(':work_dayEnd', $work_dayEnd, PDO::PARAM_STR);
        $stmt->bindParam(':lunch_breakStart', $lunch_breakStart, PDO::PARAM_STR);
        $stmt->bindParam(':lunch_breakEnd', $lunch_breakEnd, PDO::PARAM_STR);
        $stmt->bindParam(':prepare_time', $prepare_time, PDO::PARAM_STR);
        $stmt->bindParam(':registration_end_date', $registration_end_date, PDO::PARAM_STR);
        $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmt->bindParam(':place_id', $place_id, PDO::PARAM_INT);
        $stmt->bindParam(':addon_id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = t("Adding the plugin was successful.");
        } else {
            $_SESSION['error_message'] = t("Error while executing the query.");
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id=' . $id);
    exit();
}
?>
