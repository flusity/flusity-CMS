
<?php if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
/*
 @ flusity
 Author Darius Jakaitis, author web site http://www.manowebas.lt
*/  
    require_once 'core/functions/functions.php';
    
    list($db, $config, $prefix) = initializeSystem();
    secureSession($db, $prefix);
    $db = getDBConnection($config);
    require_once getThemePath($db, $prefix, '/template/header.php'); 
 
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);

    if (isset($_SESSION['user_id'])) {
       
        header('Location: /myaccount.php');
        exit();
    } 
    $csrf_token = generateCSRFToken();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'];
    if (!validateCSRFToken($csrf_token)) {
        die('Bad CSRF token.');
    }

    $login_nameOrEmail = validateInput($_POST['login_name']);
    $password = validateInput($_POST['password']);

    if ($user = authenticateUser($login_nameOrEmail, $password, $prefix)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        session_regenerate_id(true);
        header('Location: /');
        exit();
    } else {
        $error_message = t('Invalid Login Name/email or password.');
    }
} 
 ?>

 <?php

 require_once getThemePath($db, $prefix, '/template/login_form.php');  
 ?>
