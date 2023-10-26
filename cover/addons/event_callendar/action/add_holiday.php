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
    $month = intval($_POST['month']); 
    $holiday = intval($_POST['holiday']);
    $holiday_name = $_POST['holiday_name'];
    $edit_holiday_id = isset($_POST['edit_holiday_id']) ? intval($_POST['edit_holiday_id']) : null;

    try {
        if ($edit_holiday_id > 0) {           $sql = "UPDATE " . $prefix['table_prefix'] . "_event_callendar_holidays SET month = :month, holiday = :holiday, holiday_name = :holiday_name WHERE id = :edit_holiday_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':holiday', $holiday, PDO::PARAM_INT);
            $stmt->bindParam(':holiday_name', $holiday_name, PDO::PARAM_STR);
            $stmt->bindParam(':edit_holiday_id', $edit_holiday_id, PDO::PARAM_INT);
           
        } else {
  $sql = "INSERT INTO " . $prefix['table_prefix'] . "_event_callendar_holidays (month, holiday, holiday_name) VALUES (:month, :holiday, :holiday_name)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':holiday', $holiday, PDO::PARAM_INT);
            $stmt->bindParam(':holiday_name', $holiday_name, PDO::PARAM_STR);
        }

        $stmt->execute();
        
        $_SESSION['success_message'] = ($edit_holiday_id > 0) ? t("Updating the holiday was successful.") : t("Adding the holiday was successful.");
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id='.$id.'');
    exit();
}


?>