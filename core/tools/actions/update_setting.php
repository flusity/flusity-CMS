<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
$configurations = require $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

$config = $configurations['config'];
$prefix = $configurations['prefix'];

 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$result = ['error_message' => false];
$updateResult = ['error_message' => false];

if (isset($_POST['site_title'], $_POST['meta_description'], $_POST['footer_text'], $_POST['pretty_url'], $_POST['bilingualism'], $_POST['language'],
 $_POST['posts_per_page'], $_POST['registration_enabled'], $_POST['session_lifetime'], $_POST['default_keywords'])) { 

    $allowed_file_types = ['image/png', 'image/jpeg', 'image/gif'];
    $target_dir = ROOT_PATH. "/uploads/";
    $max_file_size = 100 * 1024; // Maximum file size (100KB)
    $brand_icone = null; // Initialize this variable before if condition

    if (isset($_FILES["brand_icone"]) && $_FILES["brand_icone"]["size"] > 0) {
        $uploaded_file = $_FILES["brand_icone"];
        $unique_code = bin2hex(random_bytes(8));
        $filename_parts = pathinfo($uploaded_file["name"]);
        $new_filename = $filename_parts['filename'] . '_' . $unique_code . '.' . $filename_parts['extension'];
        $target_file = $target_dir . basename($new_filename);
        $brand_icone = $new_filename; // Use the new filename
  
        if (!in_array($uploaded_file['type'], $allowed_file_types)) {
            $_SESSION['error_message'] = t("Invalid file type.");
           
        } 

        if ($uploaded_file['size'] > $max_file_size) {
            $_SESSION['error_message'] = t("File size exceeded limit.");
           
        } 

        if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {
            $file_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $new_filename;
            saveFileToDatabase($db, $prefix, $new_filename, $file_url);
            $_SESSION['success_message'] = "File" ." ". basename($uploaded_file["name"]) . " " .t("file uploaded successfully.");
        } else {
            $_SESSION['error_message'] = t("Error loading file.");
         
        }
    } elseif (isset($_POST['brand_icone_id']) && !empty($_POST['brand_icone_id'])) {
        // Fetch the file using its id
        $file = getFileById($db, $prefix, $_POST['brand_icone_id']);
        $brand_icone = $file['name'];
    }

    $site_title = $_POST['site_title'];
    $meta_description = $_POST['meta_description'];
    $footer_text_settings = $_POST['footer_text'];
    $pretty_url = $_POST['pretty_url']; 
    $bilingualism = $_POST['bilingualism'];
    //$pretty_url = isset($_POST['pretty_url']) ? 1 : 0;
    $registration_enabled = $_POST['registration_enabled'];
   // $registration_enabled = isset($_POST['registration_enabled']) ? 1 : 0;

    $language = $_POST['language']; 
    $posts_per_page = $_POST['posts_per_page'];
  
    $session_lifetime = $_POST['session_lifetime'];
    $default_keywords = $_POST['default_keywords'];
    $session_life =  $session_lifetime;

    $updateResult = updateSettings($db, $prefix, $site_title, $meta_description, $footer_text_settings, $pretty_url, $bilingualism, $language, $posts_per_page, $registration_enabled, $session_life, $default_keywords, $brand_icone); 

    if ($updateResult) {
        $_SESSION['success_message'] =  t('Settings successfully updated.');
   
    } else {
        $_SESSION['error_message'] = t('Error updating settings. Try again.');
    
    }
 }

echo json_encode($updateResult); 

?>