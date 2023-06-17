<?php require_once 'core/template/header-admin.php';?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4  content-up">
      <div class="row mt-3 mb-5">
        <h2><?php echo t("Administration tools");?></h2>
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
      <div class="row g-2">
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-map-marker-alt fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $places = getplaces($db);
            $total_places = count($places);
            ?>
            <h4><?php echo t("Places");?></h4>
            <p><?php echo $total_places; ?></p>
        </div>
    </div>
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-users fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $allUsers = getAllUsers($db);
            $totalUsers = count($allUsers);
            ?>
            <h4><?php echo t("User's");?></h4>
            <p><?php echo $totalUsers; ?></p>
        </div>
    </div>
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-newspaper fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $allPosts = getAllPosts($db);
            $totalPosts = count($allPosts);
            ?>
            <h4><?php echo t("Post's");?></h4>
            <p><?php echo $totalPosts; ?></p>
        </div>
    </div>
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-bars fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $allMenu = getMenuItems($db);
            $totalMenu = count($allMenu);
            ?>
            <h4><?php echo t("Menu");?></h4>
            <p><?php echo $totalMenu; ?></p>
        </div>
    </div>
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-cubes fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $allBlock = getCustomBlocks($db);
            $totalBlock = count($allBlock);
            ?>
            <h4><?php echo t("Block's");?></h4>
            <p><?php echo $totalBlock; ?></p>
        </div>
    </div>
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-file fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $totalFiles = countFilesInDatabase($db);
            ?>
            <h4><?php echo t("Files");?></h4>
            <p><?php echo $totalFiles; ?></p>
        </div>
    </div>
    <div class="col-2">
        <div class="p-3 border cms-front-shadow">
            <i class="fas fa-puzzle-piece fa-2x"></i> <!-- FontAwesome ikona -->
            <?php 
            $totalAddons= totalAddons($db);
            ?>
            <h4><?php echo t("Addons");?></h4>
            <p><?php echo $totalAddons; ?></p>
        </div>
    </div>
</div>

      </main>
    </div>
</div>
<?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-footer.php';?>
