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


// Tikriname, ar forma buvo išsiųsta
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['laboratories_id']) && !empty($_POST['laboratories_id']) &&
        isset($_POST['title']) && !empty($_POST['title']) &&
        isset($_POST['time_limit']) && !empty($_POST['time_limit']) &&
        isset($_POST['target_audience']) && !empty($_POST['target_audience']) &&
        isset($_POST['short_description']) && !empty($_POST['short_description'])
    ) {
        $id = intval($_POST['id']); 

        $laboratories_id = $_POST['laboratories_id'];
        $title = $_POST['title'];
        $time_limit = $_POST['time_limit'];
        $target_audience = $_POST['target_audience'];
        $short_description = $_POST['short_description'];
        $methodical_material = $_POST['methodical_material'] ?? null;
        $metodic_file_id = $_POST['metodic_file_id'] ?? null;
        $image_id = $_POST['image_id'] ?? null; 
       
    

        try {
            $sql = "INSERT INTO " .  $prefix['table_prefix'] . "_event_callendar_item (laboratories_id, title, time_limit, target_audience, short_description, methodical_material, metodic_file_id, image_id) VALUES (:laboratories_id, :title, :time_limit, :target_audience, :short_description, :methodical_material, :metodic_file_id, :image_id)";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':laboratories_id', $laboratories_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':time_limit', $time_limit);
            $stmt->bindParam(':target_audience', $target_audience);
            $stmt->bindParam(':short_description', $short_description);
            $stmt->bindParam(':methodical_material', $methodical_material);
            $stmt->bindParam(':metodic_file_id', $metodic_file_id);
            $stmt->bindParam(':image_id', $image_id);

        
            if ($stmt->execute()) {
                $_SESSION['success_message'] = t("Adding the event activity was successful.");
            } else {
                $_SESSION['error_message'] = t("Error adding event activity.");
            }
    
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }
    
        header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id=' . $id);
        exit();
   }
}

?>