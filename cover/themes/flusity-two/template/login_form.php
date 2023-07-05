
<?php if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start(); }
/*
 @ flusity
 Author Darius Jakaitis, author web site http://www.manowebas.lt
*/  
 ?>
  <header id="header">
 <?php  require_once 'menu-horizontal.php'; ?>
 </header>
    <section class="container spacer footer">
        <main class="main my-4">
        <div class="row">
            <div class="col-sm-4">
            <h2><?php echo t("Login system");?></h2>
            <p><?php echo t("The content management system is intended for personal websites");?>s</p>
           
    </div>
            <div class="col-sm-4">
    <h1 class="h3 mb-3 fw-normal"><?php echo t("Connect to page"); ?></h1>
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
<form method="POST" action="">
<div class="form-floating">
    <input type="text" class="form-control" id="login_name" name="login_name" placeholder="<?php echo t("Login Name or Email"); ?>" required>
    <label for="login_name"><?php echo t("Login Name or Email"); ?></label>
</div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo t("password"); ?>" required>
        <label for="password"><?php echo t("Password"); ?></label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

    <br>
    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit"><?php echo t("Login"); ?></button>
</form>
<p><?php echo t("Back to"); ?>&nbsp;<a href="/" class="btn-link"><?php echo strtolower(t("Home page")); ?></a>&nbsp;<?php echo t("or"); ?>&nbsp;
<?php echo strtolower(t("Create")); ?>&nbsp;<a href="register.php" class="btn-link"><?php echo strtolower(t("Registration")); ?></a>&nbsp;<p>
</div>
</div>
</main>
</section>
<?php  
    require_once 'footer.php'; 
 ?>