<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
$addon_path = $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/';
 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$response = array();

if(isset($_POST['action']) && $_POST['action'] == 'delete_addon'){
    $addonName = $_POST['addonName'];
    
    // Check if the addon exists in the database
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_tjd_addons WHERE name_addon = :name_addon");
    $stmt->bindParam(':name_addon', $addonName);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        // The addon exists in the database, do not delete the folder
        $_SESSION['error_message'] = t("The addon exists in the database, cannot delete the folder");
        $response['success'] = 'false';
    } else {
        // The addon does not exist in the database, delete the folder
        if(deleteDirectory($addon_path . $addonName)){
            $_SESSION['success_message'] = t("Addon successfully deleted.");
            $response['success'] = 'true';
        } else {
            $_SESSION['error_message'] = t("Error deleting addon. Try again.");
            $response['success'] = 'false';
        }
    }
}

echo json_encode($response);
exit;
