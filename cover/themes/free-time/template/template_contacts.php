
<?php require_once 'menu-horizontal.php';?>
<header class="masthead contact-head">
        <div class="overlay contact-head-ov"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto position-relative">
                    <div class="site-heading">
                        <h1></h1><span class="subheading">Have questions? I have answers.</span>

                        
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
                </div>
            </div>
        </div>
    </header>
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="row">
                <div class="col" style="border-width: 0px;border-right-width: 0px;"><iframe allowfullscreen="" frameborder="0" src="https://cdn.bootstrapstudio.io/placeholders/map.html" width="100%" height="100%"></iframe></div>
                <div class="col-md-6 col-xl-6">
                <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-fluid-12');
            } else {
                print "";
            }
            ?>

        

                    <div>
                        <form id="contactForm" name="sentMessage">
                            <div class="control-group">
                                <div class="form-floating controls mb-3"><input class="form-control" type="text" id="name" required="" placeholder="Name"><label class="form-label" for="name">Name</label><small class="form-text text-danger help-block"></small></div>
                            </div>
                            <div class="control-group">
                                <div class="form-floating controls mb-3"><input class="form-control" type="email" id="email" required="" placeholder="Email Address"><label class="form-label">Email Address</label><small class="form-text text-danger help-block"></small></div>
                            </div>
                            <div class="control-group">
                                <div class="form-floating controls mb-3"><small class="form-text text-danger help-block"></small></div>
                            </div>
                            <div class="control-group">
                                <div class="form-floating controls mb-3"><textarea class="form-control" id="message" data-validation-required-message="Please enter a message." required="" placeholder="Message" style="height: 150px;"></textarea><label class="form-label">Message</label><small class="form-text text-danger help-block"></small></div>
                            </div>
                            <div id="success"></div>
                            <div class="mb-3"><button class="btn btn-primary" id="sendMessageButton" type="submit">Send</button></div>
                        </form>
                    </div>
                </div>


                
                <?php foreach ($posts as &$post): ?>
                    <h2><?php echo $post['title']; ?></h2>
                    <?php echo $post['content']; ?>
                    <?php displayEditButton($post['id']); ?> 
                <?php endforeach; ?> 

                <?php displayAddButton($menu_id); ?>
                <?php echo createPagination($url, $total_urls); ?>

            </div>
        </div>
    </section>







<div class="modal high-z-index" tabindex="-1" id="responseModal">
  <div class="modal-dialog">
    <div class="modal-content">
   
        <button type="button" class="btn-close uniqueCloseButton"  data-bs-dismiss="modal" aria-label="Close"></button>
      
      <div class="modal-body">
        <i class="fas fa-check-circle fa-3x"></i>
        <p id="responseMessage"></p>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo getThemePath($db, $prefix, 'js/cform.js'); ?>"></script>