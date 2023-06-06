<nav class="navbar">   
     <a href="http://localhost/"  class="navbar-brand"><?php require_once 'assets/logo-50.php'?></a>
<div class="navbar-header">
    <button class="navbar-toggle" id="navUp">
              <span class="bar bar1"></span>
              <span class="bar bar2"></span>
              <span class="bar bar3"></span>
            </button>
    <div class="navbar-menu nav-items">
    <?php
        $menuItems = getMenuItems($db);
        $current_page_url = getCurrentPageUrl($db);

    foreach ($menuItems as $item):
        if ($item['show_in_menu'] == 1){
        $active = $current_page_url === $item['page_url'] ? 'active' : '';
        $generatedUrl = generateMenuUrl($db, $item['page_url']);
     ?>
        <a class="nav-item nav-url <?php echo $active; ?>" href="<?php echo $generatedUrl; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
         
    <?php }
       endforeach; ?>
    <?php if (isset($_SESSION['user_id'])): 
        $isAdmin = checkUserRole($_SESSION['user_id'], 'admin', $db);
        $isModerator = checkUserRole($_SESSION['user_id'], 'moderator', $db);
        $isUser = checkUserRole($_SESSION['user_id'], 'user', $db);
    ?>
    <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle rounded-pill navmenubutton" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    <div class="user-profile">
        <?php echo htmlspecialchars(getUserNameById($db, $_SESSION['user_id'])); ?>
        <div class="profile-picture-container">
            <img src="assets/img/user-profile.png" alt="Profile Picture" class="profile-picture">
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
    <a class="nav-item" href="login.php"><?php echo t("Log In"); ?></a>
<?php endif; ?>
</div>
</div>
</nav>
