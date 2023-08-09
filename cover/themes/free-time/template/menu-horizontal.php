<nav class="navbar navbar-light navbar-expand-lg fixed-top" id="mainNav" style="font-family: Anaheim, sans-serif;">
        <div class="container"><a class="navbar-brand" href="index.html">Brand</a><button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive" style="font-family: Anaheim, sans-serif;font-size: 20px;">
               <ul class="navbar-nav mb-2 mb-lg-0">
<?php
$menuItems = getParentMenuItems($db, $prefix);
$current_page_url = getCurrentPageUrl($db, $prefix);

foreach ($menuItems as $item):
    if ($item['show_in_menu'] == 1){
    $active = $current_page_url === $item['page_url'] ? 'active' : '';
    $generatedUrl = generateMenuUrl($db, $prefix, $item['page_url']);?>
                <li class="nav-item">
                <a class="nav-link <?php echo $active; ?>" href="<?php echo $generatedUrl; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
                
                 <?php
                     //   $subMenuItems = getSubMenuItems($db, $prefix, $item['id']);
                    //    if(count($subMenuItems) > 0) {
                    //      echo '<ul class="submenu">';
                    //      foreach ($subMenuItems as $subItem) {
                    //           $activeSub = $current_page_url === $subItem['page_url'] ? 'active' : '';
                    //          $generatedSubUrl = generateMenuUrl($db, $prefix, $subItem['page_url']);
                    //        echo '<li class="nav-item">';
                    //        echo '<a class="nav-link ' . $activeSub . '" href="' . $generatedSubUrl . '">' . htmlspecialchars($subItem['name']) . '</a>';
                    //        echo '</li>';
                    //     }
                    //      echo '</ul>';
                    //   }
                    ?> 
                </li>
     <?php }
         endforeach;?>     
     </div> 
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
        <?php else: //?>
            <a class="nav-link" href="login.php"><?php echo t("Log In"); ?></a>
        <?php endif; ?>
        </ul>
        </div>
</nav>