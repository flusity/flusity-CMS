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
                <div class="form-group">
                    <label for="emailSubject"><?php echo t("Email Subject"); ?>:</label>
                    <input type="text" class="form-control" id="emailSubject" name="emailSubject" value="<?php echo $contactFormSettings['email_subject']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="emailBody"><?php echo t("Email Body"); ?>:</label>
                    <textarea class="form-control" id="emailBody" name="emailBody" required><?php echo $contactFormSettings['email_body']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="emailSuccessMessage"><?php echo t("Success Message"); ?>:</label>
                    <input type="text" class="form-control" id="emailSuccessMessage" name="emailSuccessMessage" value="<?php echo $contactFormSettings['email_success_message']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="emailErrorMessage"><?php echo t("Error Message"); ?>:</label>
                    <input type="text" class="form-control" id="emailErrorMessage" name="emailErrorMessage" value="<?php echo $contactFormSettings['email_error_message']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><?php echo t("Save settings"); ?></button>
            </form>
                </main>
    </div>
</div>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>