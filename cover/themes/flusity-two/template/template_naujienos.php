
<header id="header" class="no-header">
<?php require_once 'template/menu-horizontal.php';?>
</header>
<main class="main">
 <div class="container spacer">
    <div class="row">
        <div class="col-sm-7">
        </div>
        <div class="col-sm-5">
            <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByplace($db, $page_url, 'news-right-5');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12"> 
        <?php foreach ($posts as &$post): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
        <?php endforeach; ?>
         <?php echo createPagination($url, $total_urls); ?>
        </div>
    </div>
</div>
</main>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 text-center"> 
            <p>Your other content col-sm</p>
        </div>
    </div>
</div>

    <?php require_once 'template/footer.php';?>
