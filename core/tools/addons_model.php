<?php 
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
ob_start();
 require_once ROOT_PATH . 'core/template/header-admin.php'; 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';
 require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';
 ?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>

<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">
                <div class="col-sm-9">
                <div class="message"></div>
                <?php if (isset($_SESSION['success_message'])) {
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
<?php 
    $systemAddons = getAllSystemAddons();
    $installedAddons = getAllAddons($db, $prefix); 

    if (!isset($_GET['name']) || !isset($_GET['id'])) {

        echo "Parametrų nėra.";
        return;
    }
    $name = htmlspecialchars($_GET['name']);
    $id = intval($_GET['id']); // naudojamas intval() užtikrinimui, kad 'id' yra sveikasis skaičius

    foreach ($systemAddons as $addon) {
        if($addon['name_addon'] !== $name || getAddonId($db, $prefix, $addon['name_addon']) !== $id) {
            continue; // praleidžia ciklą, jei addon'as neatitinka gautų parametrų
        }

        $isInstalled = isActiveAddon($name, $db, $prefix);
        if(!$isInstalled) {
            continue;
        }

        foreach($installedAddons as $installedAddon) {
            if ($installedAddon['name_addon'] !== $name) {
                continue;
            }
            $isActive = $installedAddon['active'];
            $showFront = $installedAddon['show_front'];
            if(!$isActive || $showFront != 1) {
                continue;
            }

            $addonPath = $_SERVER['DOCUMENT_ROOT'] . "/cover/addons/$name/model_tools.php";
            if (!file_exists($addonPath)) {
                echo "Addon'o '$name' model_tools.php failas nerastas.";
                continue;
            }
            include $addonPath;
            break; // nutraukiamas ciklas, kai addon'as rastas ir apdorojamas
        }
    }
ob_end_flush();
?>
    </main>
  </div>
</div>
<script>


$('#offcanvasRight').on('show.bs.offcanvas', function () {
    loadImages();
});

$('.prev').click(function() {
    index = Math.max(0, index - 6);
    loadImages();
    return false; 
});
$('.next').click(function() {
    index += 6;
    loadImages();
    return false; 
});

$('#file_id').change(function(event) {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_image').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>