<header class="header">
    <div class="overlay"></div>
    <canvas id="canvas"></canvas>
    <?php require_once 'menu-horizontal.php';?>
  <div class="container-fluid mb-3">
    <div class="row">
      <div class="col-md-8 hello-box">
          <h1>
            <span class="word">Flusity</span>
            <span class="word">free</span>
            <span class="word">CMS</span>
            <span class="word">for</span>
            <span class="word">all</span>
            <br>
            <span class="word fs-5">
              <?php 
                    $page_url = getCurrentPageUrl($db, $prefix);
                    if ($page_url) {
                        displayPlace($db, $prefix, $page_url, 'head-box-one');

                    } else {
                        print "";
                    }
                    ?>
            </span>
        </h1>
      </div>
  <div class="col-sm-12 col-md-4">
          <div class="row">
            <div class="col-md-12 mt-5">
              <div class="heading-box">
              <?php 
                    $page_url = getCurrentPageUrl($db, $prefix);
                    if ($page_url) {
                        displayPlace($db, $prefix, $page_url, 'head-box-two');
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
<main class="main mt-5" id="main">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 mb-2">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'home-left-7');
            } else {
                print "";
            }
            ?>
        </div>
        <div class="col-md-6">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'home-right-5');
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
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'home-col-down-12');
                
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
</main>