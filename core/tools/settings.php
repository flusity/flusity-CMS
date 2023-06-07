<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $site_title = $_POST['site_title'];
    $meta_description = $_POST['meta_description'];
    $footer_text_settings = $_POST['footer_text'];
    $pretty_url = $_POST['pretty_url'];
    $language = $_POST['language']; 
    $posts_per_page = $_POST['posts_per_page'];
    $registration_enabled = isset($_POST['registration_enabled']) ? 1 : 0;
    $session_lifetime = $_POST['session_lifetime'];
    $default_keywords = $_POST['default_keywords'];

    updateSettings($db, $site_title, $meta_description, $footer_text_settings, $pretty_url, $language, $posts_per_page, $registration_enabled, $session_lifetime, $default_keywords); 

    $_SESSION['success_message'] =  t("Settings successfully updated!");
    header("Location: settings.php");
    exit;
}
?>
<?php define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

        
            <div class="col-sm-9">
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
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h2><?php echo t("Settings");?></h2>
                    <ul class="nav nav-tabs">
                        <li class="nav-item tabs-nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#settings"><?php echo t("Website Settings");?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#backup"><?php echo t("Database Backup");?></a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#tags"><?php echo t("Edit Tag's");?></a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#cache"><?php echo t("Cache");?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="settings">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6"> <!-- Left column -->
                                    <div class="form-group">
                                        <label for="site_title"><b><?php echo t("Website Name");?></b></label>
                                        <input type="text" class="form-control" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required>
                                    </div>
                                    <div class="form-group">  
                                        <label for="meta_description"><b><?php echo t("META description");?></b></label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required><?php echo htmlspecialchars($settings['meta_description']); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="default_keywords"><b><?php echo t("META Default keywords");?></b></label>
                                        <textarea class="form-control" id="default_keywords" name="default_keywords" rows="2" required><?php echo htmlspecialchars($settings['default_keywords']); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="footer_text"><b><?php echo t("Footer text");?></b></label>
                                        <textarea class="form-control" id="footer_text" name="footer_text" rows="3" required><?php echo htmlspecialchars($settings['footer_text']); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group mt-2">
                                        <label for="pretty_url"><?php echo t("Pretty URL");?></label>
                                        <input type="checkbox" class="form-control-ch" id="pretty_url" name="pretty_url" value="1" <?php echo ($settings['pretty_url'] == 1 ? 'checked' : '');?>>
                                    </div>
                                    <div class="form-group">
                                        <label for="posts_per_page"><?php echo t("Posts per page");?></label>
                                        <input type="number" class="form-control w-25" id="posts_per_page" name="posts_per_page" value="<?php echo htmlspecialchars($settings['posts_per_page']); ?>" required>
                                    </div>
                                    <div class="form-group mt-2 mb-2">
                                        <label for="language"><?php echo t("Language");?></label>
                                        <select class="form-control-slc" id="language" name="language">
                                            <?php 
                                                $containsEn = array_search('en', array_column($languages, 'language_code')) !== false;
                                                if (!$containsEn) {
                                                    $languages[] = ['language_code' => 'en'];
                                                }
                                                foreach ($languages as $lang) : ?>
                                                <option value="<?php echo htmlspecialchars($lang['language_code']); ?>" <?php echo ($settings['language'] === $lang['language_code'] ? 'selected' : ''); ?>>
                                                    <?php echo htmlspecialchars($lang['language_code']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2 mb-2">
                                        <label for="session_lifetime"><?php echo t("Session lifetime");?></label>
                                        <input type="text" class="form-control  w-25" id="session_lifetime" name="session_lifetime" value="<?php echo htmlspecialchars($settings['session_lifetime']); ?>" required>
                                    </div>
                                    <div class="form-group mt-2 mb-2">
                                    <label for="registration_enabled"><?php echo t("Registration Enabled");?></label>
                                    <input type="checkbox" class="form-control-ch" id="registration_enabled" name="registration_enabled" value="1" <?php echo ($settings['registration_enabled'] == 1 ? 'checked' : '');?>>
                                </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo t("Update Settings");?></button>
                        </form>
                    </div>
                        <div class="tab-pane fade" id="backup">
                            <form action="create_backup.php" method="post">
                                <input type="submit" name="create_backup" value="<?php echo t("Create a backup");?>" class="btn btn-success mt-2">
                            </form>
                        <?php 
                            $backupDirectory = ROOT_PATH . 'core/tools/backups/';
                            $backupFiles = getBackupFilesList($backupDirectory);
                            echo "<h3>".t('List of backups')."</h3>";
                            if (count($backupFiles) > 0) {
                                $i=1;
                                foreach ($backupFiles as $file) {
                                    echo "<p>" .$i++.". <a href='download_backup.php?file=" . urlencode($file) . "'>" . htmlspecialchars($file) . "</a> <a href='delete_backup.php?file=" . urlencode($file) . "' onclick=\"return confirm('Are you sure you want to delete this file?')\">[Ištrinti]</a></p>";
                                }
                            } else {
                                     echo '<p>'. t("No backups").'</p>';
                            }?>
                        </div>
                        <div class="tab-pane fade" id="tags">
                        <h3><?php echo t("Edit your Tags");?></h3>
                        <?php $existingTags = getExistingTags($db); ?>
                        <?php if (!empty($existingTags)): ?>
                            <?php foreach ($existingTags as $tag): ?>
                                <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($tag); ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p><?php echo t("No tags have been created");?></p>
                        <?php endif; ?>
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast-notification">
                            <div class="toast-header">
                                <strong class="me-auto"><?php echo t("Notification");?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <?php echo t("Tag has been deleted successfully.");?>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="cache">
                            <form action="clear_cache.php" method="post">
                                <input type="submit" name="clear_cache" value="<?php echo t("Clear Cache");?>" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                        </main>
    </div>
</div>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>