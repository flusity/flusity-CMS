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

$response = [];
//var_dump($_POST['addon_event_id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 { 
    $addon_event_id = intval($_POST['addon_event_id']);


    try {
        $db->beginTransaction();
    
        // Trinamas pagrindinis įrašas
        $stmt1 = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_event_callendar WHERE id = :id");
        $stmt1->bindParam(':id', $addon_event_id, PDO::PARAM_INT);
        $stmt1->execute();
    
        // Trinami visi susiję įrašai iš kitų lentelių
        $stmt2 = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_event_callendar_holidays");
        $stmt3 = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_event_callendar_item");
        $stmt4 = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_event_callendar_laboratories");
        $stmt5 = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_event_reservation_time");
    
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();
        $stmt5->execute();
    
        $db->commit();
    
        $_SESSION['success_message'] = t("The addon and related records have been successfully deleted.");
        $response = [
            'status' => 'success',
            'message' => $_SESSION['success_message']
        ];
        
        echo json_encode($response);
        exit();
    
    } catch (Exception $e) {
        $db->rollback();
        $_SESSION['error_message'] = $e->getMessage();
        
        header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id=' . $_POST['id']);
        exit();
    }
}
?>
