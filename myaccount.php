<?php
  if (session_status() !== PHP_SESSION_ACTIVE) {
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

   require_once getThemePath($db, $prefix, '/template/header.php'); 
    $db = getDBConnection($config);

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
<header class="header easy-header">
    <div class="overlay"></div>
    <canvas id="canvas"></canvas>
<?php require_once getThemePath($db, $prefix, 'template/menu-horizontal.php'); ?>
        <div class="col-md-12 easy-hello-box">
            <h1>
              <span class="easy-word">Flusity free CMS for all</span>
          </h1>
        </div>
</header>
<main class="main mt-5" id="main">
<?php
    if (isset($_SESSION['success_message'])) {
        echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
            " . htmlspecialchars($_SESSION['success_message']) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION['success_message']);
    }

    if (isset($_SESSION['error_message'])) {
        echo "<div class='alert alert-danger alert-dismissible fade show slow-fade'>
            " . htmlspecialchars($_SESSION['error_message']) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION['error_message']);
    }
    ?>
  <div class="container">
    <div class="row">
        <div class="col-sm-4">
        <h2><?php echo t("User Area");?></h2>    
</div>
</div>
</main>
<?php require_once getThemePath($db, $prefix, '/template/footer.php'); ?>