

<div class="col-md-2 sidebar-bg sidebar nav flex-column" id="sidebar">
                

  <ul class="list-group list-group-flush">
    <li class="list-group-item"><a class="nav-link admin-link-item" href="<?php echo getFullUrl('/admin.php'); ?>"><i class="fas fa-tachometer-alt"></i><span class="nav-text"><?php echo t("Dashboard");?></span></a></li>
    <li class="list-group-item"><a class="nav-link admin-link-item" href="<?php echo getFullUrl('/core/tools/posts.php'); ?>"><i class="fas fa-newspaper"></i><span class="nav-text"><?php echo t("Posts");?></span></a></li>
    <li class="list-group-item"><a class="nav-link admin-link-item" href="<?php echo getFullUrl('/core/tools/customblock.php'); ?>"><i class="fas fa-shapes"></i><span class="nav-text"><?php echo t("Block");?></span></a></li>
    <li class="list-group-item"><a class="nav-link admin-link-item" href="<?php echo getFullUrl('/core/tools/files.php'); ?>"><i class="fas fa-folder"></i><span class="nav-text"><?php echo t("Files");?></span></a></li>
    <li class="list-group-item" id="settingsDropdown">
      <a class="nav-link admin-link-item-point" style="cursor: pointer;"><i class="fas fa-cog"></i> <span class="nav-text"><?php echo t("Core Settings");?></span></a>
         <div id="settingsSubmenu" style="display: none;">
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/users.php'); ?>"><i class="fas fa-users"></i><span class="nav-text"><?php echo t("Users");?></span></a>
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/menu.php'); ?>"><i class="fas fa-bars"></i><span class="nav-text"><?php echo t("Menu");?></span></a> 
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/language.php'); ?>"><i class="fas fa-language"></i><span class="nav-text"><?php echo t("Language");?></span></a>
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/contact_form.php'); ?>"><i class="fas fa-message"></i><span class="nav-text"><?php echo t("Contact Form");?></span></a>  
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/places.php'); ?>"><i class="fas fa-tags"></i><span class="nav-text"><?php echo t("Layout Places");?></span></a>
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/themes.php'); ?>"><i class="fa-solid fa-brush"></i><span class="nav-text"><?php echo t("Themes");?></span></a>
          <a class="nav-link dropdown-item admin-link-item" href="<?php echo getFullUrl('/core/tools/settings.php'); ?>"><i class="fas fa-cog"></i><span class="nav-text"><?php echo t("Settings");?></span></a>
      
        </div>
    </li>
  </ul>
</div>