<?php 
require_once 'security/config.php';
require_once 'core/functions/functions.php';
require_once 'get_customblock.php';
secureSession();
$db = getDBConnection($config);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);
} 

$limit = 10;
$url = isset($_GET['url']) ? intval($_GET['url']) : 1;
$offset = ($url - 1) * $limit;

// Puslapių pateikimas
$menuUrl = isset($_GET['page']) && !isset($_GET['url']) ? $_GET['page'] : 'index';

$posts = getPostsNews($db, $limit, $offset, $menuUrl);
$total_posts = countPosts($db);
$total_urls = ceil($total_posts / $limit);
?>
<?php require_once 'template/header.php';?>
<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
        <?php require_once 'template/menu-horizontal.php';?>
        </div>
    </div>
</div>   
    
<div class="container">
    <div class="row">
        <div class="col-sm-7">
            Your other content col-sm
        </div>
        <div class="col-sm-5">
            <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByCategory($db, $page_url, 'dd7777777');
            } else {
                print "---";
            }
            
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12"> 
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
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 text-center"> 
            <p>Your other content col-sm</p>
        </div>
    </div>
</div>


    <?php require_once 'template/footer.php';?>
