<?php require_once 'core/template/header-admin.php';?>
<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
        </div>
    </div>
</div>

<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row d-flex flex-nowrap">
    <div class="col-md-2 sidebar fixed-sidebar" id="sidebar">

            <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
        </div>
        <div class="col-md-10 content main-content-with-sidebar" id="content">

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
  <div class="col-4">
      <div class="p-3 border bg-light">
        <?php $places = getplaces($db);
        $total_places = count($places);
        ?>
        <h4><?php echo t("Places");?></h4>
        <p><?php echo $total_places; ?></p>
      </div>
    </div>
    <div class="col-4">
      <div class="p-3 border bg-light">
        <?php $allUsers = getAllUsers($db);
            $totalUsers = count($allUsers);
            ?>
      <h4><?php echo t("User's");?></h4>
        <p><?php echo $totalUsers; ?></p>
      </div>
    </div>
    <div class="col-4">
      <div class="p-3 border bg-light">
      <?php $allPosts = getAllPosts($db);
            $totalPosts = count($allPosts);
            ?>
      <h4><?php echo t("Post's");?></h4>
        <p><?php echo $totalPosts; ?></p>
      </div>
    </div>
    <div class="col-4">
      <div class="p-3 border bg-light">
      <?php $allMenu = getMenuItems($db);
            $totalMenu = count($allMenu);
            ?>
      <h4><?php echo t("Menu items");?></h4>
      <p><?php echo $totalMenu; ?></p>
      </div>
    </div>
    <div class="col-4">
      <div class="p-3 border bg-light">
      <?php $allBlock = getCustomBlocks($db);
            $totalBlock = count($allBlock);
            ?>
      <h4><?php echo t("Block's");?></h4>
      <p><?php echo $totalBlock; ?></p>
      </div>
    </div>
    <div class="col-4">
    <div class="p-3 border bg-light">
        <?php
        $totalFiles = countFilesInDatabase($db);
        ?>
        <h4><?php echo t("Files");?></h4>
        <p><?php echo $totalFiles; ?></p>
    </div>
</div>

  </div>
</div>
    
</div>
</div>

<?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-footer.php';?>
