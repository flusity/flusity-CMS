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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   /*  echo '<pre>';
      var_dump($_POST);
     print_r($_POST);
    echo '</pre>'; */


    $id = intval($_POST['id']);
    $gallery_name = $_POST['gallery_name'];
    $gallery_css_style_settings = $_POST['gallery_css_style_settings'];
    $place_id = $_POST['addon_place_id'];
    $menu_id = $_POST['addon_menu_id'];
    $addon_post_edit_id = $_POST['addon_post_edit_id'];

    try {
        $db->beginTransaction();

        // Update gallery
        $sql_gallery = "UPDATE " . $prefix['table_prefix'] . "_info_media_gallery SET gallery_name = ?, gallery_css_style_settings = ?, menu_id = ?, place_id = ?, addon_id = ? WHERE id = ?";
        $stmt_gallery = $db->prepare($sql_gallery);

        $stmt_gallery->execute([$gallery_name, $gallery_css_style_settings, $menu_id, $place_id, $id, $addon_post_edit_id]);
        
        
        // Update gallery items
        $sql = "UPDATE " . $prefix['table_prefix'] . "_info_media_gallery_item SET title = ?, media_description = ?, hyperlink = ?, media_file_id = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $sql_insert = "INSERT INTO " . $prefix['table_prefix'] . "_info_media_gallery_item (title, media_description, hyperlink, media_file_id, id_info_media_gallery) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $db->prepare($sql_insert);
        foreach ($_POST['media_title'] as $i => $title) {
            $media_description = $_POST['media_desc'][$i];
            $hyperlink = $_POST['media_url'][$i];
            $image_id = $_POST['image_id'][$i];
            
            if (isset($_POST['item_id'][$i])) {
                $item_id = $_POST['item_id'][$i];
                $stmt->execute([$title, $media_description, $hyperlink, $image_id, $item_id]);
                
            } else {
                $stmt_insert->execute([$title, $media_description, $hyperlink, $image_id, $addon_post_edit_id]);
            }
        }

        $db->commit();
        $_SESSION['success_message'] = t("The addon was updated successfully.");
        
    } catch (PDOException $e) {
        $db->rollBack();
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=info_media_gallery&id=' . $id);
    exit();
}
?>
