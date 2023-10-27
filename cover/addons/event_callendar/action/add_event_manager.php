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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = intval($_POST['id']);
    $callendar_id = intval($_POST['callendar_id']); 
    $event_name = $_POST['event_name'];
    $when_event_will_start = $_POST['when_event_will_start'];
    $event_days = $_POST['event_days'];
    $event_color = $_POST['event_color'];
    $new_manager_ids = isset($_POST['new_manager_id']) ? $_POST['new_manager_id'] : [];

    $managers_str = implode(',', $new_manager_ids);

    try {
        $sql = "INSERT INTO " . $prefix['table_prefix'] . "_event_callendar_laboratories (callendar_id, event_name, managers, when_event_will_start, event_days, event_color) VALUES (:callendar_id, :event_name, :managers, :when_event_will_start, :event_days, :event_color)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':callendar_id', $callendar_id, PDO::PARAM_INT); 
        $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
        $stmt->bindParam(':managers', $managers_str, PDO::PARAM_STR);
        $stmt->bindParam(':when_event_will_start', $when_event_will_start, PDO::PARAM_STR);
        $stmt->bindParam(':event_days', $event_days, PDO::PARAM_STR);
        $stmt->bindParam(':event_color', $event_color, PDO::PARAM_STR);

        $stmt->execute();

        $_SESSION['success_message'] = t("The event and managers have been successfully added.");
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id='.$id.'');
    exit();
}

?>
