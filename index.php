<?php if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
/*
 @MiniFrame css karkasas Lic GNU
 Author Darius Jakaitis, author web site http://www.manowebas.lt
 fix-content
*/
require_once 'security/config.php';
require_once 'core/functions/functions.php';
require_once 'get_customblock.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 
secureSession();
$db = getDBConnection($config);
   // Gaunamas kalbos nustatymas iš duomenų bazės  
    $language_code = getLanguageSetting($db);
    $translations = getTranslations($db, $language_code);
 
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);
}

$limit = 10;
$url = isset($_GET['url']) ? intval($_GET['url']) : 1;
$offset = ($url - 1) * $limit;

$current_page_url = getCurrentPageUrl($db);
$posts = getPostsNews($db, $limit, $offset, $current_page_url);

$total_posts = countPosts($db);
$total_urls = ceil($total_posts / $limit);

$menu = getMenuByPageUrl($db, $current_page_url);

$templateName = $menu['template'];
$templatePath = __DIR__ . "/template/{$templateName}.php";

require_once 'template/header.php'; ?>

    
<?php 
if (file_exists($templatePath)) {
    include $templatePath;
} else {
    echo "Šablonas nerastas!";
}
?>
<?php require_once 'template/footer.php';?>