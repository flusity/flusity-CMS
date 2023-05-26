<?php   
  $language_code = getLanguageSetting($db);
    $translations = getTranslations($db, $language_code);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top-navbar">
    <a class="navbar-brand ml-5" href="/"><?php require_once $_SERVER['DOCUMENT_ROOT'].'/assets/logo-50.php';?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav ml-5 mt-2">
            <li class="nav-item active">
              <?php $settings = getSettings($db); // Funkcija, kuri gauna nustatymus iš duomenų bazės
                ?>
                <a class="nav-link" href="<?php echo $settings['pretty_url'] == 1 ? "/" : "../../?page"; ?>"><?php echo t("Front page"); ?></a>
            </li>
            <?php if (isset($_SESSION['user_id'])): 
                $isAdmin = checkUserRole($user_id, 'admin', $db);
                $isModerator = checkUserRole($user_id, 'moderator', $db);
                $isUser = checkUserRole($user_id, 'user', $db);
            ?>
        <?php if ($isAdmin || $isModerator): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo getFullUrl('/admin.php'); ?>"><?php echo t("Admin"); ?></a>
            </li>
        <?php endif; ?>
    </ul>
    <ul class="navbar-nav mt-2">
        <li class="nav-item">
            <?php if ($isUser): ?>
                <p style=" margin: 10px 0px -3px 0px;"><?php echo t("Hello")." "; ?>, <?php echo htmlspecialchars($user_name); ?>!</p>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link mt-1" href="<?php  $_SERVER['HTTP_HOST']?>/logout.php"><?php echo t("Log out"); ?></a>
        </li>
        <?php else: ?>
            <li class="nav-item">
            <a class="nav-link" href="login.php"><?php echo t("Log In"); ?></a>
        </li>
        <li class="nav-item">
            <p class="mt-2">or</p>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="register.php"><?php echo t("Sign up"); ?></a>
        </li>
        <?php endif; ?>
        </ul>
</div>
</nav>
