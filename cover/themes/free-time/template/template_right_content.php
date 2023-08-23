<header class="header easy-header">
    <div class="overlay"></div>
    <canvas id="canvas"></canvas>
<?php require_once 'menu-horizontal.php';?>
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
        <div class="col-sm-8 p-3"> 
        <?php 
        displayPosts($posts);
        displayAddButton($menu_id);
        echo createPagination($url, $total_urls);        
        ?>
        </div>
        <div class="col-sm-4 p-3"> 
        <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'doc-full-12-1');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 text-center"> 
        <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'doc-full-12-2');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
</main>