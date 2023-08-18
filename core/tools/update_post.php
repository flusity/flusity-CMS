<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';


// Duomenų gavimas iš duomenų bazės
 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$result = ['success' => false];

if (isset($_POST['post_id'], $_POST['post_title'], $_POST['post_content'], $_POST['lang_post_title'], $_POST['lang_post_content'], $_POST['post_menu'], $_POST['post_status'], $_POST['post_tags'], $_POST['role'], $_POST['post_description'], $_POST['post_keywords'])) {
    $postId = (int)$_POST['post_id'];
    $title = htmlspecialchars($_POST['post_title'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($_POST['post_content'], ENT_QUOTES, 'UTF-8');

    $lang_post_title = htmlspecialchars($_POST['lang_post_title'], ENT_QUOTES, 'UTF-8');
    $lang_post_content = htmlspecialchars($_POST['lang_post_content'], ENT_QUOTES, 'UTF-8');
    $menuId = (int)$_POST['post_menu'];
    $priority = isset($_POST['post_priority']) ? (int)$_POST['post_priority'] : 0; // Čia yra pasikeitimas
    $status = $_POST['post_status'];
    $tags = $_POST['post_tags'];
    $role = $_POST['role'];
    $description = htmlspecialchars($_POST['post_description'], ENT_QUOTES, 'UTF-8');
    $keywords = htmlspecialchars($_POST['post_keywords'], ENT_QUOTES, 'UTF-8');
 
    $update = updatePost($db, $prefix, $postId, $title, $content, $lang_post_title, $lang_post_content, $menuId, $status, $tags, $role, $description, $keywords, $priority);
 
    if ($update) {
        $_SESSION['success_message'] = t('The record has been updated successfully.');
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = t("Error updating post. Try again.");
    }
}

echo json_encode($result);
exit;

?>
