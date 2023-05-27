<?php
 require_once 'template/header.php';
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$csrf_token = generateCSRFToken();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'];
    if (!validateCSRFToken($csrf_token)) {
        die('Blogas CSRF žetonas.');
    }

    $username = validateInput($_POST['username']);
    $password = validateInput($_POST['password']);

    if ($user = authenticateUser($username, $password)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        session_regenerate_id(true);
        header('Location: /');
        exit();
    } else {
        $error_message = t('Invalid username or password.');
    }
} ?>
<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
        <?php require_once 'template/menu-horizontal.php';?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
        <h2><?php echo t("Login system");?></h2>
        <p><?php echo t("The content management system is intended for personal websites");?>s</p>
    <?php require_once 'assets/logo.php'?> 
</div>
        <div class="col-sm-4">
<h1 class="h3 mb-3 fw-normal"><?php echo t("Connect to page"); ?></h1>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; 
$csrf_token = generateCSRFToken();
?>
<form method="POST" action="">
    <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo t("User Name"); ?>" required>
        <label for="username"><?php echo t("User Name"); ?></label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo t("{p}assword"); ?>" required>
        <label for="password"><?php echo t("Password"); ?></label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

    <br>
    <!-- Įterpkite reCAPTCHA kodą čia -->
    <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo t("Login"); ?></button>
</form>
<p><?php echo t("Back to"); ?> &nbsp;<a href="/" class="btn btn-link"><?php echo t("Home page"); ?></a>&nbsp;<p>
</div>
</div>
</div>
<?php require_once 'template/footer.php';?>