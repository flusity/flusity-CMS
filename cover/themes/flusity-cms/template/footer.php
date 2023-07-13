<div class="social-section container-fluid mt-5">
    <div class="row">
    <div class="col-md-4">
    <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'footer-col4-1');
            } else {
                print "";
            }
            ?>
    </div>
    <div class="col-md-4">
    <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'footer-col4-2');
            } else {
                print "";
            }
            ?>
    </div>
    <div class="col-md-4">
    <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'footer-col4-3');
            } else {
                print "";
            }
            ?>
    </div>
</div>
</div>
<footer class="footer container-fluid">
  <div class="row">
       <p><?php print $footer_text; ?></p>
  </div>
</footer>
<script src="<?php echo getThemePath($db, $prefix, 'js/main.js'); ?>"></script>
<script src="/assets/popperjs/popper.min.js"></script>
<script src="/assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>