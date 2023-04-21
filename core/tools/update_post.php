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

if (isset($_POST['post_id'], $_POST['post_title'], $_POST['post_content'], $_POST['post_menu'], $_POST['post_status'], $_POST['post_tags'], $_POST['role'])) {
    $postId = (int)$_POST['post_id'];
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $menuId = (int)$_POST['post_menu'];
    $status = $_POST['post_status'];
    $tags = $_POST['post_tags'];
    $role = $_POST['role'];

    $update = updatePost($db, $postId, $title, $content, $menuId, $status, $tags, $role);

    if ($update) {
        $_SESSION['success_message'] = 'Puslapis sėkmingai atnaujintas.';
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = 'Klaida atnaujinant puslapį. Bandykite dar kartą.';
    }
}

echo json_encode($result);
exit;
?>
