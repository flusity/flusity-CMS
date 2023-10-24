<?php 
 if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }
/*
 @MiniFrame css karkasas Lic GNU
 Author Darius Jakaitis, author web site https://www.flusity.com
 fix-content
*/
    require_once 'core/functions/functions.php';

   
    list($db, $config, $prefix) = initializeSystem();
    secureSession($db, $prefix);
    $settings = getSettings($db, $prefix);

    $lang_code = $settings['language']; // Kalbos kodas
    $bilingualism = $settings['bilingualism'];

    require_once "join.php";
    require_once getThemePath($db, $prefix, '/template/header.php'); 
 
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);

    if (isset($_SESSION['user_id'])) {
        header('Location: /');
        exit();
    }

    $registration_enable = isset($settings['registration_enabled']) ? $settings['registration_enabled'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $error_message = handleRegister($db, $prefix, $_POST);
    }
?>

<?php  require_once getThemePath($db, $prefix, '/template/register_form.php'); ?>

<?php  require_once getThemePath($db, $prefix, '/template/footer.php'); ?>