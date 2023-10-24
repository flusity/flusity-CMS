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
    $addon_post_edit_id = intval($_POST['addon_post_edit_id']);
    $mode = $_POST['mode'];

  // Extract array data from POST request
$profileNames = $_POST["profiles_name"];
$profileUrls = array_map(function($input) { return htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); }, $_POST["social_profiles_link_url"]);
$profileIcons = array_map(function($input) { return htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); }, $_POST["fa_icone_code"]);


    // Convert arrays to comma-separated strings
    $profileNamesStr = implode(',', $profileNames);
    $profileUrlsStr = implode(',', $profileUrls);
    $profileIconsStr = implode(',', $profileIcons);

    try {
        $sql = ($mode === 'edit') ? 
            "UPDATE " . $prefix['table_prefix'] . "_social_block_links SET profiles_name = :profiles_name, fa_icone_code = :fa_icon_code, social_profiles_link_url = :social_profiles_link_url, menu_id = :menu_id, place_id = :place_id WHERE id = :addon_id" : 
            "INSERT INTO " . $prefix['table_prefix'] . "_social_block_links (profiles_name, fa_icone_code, social_profiles_link_url, menu_id, place_id) VALUES (:profiles_name, :fa_icon_code, :social_profiles_link_url, :menu_id, :place_id)";
        
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':profiles_name', $profileNamesStr, PDO::PARAM_STR);
        $stmt->bindParam(':fa_icon_code', $profileIconsStr, PDO::PARAM_STR);
        $stmt->bindParam(':social_profiles_link_url', $profileUrlsStr, PDO::PARAM_STR);
        $stmt->bindParam(':menu_id', $_POST['addon_menu_id'], PDO::PARAM_INT);
        $stmt->bindParam(':place_id', $_POST['addon_place_id'], PDO::PARAM_INT);
        
        if ($mode === 'edit') {
            $stmt->bindParam(':addon_id', $addon_post_edit_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        $_SESSION['success_message'] = ($mode === 'edit') ? t("Editing the plugin was successful.") : t("Adding the plugin was successful.");
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=social_block_links&id=' . $id);
    exit();
}
?>
