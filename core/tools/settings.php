<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');


require_once ROOT_PATH . 'core/template/header-admin.php';

$languages = getAllLanguages($db);
$settings = getSettings($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $site_title = $_POST['site_title'];
    $meta_description = $_POST['meta_description'];
    $footer_text = $_POST['footer_text'];
    $pretty_url = $_POST['pretty_url'];
    $language = $_POST['language']; // Čia pridėta naują 'language' formos laukelio vertę
    updateSettings($db, $site_title, $meta_description, $footer_text, $pretty_url, $language);
  
    $_SESSION['success_message'] =  t("Settings successfully updated!");
    header("Location: settings.php");
    exit;
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php require_once ROOT_PATH . 'core/template/admin-menu-horizontal.php'; ?>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row d-flex flex-nowrap">
        <div class="col-md-2 sidebar" id="sidebar">
            <?php require_once ROOT_PATH . 'core/tools/sidebar.php'; ?>
        </div>

        <div class="col-md-10 content-up">
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
        <div class="col-sm-6">
            <h2><?php echo t("Settings");?></h2>
            <form method="post">
  <div class="form-group">
    <label for="site_title"><?php echo t("Page Name");?></label>
    <input type="text" class="form-control" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required>
  </div>
  <div class="form-group">  
      <label for="meta_description"><?php echo t("META description");?></label>
    <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required><?php echo htmlspecialchars($settings['meta_description']); ?></textarea>
  </div>
  <div class="form-group">
    <label for="footer_text"><?php echo t("Footer text");?></label>
    <textarea class="form-control" id="footer_text" name="footer_text" rows="3" required><?php echo htmlspecialchars($settings['footer_text']); ?></textarea>
  </div>
  <div class="form-group mt-2">
    <label for="pretty_url"><?php echo t("Pretty URL");?></label>
    <input type="checkbox" class="form-control-ch" id="pretty_url" name="pretty_url" value="1" <?php echo ($settings['pretty_url'] == 1 ? 'checked' : '');?>>
</div>
<div class="form-group mt-2 mb-2">
    <label for="language"><?php echo t("Language");?></label>
    <select class="form-control-slc" id="language" name="language">
    <?php 
        // Pridedame "en" kalbos kodą, jei jo nėra mūsų kalbų sąraše
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

  <button type="submit" class="btn btn-primary"><?php echo t("Update settings");?></button>
</form>
</div>
  <div class="col-sm-4 mt-5">
  <form action="clear_cache.php" method="post">
    <input type="submit" name="clear_cache" value="<?php echo t("Clear Cache");?>" class="btn btn-danger">
</form>
 </hr>
<form action="create_backup.php" method="post">
    <input type="submit" name="create_backup" value="<?php echo t("Create a backup");?>" class="btn btn-success mt-2">
</form>
<?php 
        $backupDirectory = ROOT_PATH . 'core/tools/backups/';
        $backupFiles = getBackupFilesList($backupDirectory);

        echo "<h3>Atsarginių kopijų sąrašas</h3>";

        if (count($backupFiles) > 0) {
            echo '<ul>';
            foreach ($backupFiles as $file) {
                echo "<li><a href='download_backup.php?file=" . urlencode($file) . "'>" . htmlspecialchars($file) . "</a> <a href='delete_backup.php?file=" . urlencode($file) . "' onclick=\"return confirm('Ar tikrai norite ištrinti šį failą?')\">[Ištrinti]</a></li>";

            }
            echo '</ul>';
        } else {
            echo '<p>Nėra atsarginių kopijų.</p>';
        }
   ?>
</div>
</div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>
