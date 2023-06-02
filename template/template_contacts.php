<header id="header" class="no-header">
<?php require_once 'template/menu-horizontal.php';?>
</header>
<main class="main">
 <div class="container spacer">
    <div class="row">
        <div class="col-sm-7">
            <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByplace($db, $page_url, 'contact-left-7');
            } else {
                print "";
            }
            ?>
        </div>
        <div class="col-sm-5">
            <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByplace($db, $page_url, 'contact-right-5');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-5"> 
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
        <?php require_once 'contact_content.php';?>

        </div>
        <div class="col-sm-7">
        <?php foreach ($posts as &$post): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
       <?php endforeach; ?>
       <?php echo createPagination($url, $total_urls); ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 text-center"> 
        <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByplace($db, $page_url, 'contact-fluid-12');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
            </main>

    <?php require_once 'template/footer.php';?>
