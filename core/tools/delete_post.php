<?php
    session_start();
    define('IS_ADMIN', true);

    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    secureSession();
    // Duomenų gavimas iš duomenų bazės
    $db = getDBConnection($config);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_post' && isset($_POST['post_id'])) {

        $postId = intval($_POST['post_id']);
        $result = deletePost($db, $postId);

        if ($result) {
            $_SESSION['success_message'] = 'Puslapis sėkmingai ištrintas.';
        } else {
            $_SESSION['error_message'] = 'Klaida trinant puslapį. Bandykite dar kartą.';
        }
    }

    header("Location: posts.php");
    exit;
?>
