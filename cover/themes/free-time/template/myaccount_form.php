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
<?php require_once 'menu-horizontal.php';  ?>
<header class="masthead register-header" style="background-image: url('/cover/themes/free-time/assets/img/pexels-pixabay-279810.jpg');height: 200px;padding-top: 0px;padding-bottom: 0px;margin-bottom: -16px;">
<div class="overlay register-head-ov" style="height: 200px;background: rgba(0,0,0,0.84);padding-bottom: 0px;"></div>
</header>
    <section class="py-4 py-xl-5" style="margin-top: -3px;">
        <div class="container">
            <div class="row mb-5" style="padding-bottom: 0px;padding-top: 5px;margin-bottom: 20px;">
                <div class="col-md-8 col-xl-6 text-center mx-auto" style="padding-bottom: 0px;">
                <h2><?php echo t("User Area");?></h2> 
                     <p><?php echo t("Content management system for personal websites");?></p>
                     <br>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="padding-top: 0px;">
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
    </section>