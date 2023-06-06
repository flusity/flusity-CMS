<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';


$db = getDBConnection($config);
secureSession($db);
$itemsPerPage = 16;
$page = $_GET['page'] ?? 0;
$offset = $page * $itemsPerPage;

$query = $db->prepare("SELECT * FROM files LIMIT :offset, :itemsPerPage");
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$query->execute();
$images = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($images);

?>
