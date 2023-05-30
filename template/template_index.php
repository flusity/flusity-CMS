
<header id="header" class="header">
<?php require_once 'template/menu-horizontal.php';?>
<div class="box-header">
    <div class="header__content">
        <h1 class="header__title"></h1>
        <p class="header__text"></p>
        <a href="#" class="header__link btn"></a>
    </div>
</div>
<div class="container-fluid"> 
    <div class="row"> 
    <div class="boxes col-lg-4 col-md-12 col-sm-12 col-12"> 
        <div class="box d-flex">
           <div class="row">
                <div class="col-10 ml-1">
                <?php 
                    $page_url = getCurrentPageUrl($db);
                    if ($page_url) {
                        displayCustomBlockByCategory($db, $page_url, 'head-box-one');
                    } else {
                        print "";
                    }
                    ?>
                 
                </div>
            </div>
        </div>
        <div class="box d-flex">
            <div class="row">
                <div class="col-10 ml-1">
                <?php 
                    $page_url = getCurrentPageUrl($db);
                    if ($page_url) {
                        displayCustomBlockByCategory($db, $page_url, 'head-box-two');
                    } else {
                        print "";
                    }
                    ?>
               </div>
            </div>
        </div>
    </div>
</div>
</div>
</header>
<main class="main">
<div class="container">
    <div class="row">
        <div class="col-sm-7">
            <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByCategory($db, $page_url, 'home-left-7');
            } else {
                print "";
            }
            ?>
        </div>
        <div class="col-sm-5">
            <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByCategory($db, $page_url, 'home-right-5');
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
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 text-center"> 
        <?php 
            $page_url = getCurrentPageUrl($db);
            if ($page_url) {
                displayCustomBlockByCategory($db, $page_url, 'home-col-down-12');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
</main>
