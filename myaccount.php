<?php
require_once 'template/header.php';
$db = getDBConnection($config);

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
} else {
    if (!checkUserRole($_SESSION['user_id'], 'user', $db) && !checkUserRole($_SESSION['user_id'], 'admin', $db) && !checkUserRole($_SESSION['user_id'], 'moderator', $db)) {
        header('Location: index.php');
        exit();
    }
}

$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

?>

<header id="header">
<?php require_once 'template/menu-horizontal.php';?>
</header>
<section class="container spacer footer">
    <main class="main my-4">
    <div class="row">
        <div class="col-sm-4">
        <h2><?php echo t("User Area");?></h2>

        
</div>
</div>
</main>
</section>
<?php require_once 'template/footer.php';?>
