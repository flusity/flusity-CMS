<?php if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
/*
 @MiniFrame css karkasas Lic GNU
 Author Darius Jakaitis, author web site http://www.manowebas.lt
 fix-content
*/
require_once 'core/functions/functions.php';

list($db, $config, $prefix) = initializeSystem();
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

 $db = getDBConnection($config);
  
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $prefix, $user_id);
}

require_once getThemePath($db, $prefix, '/template/header.php'); ?>

<header id="header">
<?php
require_once getThemePath($db, $prefix, '/template/menu-horizontal.php'); ?>

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

<?php require_once getThemePath($db, $prefix, '/template/footer.php'); ?>