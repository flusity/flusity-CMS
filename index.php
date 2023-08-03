<?php
/*
 @CMS flusity
 Author Darius Jakaitis, author web site http://www.manowebas.lt
*/
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'core/functions/functions.php';

list($db, $config, $prefix) = initializeSystem();
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

//$db = getDBConnection($config);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $prefix, $user_id);
}

$settings = getSettings($db, $prefix);
$themeName = $settings['theme'];

$limit = $settings['posts_per_page'];

$url = isset($_GET['url']) ? intval($_GET['url']) : 1;
$offset = ($url - 1) * $limit;

$current_page_url = getCurrentPageUrl($db, $prefix);
$posts = getPostsNews($db, $prefix, $limit, $offset, $current_page_url);
$postSeo = getPostSeo($db, $prefix, $limit, $offset, $current_page_url);

foreach ($posts as &$post) {
    $post['title'] = htmlspecialchars_decode($post['title']);
    $post['content'] = htmlspecialchars_decode($post['content']);
}
$total_posts = countPosts($db, $prefix);
$total_urls = ceil($total_posts / $limit);

$menu = getMenuByPageUrl($db, $prefix, $current_page_url);
$templateName = $menu['template'];
$templatePath = "cover/themes/{$themeName}/template/{$templateName}.php";

require_once "cover/themes/{$themeName}/template/header.php";
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    echo '<link rel="stylesheet" href="/core/tools/css/edit.css">';
}

if (file_exists($templatePath)) {
    include $templatePath;
} else {
    echo t("Template not found!");
}
require_once "cover/themes/{$themeName}/template/footer.php";

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    echo '<script src="/core/template/js/edit.js"></script>';
}

?> 