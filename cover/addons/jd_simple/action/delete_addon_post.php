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

if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{ 
    $addon_post_id = intval($_GET['addon_post_id']); 

    try {
        // Selecting the addon from the database to get the parent id
        $stmt = $db->prepare("SELECT img_name FROM " . $prefix['table_prefix'] . "_jd_simple WHERE id = :id");
        $stmt->bindParam(':id', $addon_post_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $imgName = $row['img_name'];
            $imgPath = ROOT_PATH . "uploads/jd_simple_img/" . $imgName;

            if (file_exists($imgPath)) {
                // Delete the file
                unlink($imgPath);
            }

            // Deleting the addon from the database
            $stmt = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_jd_simple WHERE id = :id");
            $stmt->bindParam(':id', $addon_post_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['success_message'] = t("The addon has been successfully deleted.");
        } else {
            $_SESSION['error_message'] = t("Addon not found.");
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=jd_simple&id=' . $_GET['id']);
    exit();
}
?>
