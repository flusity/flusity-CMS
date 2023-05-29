<?php 
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
require_once 'template/header.php';
$db = getDBConnection($config);

// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = validateInput($_POST['csrf_token']);
    if (!validateCSRFToken($csrf_token)) {
        $error_message = t("Invalid CSRF token. Try again.");
    } else {
        $login_name = validateInput($_POST['login_name']);
        $username = validateInput($_POST['username']);
        $password = validateInput($_POST['password']);
        $confirm_password = validateInput($_POST['confirm_password']);
        $surname = validateInput($_POST['surname']);
        $phone = validateInput($_POST['phone']);
        $email = validateInput($_POST['email']);

        
        if ($password === $confirm_password) {
            if (isUsernameTaken($username, $db) || isLoginNameTaken($login_name, $db)) {
                $error_message = t("That Name or Login Name is already taken. Choose another.");
            } else {
                if (registerUser($login_name, $username, $password, $surname, $phone, $email, $db)) {
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
<header id="header">
<?php require_once 'template/menu-horizontal.php';?>
</header>
<section class="container spacer">
    <main class="main my-4">
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
        <input type="text" class="form-control" id="login_name" name="login_name" placeholder="<?php echo t("Login Name");?>" required>
        <label for="login_name"><?php echo t("Login Name");?></label>
    </div>
    <br>
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
    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit"><?php echo t("Register");?></button>
</form>
<p><?php echo t("Back to"); ?>&nbsp;<a href="/" class="btn-link"><?php echo strtolower(t("Home page")); ?></a>&nbsp;<?php echo t("or"); ?>&nbsp;
&nbsp;<a href="login.php" class="btn-link"><?php echo strtolower(t("Log In")); ?></a>&nbsp;<p>

</div>
</div>
</main>
</section>
<?php require_once 'template/footer.php';?>
