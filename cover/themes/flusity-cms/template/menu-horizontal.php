<nav class="navbar navbar-expand-lg fixed-top bg-light" id="mainNav">
  <div class="container">
    <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a href="/"  class="navbar-brand"><img src="/core/tools/img/flusity-b.png" alt="Flusity logo"></a>
        <a class="navbar-brand brand" href="/"><?php echo $settings['site_title']; ?></a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">
<ul class="navbar-nav mb-2 mb-lg-0">
            <?php
        $menuItems = getMenuItems($db, $prefix);
        $current_page_url = getCurrentPageUrl($db, $prefix);

    foreach ($menuItems as $item):
        if ($item['show_in_menu'] == 1){
        $active = $current_page_url === $item['page_url'] ? 'active' : '';
        $generatedUrl = generateMenuUrl($db, $prefix, $item['page_url']);?>
    <li class="nav-item">
    <a class="nav-link <?php echo $active; ?>" href="<?php echo $generatedUrl; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
    </li>
    <?php }
       endforeach; ?>
    <?php if (isset($_SESSION['user_id'])): 
        $isAdmin = checkUserRole($_SESSION['user_id'], 'admin', $db, $prefix);
        $isModerator = checkUserRole($_SESSION['user_id'], 'moderator', $db, $prefix);
        $isUser = checkUserRole($_SESSION['user_id'], 'user', $db, $prefix);
    ?>

    <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle rounded-pill navmenubutton" style="width: auto;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    <div class="user-profile">
        <?php echo htmlspecialchars(getUserNameById($db, $prefix, $_SESSION['user_id'])); ?>
        <div class="profile-picture-container">
            <img src="/assets/img/user-profile.png" alt="Profile Picture" class="profile-picture">
        </div>
    </div>
</button>


      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if ($isAdmin): ?>
            <a class="dropdown-item" href="admin.php"><?php echo t("Dashboard"); ?></a>
        <?php endif; ?>
        <a class="dropdown-item" href="myaccount.php"><?php echo t("Profile"); ?></a>
        <a class="dropdown-item" href="logout.php"><?php echo t("Sign out"); ?></a>
      </div>
    </div>
<?php else: ?>
   <!--  <li class="nav-item">
    <a class="nav-link" href="login.php"><?php //echo t("Log In"); ?></a>
</li> -->
<?php endif; ?>
</div></ul>
            </div>
          </div>
        </nav>    