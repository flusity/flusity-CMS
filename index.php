<?php session_start();
require_once 'security/config.php';
require_once 'core/functions/functions.php';
require_once 'get_customblock.php';
secureSession();
$db = getDBConnection($config);

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
<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
        <?php require_once 'template/menu-horizontal.php';?>
        </div>
    </div>
</div>   
    
<?php 
if (file_exists($templatePath)) {
    include $templatePath;
} else {
    echo "Šablonas nerastas!";
}
?>

<?php require_once 'template/footer.php';?>
