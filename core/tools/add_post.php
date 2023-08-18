<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';


 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$result = ['success' => false];

if (isset($_POST['post_title'], $_POST['post_content'], $_POST['lang_post_title'], $_POST['lang_post_content'], $_POST['post_menu'], $_POST['post_status'], $_POST['post_tags'], $_POST['role'], $_POST['post_description'], $_POST['post_keywords'])) { 
    
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $lang_post_title = $_POST['lang_post_title'];
    $lang_post_content = $_POST['lang_post_content'];
    $menuId = (int)$_POST['post_menu'];
    $status = $_POST['post_status'];
    $tags = $_POST['post_tags'];
    $role = $_POST['role'];
    $author = $_SESSION['user_id']; 
    $description = $_POST['post_description'];
    $keywords = $_POST['post_keywords'];
    $priority = isset($_POST['post_priority']) ? (int)$_POST['post_priority'] : 0; 

    $insert = createPost($db, $prefix, $title, $content, $lang_post_title, $lang_post_content, $menuId, $status, $author, $tags, $role, $description, $keywords, $priority);
 
    if ($insert) {
        $_SESSION['success_message'] = t('Record successfully added.');
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = t('Error adding Record. Try again.');
    }
}

echo json_encode($result);
exit;

?>
