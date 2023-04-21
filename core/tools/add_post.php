<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);

$result = ['success' => false];

if (isset($_POST['post_title'], $_POST['post_content'], $_POST['post_menu'], $_POST['post_status'], $_POST['post_tags'], $_POST['role'])) {
    
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $menuId = (int)$_POST['post_menu'];
    $status = $_POST['post_status'];
    $tags = $_POST['post_tags'];
    $role = $_POST['role'];
    $author = $_SESSION['user_id']; // Čia priskirkite autoriaus ID iš sesijos

    $insert = createPost($db, $title, $content, $menuId, $status, $author, $tags, $role);

    if ($insert) {
        $_SESSION['success_message'] = 'Įrašas sėkmingai pridėtas.';
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = 'Klaida atnaujinant Įrašą. Bandykite dar kartą.';
    }
}

echo json_encode($result);
exit;
?>
