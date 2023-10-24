<?php
/*
 @CMS flusity
 Author Darius Jakaitis, author web site https://www.flusity.com
*/

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'core/functions/functions.php';

list($db, $config, $prefix) = initializeSystem();
secureSession($db, $prefix);
$settings = getSettings($db, $prefix);
$lang_code = $settings['language']; // Kalbos kodas
$bilingualism = $settings['bilingualism'];

if (isset($_GET['lang']) && in_array($_GET['lang'], [$lang_code, 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$current_lang = $_SESSION['lang'] ?? $lang_code; 
if (isset($_GET['lang'])) {
    $selectedLang = $_GET['lang'];
    
    $_SESSION['lang'] = $selectedLang;
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
}

$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $prefix, $user_id);
}

$themeName = $settings['theme'];

$limit = $settings['posts_per_page'];

$url = isset($_GET['url']) ? intval($_GET['url']) : 1;
$offset = ($url - 1) * $limit;

$current_page_url = getCurrentPageUrl($db, $prefix);

$posts = getPostsNews($db, $prefix, $limit, $offset, $current_page_url, $current_lang);
  
$postSeo = getPostSeo($db, $prefix, $limit, $offset, $current_page_url);

$titleField = ($current_lang === $lang_code) ? 'title' : 'lang_post_title';
$contentField = ($current_lang === $lang_code) ? 'content' : 'lang_post_content';
$nameField = ($current_lang === $lang_code) ? 'name' : 'lang_custom_name';
$htmlCodeField = ($current_lang === $lang_code) ? 'html_code' : 'lang_custom_content';


foreach ($posts as &$post) {
    if (empty($post[$titleField])) {
        $post['title'] = htmlspecialchars_decode($post['title']);
    } else {
        $post['title'] = htmlspecialchars_decode($post[$titleField]);
    }
    
    if (empty($post[$contentField])) {
        $post['content'] = htmlspecialchars_decode($post['content']);
    } else {
        $post['content'] = htmlspecialchars_decode($post[$contentField]);
    }
}



$total_posts = countPosts($db, $prefix);
$total_urls = ceil($total_posts / $limit);

$menu = getMenuByPageUrl($db, $prefix, $current_page_url);
$menu_id = $menu['id'];

$templateName = $menu['template'];

require_once "join.php";
includeThemeTemplate($themeName, 'header', $db, $prefix);
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    echo '<link rel="stylesheet" href="/core/tools/css/edit.css">';
}
includeThemeTemplate($themeName, $templateName, $db, $prefix); 

includeThemeTemplate($themeName, 'footer', $db, $prefix);

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    echo '<script src="/core/template/js/editable.js"></script>
    <script src="/core/template/js/edit.js"></script>';
}
?>

</body>
</html>
