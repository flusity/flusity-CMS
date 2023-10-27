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
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $editId = isset($_POST['event_edit_id']) ? intval($_POST['event_edit_id']) : 0;
    $callendar_id = isset($_POST['callendar_id']) ? intval($_POST['callendar_id']) : 0;
    $event_name = isset($_POST['event_name']) ? $_POST['event_name'] : '';
    $when_event_will_start = isset($_POST['when_event_will_start']) ? $_POST['when_event_will_start'] : '';
    $event_days = isset($_POST['event_days']) ? $_POST['event_days'] : '';
    $event_color = isset($_POST['event_color']) ? $_POST['event_color'] : '';
    $new_manager_ids = isset($_POST['new_manager_id']) ? $_POST['new_manager_id'] : [];

    $managers_str = implode(',', $new_manager_ids);

    try {
        if (empty($editId)) {
            $sql = "INSERT INTO " . $prefix['table_prefix'] . "_event_callendar_laboratories (callendar_id, event_name, managers, when_event_will_start, event_days, event_color) VALUES (:callendar_id, :event_name, :managers, :when_event_will_start, :event_days, :event_color)";
        } else {
            $sql = "UPDATE " . $prefix['table_prefix'] . "_event_callendar_laboratories SET callendar_id = :callendar_id, event_name = :event_name, managers = :managers, when_event_will_start = :when_event_will_start, event_days = :event_days, event_color = :event_color WHERE id = :id";
        }

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':callendar_id', $callendar_id, PDO::PARAM_INT);
        $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
        $stmt->bindParam(':managers', $managers_str, PDO::PARAM_STR);
        $stmt->bindParam(':when_event_will_start', $when_event_will_start, PDO::PARAM_STR);
        $stmt->bindParam(':event_days', $event_days, PDO::PARAM_STR);
        $stmt->bindParam(':event_color', $event_color, PDO::PARAM_STR);
        
        if (!empty($editId)) {
            $stmt->bindParam(':id', $editId, PDO::PARAM_INT);
        }

        $stmt->execute();

        if (empty($editId)) {
            $_SESSION['success_message'] = t("The event and managers have been successfully added.");
        } else {
            $_SESSION['success_message'] = t("The event and managers have been successfully updated.");
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id='.$id.'');
    exit();
}
?>
