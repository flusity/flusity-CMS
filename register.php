<?php header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
require_once 'template/header.php';
if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = validateInput($_POST['csrf_token']);
    if (!validateCSRFToken($csrf_token)) {
        $error_message = 'Neteisingas CSRF žetonas. Bandykite dar kartą.';
    } else {
        $username = validateInput($_POST['username']);
        $password = validateInput($_POST['password']);
        $confirm_password = validateInput($_POST['confirm_password']);
        $surname = validateInput($_POST['surname']);
        $phone = validateInput($_POST['phone']);
        $email = validateInput($_POST['email']);

        if ($password === $confirm_password) {
            if (isUsernameTaken($username, $db)) {
                $error_message = t("That Name is already taken. Choose another.");
            } else {
                if (registerUser($username, $password, $surname, $phone, $email, $db)) {
                    header('Location: login.php');
                    exit();
                } else {
                    $error_message = t("User registration failed. Try again.");
                }
            }
        } else {
            $error_message = t("Passwords do not match. Try again.");
        }
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
        <h2><?php echo t("Registration system");?></h2>
        <p><?php echo t("Content management system for personal websites");?></p>
        <?php require_once 'assets/logo.php'?> 
    </div>
        <div class="col-sm-4">
<h1 class="h3 mb-3 fw-normal"><?php echo t("Registration");?></h1>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>
<form method="POST" action="">
    <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo t("User Name");?>" required>
        <label for="username"><?php echo t("User Name");?></label>
    </div>
    <br>
    <div class="form-floating">
        <input type="text" class="form-control" id="surname" name="surname" placeholder="<?php echo t("Surname");?>" required>
        <label for="surname"><?php echo t("Surname");?></label>
    </div>
    <br>
    <div class="form-floating">
        <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo t("Phone");?>" required>
        <label for="phone"><?php echo t("Phone");?></label>
    </div>
    <br>
    <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo t("Email");?>" required>
        <label for="email"><?php echo t("Email");?></label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo t("Password");?>" required>
        <label for="password"><?php echo t("Password");?></label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="<?php echo t("Repeat the password");?>" required>
        <label for="confirm_password"><?php echo t("Repeat the password");?></label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo t("Register");?></button>
</form>
</div>
</div>
</div>
   <?php require_once 'core/template/admin-footer.php';?>