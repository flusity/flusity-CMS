<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';

$db = getDBConnection($config);

$contactFormSettings = getContactFormSettings($db);

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
            <h2><?php echo t("Contact form"); ?></h2>
            
  
            <form id="contactForm" method="post">
                <?php foreach ($contactFormSettings as $setting_contact): ?>
                    <div class="form-group">
                        <label for="<?php echo $setting_contact['setting_key']; ?>"><?php echo t("Key"); ?>:</label>
                        <input type="text" class="form-control" id="<?php echo $setting_contact['setting_key']; ?>" name="<?php echo $setting_contact['setting_key']; ?>" value="<?php echo $setting_contact['setting_key']; ?>" required>
                      
                    </div>
                    <div class="form-group">
                        <label for="<?php echo $setting_contact['setting_value']; ?>"><?php echo t("Value"); ?>:</label>
                      
                        <input type="text" class="form-control" id="<?php echo $setting_contact['setting_key']; ?>" name="<?php echo $setting_contact['setting_key']; ?>" value="<?php echo $setting_contact['setting_value']; ?>" required>
                    
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary mt-3"><?php echo t("Save contact settings"); ?></button>
            </form>


        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>
