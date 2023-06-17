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
     $systemAddons = getAllSystemAddons();
     $installedAddons = getAllAddons($db); 
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
    <h1 class="mb-3"><?php echo t("Website addons");?></h1>
    
<?php 
    if (empty($systemAddons)) {
      echo '<p>' . t("No addons found in the system.") . '</p>';
  } else {
    
?>

<div class="container">
    <div class="row">
    <?php 
     foreach ($systemAddons as $addon) {
      $isInstalled = false;
      $isActive = false;
      foreach($installedAddons as $installedAddon) {
          if ($installedAddon['name_addon'] == $addon['name_addon']) {
              $isInstalled = true;
              $isActive = isActiveAddon($addon['name_addon'], $db);
              break;
          }
      }
  ?>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $addon['addons_thumb']; ?>" class="img-fluid rounded-start p-1" alt="addon image" style="max-width: 300px; max-height: 200px; width: 98%;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body pl-2">
                            <h5 class="card-title"><?php echo htmlspecialchars($addon['name_addon']); ?></h5>
                            <p class="card-text">
                                <strong><?php echo t("Version");?>:</strong> <?php echo htmlspecialchars($addon['version']); ?><br/>
                                <strong><?php echo t("Author");?>:</strong> <?php echo htmlspecialchars($addon['author']); ?><br/>
                                <strong><?php echo t("Description");?>:</strong> <?php echo htmlspecialchars($addon['description']); ?>
                            </p>
                        </div>
                    </div>  
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item addon-card"> 
                            <?php if ($isInstalled) { ?>
                                <?php echo t("Installed");?>&nbsp;<i class="fa fa-check link-success"></i>&nbsp;
                                <a href="#" class="uninstall-addon" data-addon-name="<?php echo $addon['name_addon']; ?>" title="<?php echo t("Uninstall");?>">
                                    <i class="fa fa-times" style="font-size: 22px; margin-left:5px;"></i>
                                </a>
                    
                                <?php if ($isActive) { ?>
                                  <button type="button" class="btn btn-primary float-end" title="<?php echo t("Edit");?>"><i class="fa fa-tools"></i></button>
                                  <?php } ?>

                            <?php } else { ?>
                                <button type="button" class="btn btn-success link-success" onclick="installAddon('<?php echo $addon['name_addon']; ?>')" data-addon-name="<?php echo $addon['name_addon']; ?>" title="<?php echo t("install");?>"><?php echo t("Install");?></button>
                                <button type="button" class="btn btn-primary float-end delete-addon" data-addon-name="<?php echo $addon['name_addon']; ?>" title="<?php echo t("delete");?>"><i class="fa fa-trash-alt link-danger"></i></button>
                               
                                <div id="deleteToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-body">
                                Are you sure you want to delete this addon?
                                    <div class="mt-2 pt-2 border-top">
                                    <button id="deleteAddonConfirm" type="button" class="btn btn-primary btn-sm">Delete</button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                                    </div>
                                </div>
                                </div>
                                <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="toast" role="alert" aria-live="assertive" aria-autohide="false" id="deleteAddonToast">
                <div class="toast-header">
                    <strong class="me-auto">Addon Uninstall</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Are you sure you want to uninstall this addon?
                <div class="mt-2 pt-2 border-top">
                    <button id="deleteAddonConfirm" type="button" class="btn btn-primary btn-sm">Uninstall</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
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

<script>
    $(document).ready(function () {
    var deleteAddonToast = new bootstrap.Toast(document.getElementById('deleteAddonToast'));

    $('.uninstall-addon').on('click', function(e) {
        e.preventDefault();
        var addonName = $(this).data('addon-name');
        var position = $(this).offset();
        $('#deleteAddonToast').css({
            position: 'absolute', 
            top: position.top,
            left: position.left,
        });
        $('#deleteAddonToast').css({
            'z-index': 9999
        });

        $('#deleteAddonConfirm').off('click').on('click', function() {
            deleteAddonToast.hide();

            $.ajax({
                type: 'POST',
                url: 'actions/uninstall_addon.php',
                data: {'addonName': addonName, 'action': 'uninstall_addon'},
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        location.reload(); 
                    } else {
                        location.reload(); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

        deleteAddonToast.show();
    });




    var deleteAddonName; 

$('.delete-addon').on('click', function(e) {
  e.preventDefault();
  deleteAddonName = $(this).data('addon-name');
  var deleteToast = new bootstrap.Toast(document.getElementById('deleteToast'));
  deleteToast.show();
});

$('#deleteAddonConfirm').on('click', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'POST',
    url: 'actions/delete_addon.php',
    data: {'addonName': deleteAddonName, 'action': 'delete_addon'},
    dataType: 'json',
    success: function(response) {
        console.log(response);
        if (response.success) {
            location.reload(); 
        } else {
            alert('Failed to delete addon ' + deleteAddonName);
            location.reload(); 
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
    }
  });
});
});

    function installAddon(addonName) {
      $.ajax({
            type: "POST",
            url: "actions/install_addon.php",
            data: {action: "install_addon", addon: addonName},
            success: function(response) {
                console.log("Response: ", response);
                location.reload(); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error: ", textStatus, errorThrown);
                alert('Error while installing the Addon');
            }
        });

    }

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>