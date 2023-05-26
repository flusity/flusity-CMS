<?php 
    require_once 'security/config.php';
    require_once 'core/functions/functions.php';
    secureSession();
    // Duomenų gavimas iš duomenų bazės
    $db = getDBConnection($config);
    // Gaunamas kalbos nustatymas iš duomenų bazės  
    $language_code = getLanguageSetting($db);
    $translations = getTranslations($db, $language_code);

        ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand ml-5" href="http://localhost/"><?php require_once 'assets/logo-50.php'?></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      
    <ul class="navbar-nav ml-5 mt-2">
    <?php
        $menuItems = getMenuItems($db);
        $current_page_url = getCurrentPageUrl($db);

    foreach ($menuItems as $item):
        $active = $current_page_url === $item['page_url'] ? 'active' : '';
        $generatedUrl = generateMenuUrl($db, $item['page_url']);
?>
    <li class="nav-item">
        <a class="nav-link <?php echo $active; ?>" href="<?php echo $generatedUrl; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
    </li>
<?php endforeach; ?>
<li class="nav-item">
<?php if (isset($_SESSION['user_id'])): 
    $isAdmin = checkUserRole($user_id, 'admin', $db);
    $isModerator = checkUserRole($user_id, 'moderator', $db);
    $isUser = checkUserRole($user_id, 'user', $db);
?>
    <?php if ($isAdmin || $isModerator): ?>
        <a class="nav-link" href="admin.php">Admin</a>
    <?php endif; ?>
        </li>
    </ul>
    <ul class="navbar-nav mt-2">
    <li class="nav-item">
    <?php if ($isUser): ?>
     <p style=" margin: 10px 0px -3px 0px;"><?php echo t("Hello")." "; ?>, <?php echo htmlspecialchars($user_name); ?>!</p>
</li>
<?php endif; ?>
<li class="nav-item">
<a class="nav-link mt-1" href="logout.php"><?php echo t("Sign out"); ?></a>
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
