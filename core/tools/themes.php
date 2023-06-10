<?php 
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

<?php 
    $themes = getAllThemes();
    $currentTheme = getCurrentTheme($db); // jūs turite pakeisti $db į jūsų duomenų bazės objektą

?>

    <div class="col-sm-9">
        <?php  if (isset($_SESSION['success_message'])) {
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
            } ?>
    </div>
    <h1 class="mb-3"><?php echo t("Website themes");?></h1>
    
    
    
<?php 
    if (empty($themes)) {
        echo '<p>' . t("No themes found in the system.") . '</p>';
    } else {
?>


<div class="container">
    <div class="row">
    <?php foreach ($themes as $theme) {
        $isInstalled = is_dir($_SERVER['DOCUMENT_ROOT'] . '/cover/themes/' . $theme['name']) && $theme['name'] === $currentTheme;
    ?>
      
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-6">
                        <img src="<?php echo $theme['theme_thumb']; ?>" class="img-fluid rounded-start p-1" alt="theme image" style="max-width: 380px; max-height: 250px; width: 98%;">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body pl-2">
                            <h5 class="card-title"><?php echo htmlspecialchars($theme['name']); ?></h5>
                            <p class="card-text">
                                <strong><?php echo t("Version");?>:</strong> <?php echo htmlspecialchars($theme['version']); ?><br/>
                                <strong><?php echo t("Author");?>:</strong> <?php echo htmlspecialchars($theme['author']); ?><br/>
                                <strong><?php echo t("Description");?>:</strong> <?php echo htmlspecialchars($theme['description']); ?>
                            </p>
                            <?php if ($isInstalled) { ?>
                                <?php echo t("Instaled");?>&nbsp;<i class="fa-solid fa-check"></i>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary" onclick="installTheme('<?php echo $theme['name']; ?>')" data-theme-name="<?php echo $theme['name']; ?>" title="<?php echo t("select");?>"><?php echo t("Install");?></button>
                            <?php } ?>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php } ?>






         </div>
        </div>
      </div>
    </main>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel"><?php echo t("Confirm deletion");?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php echo t("Are you sure you want to delete this theme?");?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger  delete-theme-btn" id="confirm-delete-btn"><?php echo t("Delete");?></button>
      </div>
    </div>
  </div>
</div>
<script>
    function installTheme(themeName) {
        $.ajax({
            type: "POST",
            url: "update_theme.php",
            data: {action: "install_theme", theme: themeName},
            success: function(response) {
                location.reload(); 
            },
            error: function() {
                alert('Error while installing the theme');
            }
        });
    }


$(document).ready(function () {
  // Paspaudus ištrynimo mygtuką, atidaro patvirtinimo modalą
  $('button[data-bs-target="#deleteThemeModal"]').on('click', function () {
    const themeId = $(this).data('theme-id');
    $('#confirmDeleteModal').data('theme-id', themeId);
    $('#confirmDeleteModal').modal('show');
  });

  // Paspaudus patvirtinimo mygtuką, ištrina kategoriją
  $('#confirm-delete-btn').on('click', function () {
    const themeId = $('#confirmDeleteModal').data('theme-id');
    
    // Siunčia POST užklausą į delete_theme.php failą
    $.ajax({
      type: 'POST',
      url: 'delete_theme.php',
      data: {
        action: 'delete_theme',
        theme_id: themeId
      },
      success: function(response) {
        // Uždaro modalą ir peradresuoja į themes.php puslapį
        $('#confirmDeleteModal').modal('hide');
        window.location.href = 'themes.php';
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });
});

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>