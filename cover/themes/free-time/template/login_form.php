
<?php if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start(); }
/*
 @ flusity
 Author Darius Jakaitis, author web site http://www.manowebas.lt
*/  
 ?>
<?php require_once 'menu-horizontal.php';?>
<header class="masthead login-header" style="">
        <div class="overlay login-head-ov" style="height: 200px;background: rgba(205,111,105,0.51);padding-bottom: 0px;"></div>
    </header>
    <section class="py-4 py-xl-5" style="margin-top: -3px;">
        <div class="container">
            <div class="row mb-5" style="padding-bottom: 0px;padding-top: 5px;margin-bottom: 20px;">
                <div class="col-md-8 col-xl-6 text-center mx-auto" style="padding-bottom: 0px;"> 
                    <h1 class="h3 mb-3 fw-normal"><?php echo t("Login system");?></h1>
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endif; 
                        if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success alert-dismissible fade show slow-fade">
                                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; 

                        $csrf_token = generateCSRFToken();
                        ?>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="padding-top: 0px;">
                <div class="col-md-8 col-lg-8 col-xl-6" style="margin-top: -24px;padding-top: 0px;margin-right: 1px;">
                    <div class="card mb-5"></div>
                   
    <form method="POST" action="" class="text-center">
    <div class="form-floating">
    <div class="mb-3"><input type="text" class="form-control" id="login_name" name="login_name" placeholder="<?php echo t("Login Name or Email"); ?>" required></div>
       
    </div>
        <br>
        <div class="form-floating">
        <div class="mb-3"><input type="password" class="form-control" id="password" name="password" placeholder="<?php echo t("password"); ?>" required></div>
            
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

        <br>
        <div class="mb-3"><button class="w-100 btn btn-lg btn-primary mb-3" type="submit" style="background: rgb(230,227,160);--bs-primary: #7faef2;--bs-primary-rgb: 127,174,242;border-style: none;color: rgb(136,132,132);"><?php echo t("Login"); ?></button></div>
    </form>
        <p><?php echo t("Back to"); ?>&nbsp;<a href="/" class="btn-link"><?php echo strtolower(t("Home page")); ?></a>&nbsp;<?php echo t("or"); ?>&nbsp;
        <?php echo strtolower(t("Create")); ?>&nbsp;<a href="register.php" class="btn-link"><?php echo strtolower(t("Registration")); ?></a>&nbsp;<p>
               
                </div>
            </div>
        </div>
    </section>
<?php  
    require_once 'footer.php'; 
 ?>