<?php
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }
    /*
    @MiniFrame css karkasas Lic GNU
    Author Darius Jakaitis, author web site http://www.manowebas.lt
    fix-content
    */
   ?>
<header class="header easy-header">
    <div class="overlay"></div>
    <canvas id="canvas"></canvas>
<?php require_once 'menu-horizontal.php'; ?>
        <div class="col-md-12 easy-hello-box">
            <h1>
              <span class="easy-word">Flusity free CMS for all</span>
          </h1>
        </div>
</header>
<main class="main mt-0" id="main">
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
  <div class="container">
    <div class="row">
        <div class="col-sm-4">
        <h2><?php echo t("User Area");?></h2>    
</div>
</div>
<div class="container mt-0">
    <div class="row">
      <div class="col-md-6 mb-2 p-2">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'acc-left-7');
            } else {
                print "";
            }
            ?>
        </div>
        <div class="col-md-6 p-2">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'acc-right-5');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
</main>