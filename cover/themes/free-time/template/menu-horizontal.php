<?php 
$current_lang = $_SESSION['lang'] ?? $settings['language'];
$menuItems = getParentMenuItems($db, $prefix);
$current_page_url = getCurrentPageUrl($db, $prefix);

$isUserLoggedIn = isset($_SESSION['user_id']);
if($isUserLoggedIn){
    $isAdmin = checkUserRole($_SESSION['user_id'], 'admin', $db, $prefix);
    $isModerator = checkUserRole($_SESSION['user_id'], 'moderator', $db, $prefix);
    $isUser = checkUserRole($_SESSION['user_id'], 'user', $db, $prefix);
}
?>
<nav class="navbar navbar-light navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">Brand</a>
        <button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mb-2 mb-lg-0">
<?php foreach ($menuItems as $item): 
     if ($item['show_in_menu'] == 1): 
        $active = $current_page_url === $item['page_url'] ? 'active' : '';
        $generatedUrl = generateMenuUrl($db, $prefix, $item['page_url']);
        $menuName = ($current_lang == 'en' && $item['lang_menu_name'] != "") ? $item['lang_menu_name'] : $item['name'];
?>
            <li class="nav-item">
                <a class="nav-link <?php echo $active; ?>" href="<?php echo $generatedUrl; ?>"><?php echo htmlspecialchars($menuName); ?></a>
            </li>
<?php endif; 
        endforeach; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
<?php if ($isUserLoggedIn): ?>
        <li><?php include 'user_dropdown.php'; ?></li>
<?php else: ?>
            <li><a class="nav-link" href="login.php"><?php echo t("Log In"); ?></a></li>
<?php endif; 
      if($settings['bilingualism'] != 0): ?>
            <li><?php include 'language_selector.php'; ?></li>
<?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php    // For sub menu
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
                    //   }?>