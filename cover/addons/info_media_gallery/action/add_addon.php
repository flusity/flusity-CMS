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
    $id = intval($_POST['id']); 
    $gallery_name = $_POST['gallery_name'];
    $gallery_css_style_settings = $_POST['gallery_css_style_settings'];
    $place_id = $_POST['addon_place_id'];
    $menu_id = $_POST['addon_menu_id'];
    $addon_id = $id;

    try {
        $sql_gallery = "INSERT INTO " . $prefix['table_prefix'] . "_info_media_gallery (gallery_name, gallery_css_style_settings, menu_id, place_id, addon_id) VALUES (:gallery_name, :gallery_css_style_settings, :menu_id, :place_id, :addon_id)";
        $stmt_gallery = $db->prepare($sql_gallery);

        $stmt_gallery->bindParam(':gallery_name', $gallery_name, PDO::PARAM_STR);
        $stmt_gallery->bindParam(':gallery_css_style_settings', $gallery_css_style_settings, PDO::PARAM_STR);
        $stmt_gallery->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmt_gallery->bindParam(':place_id', $place_id, PDO::PARAM_INT);
        $stmt_gallery->bindParam(':addon_id', $addon_id, PDO::PARAM_INT);

        if ($stmt_gallery->execute()) {
            $id_info_media_gallery = $db->lastInsertId(); // get the last inserted id
        }

        // Loop through arrays and insert into DB
        for ($i = 0; $i < count($_POST['media_title']); $i++) {
            $title = $_POST['media_title'][$i];
            $media_description = $_POST['media_desc'][$i];
            $hyperlink = $_POST['media_url'][$i];
            $media_file_id = $_POST['image_id'][$i];

            //$sql = "INSERT INTO " . $prefix['table_prefix'] . "_info_media_gallery_item (title, media_description, hyperlink, media_file_id, id_info_media_gallery) VALUES (:title, :media_description, :hyperlink, :media_file_id, :id_info_media_gallery)";
              $sql = "INSERT INTO " . $prefix['table_prefix'] . "_info_media_gallery_item (title, media_description, lang_en_title, lang_en_media_description, hyperlink, media_file_id, id_info_media_gallery) VALUES (:title, :media_description, :lang_en_title, :lang_en_media_description, :hyperlink, :media_file_id, :id_info_media_gallery)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':media_description', $media_description, PDO::PARAM_STR);
            $stmt->bindParam(':lang_en_title', $_POST['lang_en_title'][$i], PDO::PARAM_STR); 
            $stmt->bindParam(':lang_en_media_description', $_POST['lang_en_media_description'][$i], PDO::PARAM_STR); 
            $stmt->bindParam(':hyperlink', $hyperlink, PDO::PARAM_STR);
            $stmt->bindParam(':media_file_id', $media_file_id, PDO::PARAM_INT);
            $stmt->bindParam(':id_info_media_gallery', $id_info_media_gallery, PDO::PARAM_INT);


            if (!$stmt->execute()) {
                $_SESSION['error_message'] = t("Error while executing the query.");
            }
        }

        $_SESSION['success_message'] = t("Adding the plugin was successful.");

    } catch (PDOException $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=info_media_gallery&id=' . $id);
    exit();
}
?>
