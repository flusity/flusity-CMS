<?php
session_start();
require_once 'security/config.php';
require_once 'core/functions/functions.php';
secureSession();

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
        $error_message = 'Neteisingas vartotojo vardas arba slaptažodis.';
    }
}
?>

<?php require_once 'template/header.php';?>
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
        <h2>Prisijungimo sistema</h2>
        <p>Turinio valdymo sistema skirta asmeninėms svetainėms</p>
    <?php require_once 'assets/logo.php'?> 
</div>
        <div class="col-sm-4">
<h1 class="h3 mb-3 fw-normal">Prisijungimas</h1>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; 
$csrf_token = generateCSRFToken();
?>
<form method="POST" action="">
    <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="Vartotojo vardas" required>
        <label for="username">Vartotojo vardas</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Slaptažodis" required>
        <label for="password">Slaptažodis</label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

    <br>
    <!-- Įterpkite reCAPTCHA kodą čia -->
    <button class="w-100 btn btn-lg btn-primary" type="submit">Prisijungti</button>
</form>
<p>Į pagrindinį puslapį &nbsp;<a href="/" class="btn btn-link">Home page</a>&nbsp;<p>
</div>
</div>
</div>

<?php require_once 'template/footer.php';?>

