<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once ROOT_PATH . 'core/template/header-admin.php';
$contactFormSettings = getContactFormSettings($db, $prefix);
?>
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
            <h2><?php echo t("Contact form"); ?></h2>
            <form id="contactForm" method="post" action="update_contact_form_settings.php">
                <?php foreach ($contactFormSettings as $setting_contact): ?>
                    <div class="form-group">
                        <label for="<?php echo $setting_contact['setting_key']; ?>"><?php echo t("Key"); ?>:</label>
                        <input type="text" class="form-control" id="<?php echo $setting_contact['setting_key']; ?>" name="<?php echo $setting_contact['setting_key']; ?>" value="<?php echo $setting_contact['setting_key']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="<?php echo $setting_contact['setting_key']; ?>Value"><?php echo t("Value"); ?>:</label>
                        <input type="text" class="form-control" id="<?php echo $setting_contact['setting_key']; ?>Value" name="<?php echo $setting_contact['setting_key']; ?>Value" value="<?php echo $setting_contact['setting_value']; ?>" required>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary mt-3"><?php echo t("Save settings"); ?></button>
            </form>
                </main>
    </div>
</div>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>