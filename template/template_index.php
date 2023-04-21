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

            
<?php foreach ($posts as $post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
    <?php endforeach; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_urls; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>


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

  