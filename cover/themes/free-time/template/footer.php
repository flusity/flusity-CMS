<footer style="padding-bottom: 87px;padding-top: 34px;margin-top: 69px;margin-bottom: 0px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 col-xl-4 text-center text-lg-start d-flex flex-column">
                    <?php 
                        $page_url = getCurrentPageUrl($db, $prefix);
                        if ($page_url) {
                            displayPlace($db, $prefix, $page_url, 'footer-col4-1');
                        } else {
                            print "";
                        }
                        ?>
                </div>
                <div class="col-sm-4 col-md-3 col-xl-4 text-center text-lg-start d-flex flex-column">
                   
                    <?php 
                        $page_url = getCurrentPageUrl($db, $prefix);
                        if ($page_url) {
                            displayPlace($db, $prefix, $page_url, 'footer-col4-2');
                        } else {
                            print "";
                        }
                        ?>
                </div>
                <div class="col">
                    <ul class="list-inline text-center" style="padding: 19px;height: 90.325px;">
                    <?php 
                        $page_url = getCurrentPageUrl($db, $prefix);
                        if ($page_url) {
                            displayPlace($db, $prefix, $page_url, 'footer-col4-3');
                        } else {
                            print "";
                        }
                        ?>
                        <li class="list-inline-item"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span></li>
                        <li class="list-inline-item"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-github fa-stack-1x fa-inverse"></i></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="text-muted mb-0" style="padding-left: 10px;text-align: center;padding-bottom: 0px;margin-bottom: 0px;padding-top: 0px;margin-top: 12px;"><?php print $footer_text; ?></p>
    </footer>
    <script src="<?php echo getThemePath($db, $prefix, 'js/jdscript.js'); ?>"></script>
    <script src="<?php echo getThemePath($db, $prefix, 'js/lang.js'); ?>"></script>
    <script src="<?php echo getThemePath($db, $prefix, 'assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo getThemePath($db, $prefix, 'assets/js/bs-init.js'); ?>"></script>
    <script src="<?php echo getThemePath($db, $prefix, 'assets/js/clean-blog.js'); ?>"></script>
</body>
</html>