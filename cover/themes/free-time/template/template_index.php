<?php require_once 'menu-horizontal.php';?>
    <header class="masthead">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-9 offset-lg-0 mx-auto position-relative">
                    <div class="site-heading">
                        <?php
                            $page_url = getCurrentPageUrl($db, $prefix);
                            if ($page_url) {
                                displayPlace($db, $prefix, $page_url, 'head-pulse-animated');

                            } else {
                                print "";
                            } 
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-8 mx-auto">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'home-content-top');

            } else {
                print "";
            }
            
        displayPosts($posts);
        displayAddButton($menu_id);
        echo createPagination($url, $total_urls);        
         
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'home-content-bottom');

            } else {
                print "";
            }
            ?>
            </div>
            <div class="col">
                <div class="col-md-12">     
                    <?php 
                        $page_url = getCurrentPageUrl($db, $prefix);
                        if ($page_url) {
                            displayPlace($db, $prefix, $page_url, 'right-my-history');

                        } else {
                            print "";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>