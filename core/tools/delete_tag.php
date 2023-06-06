<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';


$db = getDBConnection($config);
secureSession($db);
if (isset($_POST['tag'])) {
    deleteTagFromAllPosts($db, $_POST['tag']);
}
?>