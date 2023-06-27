<?php
  require_once 'core/functions/functions.php';
  $baseUrl = getBaseUrl();
  list($db, $config, $prefix) = initializeSystem();
  secureSession($db, $prefix);
  $language_code = getLanguageSetting($db, $prefix);
  $translations = getTranslations($db, $prefix, $language_code);
  
  $db = getDBConnection($config);
  
   require_once getThemePath($db, $prefix, '/template/header.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
} else {
    if (!checkUserRole($_SESSION['user_id'], 'user', $db, $prefix) && !checkUserRole($_SESSION['user_id'], 'admin', $db, $prefix) && !checkUserRole($_SESSION['user_id'], 'moderator', $db, $prefix)) {
        header('Location: index.php');
        exit();
    }
}

?>

<header id="header">
<?php require_once getThemePath($db, $prefix, '/template/menu-horizontal.php'); ?>
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
<?php require_once getThemePath($db, $prefix, '/template/footer.php'); ?>