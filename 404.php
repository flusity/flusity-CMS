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
$settings = getSettings($db);

$limit = $settings['posts_per_page'];

$url = isset($_GET['url']) ? intval($_GET['url']) : 1;
$offset = ($url - 1) * $limit;

$current_page_url = getCurrentPageUrl($db);
$posts = getPostsNews($db, $limit, $offset, $current_page_url);

// Dekodavimas
foreach ($posts as &$post) {
    $post['title'] = htmlspecialchars_decode($post['title']);
    $post['content'] = htmlspecialchars_decode($post['content']);
}
$total_posts = countPosts($db);
$total_urls = ceil($total_posts / $limit);

$menu = getMenuByPageUrl($db, $current_page_url);

$templateName = $menu['template'];
$templatePath = __DIR__ . "/template/{$templateName}.php";

require_once 'template/header.php'; ?>


<header id="header">
<?php require_once 'template/menu-horizontal.php';?>
</header>
<section class="container spacer footer">
    <main class="main my-4">
    <div class="row">
        <div class="col-sm-8 mx-auto text-center">
        <h2><?php echo t("Oops...");?></h2>
        <img src="assets/img/green-llama.png" alt="lama">
        <p><?php echo t("You've wandered off into tropical limbo! Nothing to see here.");?></p>
        <p><?php echo t("Click");?> <a href="/"><?php echo t("here");?></a>, &nbsp;<?php echo t("to return back home.");?></p>
</div>
</div>
</main>
</section>
<?php require_once 'template/footer.php';?>