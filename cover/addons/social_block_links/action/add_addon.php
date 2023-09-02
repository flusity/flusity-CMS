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

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{ 
    $id = intval($_POST['id']); 

    // Extract array data from POST request
    $profileNames = [];
    $profileUrls = [];
    $profileIcons = [];

    for ($i = 1; isset($_POST["profiles_name_$i"]); $i++) {
        $profileNames[] = $_POST["profiles_name_$i"];
        $profileUrls[] = $_POST["social_profiles_link_url_$i"];
        $profileIcons[] = $_POST["fa_icone_code_$i"];
    }

    // Convert arrays to comma-separated strings
    $profileNamesStr = implode(',', $profileNames);
    $profileUrlsStr = implode(',', $profileUrls);
    $profileIconsStr = implode(',', $profileIcons);
    
    try {
        $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_social_block_links (profiles_name, fa_icone_code, social_profiles_link_url, menu_id, place_id, addon_id) VALUES (:profiles_name, :fa_icon_code, :social_profiles_link_url, :menu_id, :place_id, :addon_id)");
        $stmt->bindParam(':profiles_name', $profileNamesStr, PDO::PARAM_STR);
        $stmt->bindParam(':fa_icon_code', $profileIconsStr, PDO::PARAM_STR);
        $stmt->bindParam(':social_profiles_link_url', $profileUrlsStr, PDO::PARAM_STR);
        $stmt->bindParam(':menu_id', $_POST['addon_menu_id'], PDO::PARAM_INT);
        $stmt->bindParam(':place_id', $_POST['addon_place_id'], PDO::PARAM_INT);
        $stmt->bindParam(':addon_id', $id, PDO::PARAM_INT);
    
        $stmt->execute();
        $_SESSION['success_message'] = t("Adding the plugin was successful.");
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=social_block_links&id=' . $id);
    exit();
}
?>
