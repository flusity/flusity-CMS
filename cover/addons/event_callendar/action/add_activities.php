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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['laboratories_id']) && !empty($_POST['laboratories_id']) &&
        isset($_POST['title']) && !empty($_POST['title']) &&
        isset($_POST['time_limit']) && !empty($_POST['time_limit']) &&
        isset($_POST['target_audience']) && !empty($_POST['target_audience']) &&
        isset($_POST['short_description']) && !empty($_POST['short_description'])
    ) {
        $id = intval($_POST['id']); 
        $edit_activity_id = intval($_POST['edit_activity_id']); 
        
        $laboratories_id = $_POST['laboratories_id'];
        $title = $_POST['title'];
        $time_limit = $_POST['time_limit'];
        $target_audience = $_POST['target_audience'];
        $short_description = $_POST['short_description'];
        $methodical_material = $_POST['methodical_material'] ?? null;
        $metodic_file_id = $_POST['metodic_file_id'] ?? null;
        $image_id = $_POST['image_id'] ?? null; 
    
        try {
            if ($edit_activity_id>0) {
                $sql = "UPDATE " .  $prefix['table_prefix'] . "_event_callendar_item SET laboratories_id = :laboratories_id, title = :title, time_limit = :time_limit, target_audience = :target_audience, short_description = :short_description, methodical_material = :methodical_material, metodic_file_id = :metodic_file_id, image_id = :image_id WHERE id = :edit_activity_id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':edit_activity_id', $edit_activity_id);
            } else {
                $sql = "INSERT INTO " .  $prefix['table_prefix'] . "_event_callendar_item (laboratories_id, title, time_limit, target_audience, short_description, methodical_material, metodic_file_id, image_id) VALUES (:laboratories_id, :title, :time_limit, :target_audience, :short_description, :methodical_material, :metodic_file_id, :image_id)";
                $stmt = $db->prepare($sql);
            }
    
            $stmt->bindParam(':laboratories_id', $laboratories_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':time_limit', $time_limit);
            $stmt->bindParam(':target_audience', $target_audience);
            $stmt->bindParam(':short_description', $short_description);
            $stmt->bindParam(':methodical_material', $methodical_material);
            $stmt->bindParam(':metodic_file_id', $metodic_file_id);
            $stmt->bindParam(':image_id', $image_id);
        
            if ($stmt->execute()) {
                if ($edit_activity_id > 0) {
                    $_SESSION['success_message'] = t("The activity was successfully updated.");
                } else {
                    $_SESSION['success_message'] = t("The activity was successfully created and added.");
                }
                
                if (!empty($edit_activity_id)) {
                    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id=' . $id.'&edit_activity_id='. $edit_activity_id);
                } else {
                    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id=' . $id);
                }
                exit();
            } else {
                $_SESSION['error_message'] = t("An error occurred while creating the activity.");
            }
            
        
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }
   }
}

?>