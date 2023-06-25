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

$response = array(); // Initialize the response array

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{ 
    $id = intval($_POST['id']); 

    try {
        $img_url = null;
        $img_name = null;
        $addonFolder ="jd_simple_img"; // Addon default directory

        if (isset($_FILES['file_id']) && $_FILES['file_id']['error'] == 0) {
            $uploaded_file = $_FILES["file_id"];
            $result = uploadFile($uploaded_file, $db, $prefix, $addonFolder);
            $img_url = $result['img_url'];
            $img_name = $result['img_name'];

        } elseif (isset($_POST['brand_icone_id']) && !empty($_POST['brand_icone_id'])) {
            $file = getFileById($db, $prefix, $_POST['brand_icone_id']);
            
            // Copy the existing file to the new directory
            $old_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $file['name'];
            $new_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/".$addonFolder."/" . $file['name'];
            
            if (copy($old_path, $new_path)) {
                $img_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/".$addonFolder."/" . $file['name'];
                $img_name = $file['name'];
            } else {
                throw new Exception(t("Error copying existing file."));
            }
        } else {
           
            throw new Exception(t("No file was uploaded or selected."));
        }

        $title = $_POST['title'];
        $description = $_POST['description'];
        $place_id = $_POST['addon_place_id'];
        $menu_id = $_POST['addon_menu_id'];

        $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_jd_simple (title, description, img_url, img_name, menu_id, place_id) VALUES (:title, :description, :img_url, :img_name, :menu_id, :place_id)");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':img_url', $img_url, PDO::PARAM_STR);
        $stmt->bindParam(':img_name', $img_name, PDO::PARAM_STR);
        $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmt->bindParam(':place_id', $place_id, PDO::PARAM_INT);
    
        $stmt->execute();

        // If the query was successful, set a success message
        $response["message"] = t('Menu item successfully added.');
        $response["success"] = true;

    } catch (Exception $e) {
        // If the query failed, set an error message
        $response["message"] = t('Error adding menu item. Try again.');
        $response["error"] = $e->getMessage();
        $response["success"] = false;
    }

    // Encode the response as JSON and echo it
    echo json_encode($response);
    exit();
}
?>
