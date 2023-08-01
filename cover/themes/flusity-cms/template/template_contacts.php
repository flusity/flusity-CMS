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
        <div class="col-sm-5 mt-0 pl-2">
        <?php require_once 'contact_content.php';?>

            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-left-7');
            } else {
                print "";
            }
            ?>

        </div>
        <div class="col-sm-7 p-3">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-right-5');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-5 p-2"> 
        </div>
        <div class="col-sm-7 p-2">
        <?php foreach ($posts as &$post): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
        <?php displayEditButton($post['id']); ?>
       <?php endforeach; ?>
       <?php echo createPagination($url, $total_urls); ?>
        </div>
    </div>
</div>
<div class="container-fluid mb-3 p-2">
    <div class="row">
        <div class="col-sm-12 text-center"> 
        <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-fluid-12');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
</main>
<div class="modal high-z-index" tabindex="-1" id="responseModal">
  <div class="modal-dialog">
    <div class="modal-content">
   
        <button type="button" class="btn-close uniqueCloseButton"  data-bs-dismiss="modal" aria-label="Close"></button>
      
      <div class="modal-body">
        <i class="fas fa-check-circle fa-3x"></i>
        <p id="responseMessage"></p>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo getThemePath($db, $prefix, 'js/cform.js'); ?>"></script>