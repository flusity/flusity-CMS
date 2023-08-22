<?php 
 if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }
/*
 @MiniFrame css karkasas Lic GNU
 Author Darius Jakaitis, author web site http://www.manowebas.lt
 fix-content
*/
?>
<?php require_once 'menu-horizontal.php';  ?>
<header class="masthead register-header" style="background-image: url('/cover/themes/free-time/assets/img/pexels-pixabay-279810.jpg');height: 200px;padding-top: 0px;padding-bottom: 0px;margin-bottom: -16px;">
<div class="overlay register-head-ov" style="height: 200px;background: rgba(0,0,0,0.84);padding-bottom: 0px;"></div>
</header>
    <section class="py-4 py-xl-5" style="margin-top: -3px;">
        <div class="container">
            <div class="row mb-5" style="padding-bottom: 0px;padding-top: 5px;margin-bottom: 20px;">
                <div class="col-md-8 col-xl-6 text-center mx-auto" style="padding-bottom: 0px;">
                <h2><?php echo t("Registration system");?></h2>
                     <p><?php echo t("Content management system for personal websites");?></p>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="padding-top: 0px;">
                <div class="col-md-8 col-lg-8 col-xl-6" style="margin-top: -24px;padding-top: 0px;margin-right: 1px;">
                    <div class="card mb-5"></div>


                    <?php if (isset($error_message)): ?>
    <div id="error_message" class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
 
<?php endif; ?>
<?php if($registration_enable == 1) { ?>
<form method="POST" action="" class="text-center" >
    <div class="form-floating">
    <div class="mb-3"><input type="text" class="form-control" id="login_name" name="login_name" placeholder="<?php echo t("Login Name");?>" required></div>
    
    </div>
    <br>
    <div class="form-floating">
    <div class="mb-3"><input type="text" class="form-control" id="username" name="username" placeholder="<?php echo t("User Name");?>" required></div>
 
    </div>
    <br>
    <div class="form-floating">
    <div class="mb-3"><input type="text" class="form-control" id="surname" name="surname" placeholder="<?php echo t("Surname");?>" required></div>
  
    </div>
    <br>
    <div class="form-floating">
    <div class="mb-3"><input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo t("Phone");?>" required></div>

    </div>
    <br>
    <div class="form-floating">
    <div class="mb-3"><input type="email" class="form-control" id="email" name="email" placeholder="<?php echo t("Email");?>" required></div>

    </div>
    <br>
    <div class="form-floating">
    <div class="mb-3"><input type="password" class="form-control" id="password" name="password" placeholder="<?php echo t("Password");?>" required></div>

    </div>
    <br>
    <div class="form-floating">
    <div class="mb-3"><input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="<?php echo t("Repeat the password");?>" required></div>
   
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <br>
    <div class="mb-3"><button  class="btn btn-primary d-block w-100" type="submit" style="background: rgb(230,227,160);--bs-primary: #7faef2;--bs-primary-rgb: 127,174,242;border-style: none;color: rgb(136,132,132);"><?php echo t("Register");?></button></div>
</form>
<?php } else {
    echo "<p>" . t("Registration is currently suspended. Please try again later") . "</p>
    <div class='container mt-5 mb-3 no-register'></div>";
}?>
<p><?php echo t("Back to"); ?>&nbsp;<a href="/" class="btn-link"><?php echo strtolower(t("Home page")); ?></a>&nbsp;<?php echo t("or"); ?>&nbsp;
&nbsp;<a href="login.php" class="btn-link"><?php echo strtolower(t("Log In")); ?></a>&nbsp;<p>

                </div>
            </div>
        </div>
    </section>