<?php header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
session_start();
require_once 'security/config.php';
require_once 'core/functions/functions.php';
secureSession();
$db = getDBConnection($config);

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
                $error_message = 'Vartotojo vardas jau užimtas. Pasirinkite kitą.';
            } else {
                if (registerUser($username, $password, $surname, $phone, $email, $db)) {
                    header('Location: login.php');
                    exit();
                } else {
                    $error_message = 'Vartotojo registracija nepavyko. Bandykite dar kartą.';
                }
            }
        } else {
            $error_message = 'Slaptažodžiai nesutampa. Bandykite dar kartą.';
        }
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
        <h2>Registracijos sistema</h2>
        <p>Turinio valdymo sistema skirta asmeninėms svetainėms</p>
        <?php require_once 'assets/logo.php'?> 
    </div>
        <div class="col-sm-4">
<h1 class="h3 mb-3 fw-normal">Registracija</h1>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>
<form method="POST" action="">
    <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="Vartotojo vardas" required>
        <label for="username">Vartotojo vardas</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="text" class="form-control" id="surname" name="surname" placeholder="Pavardė" required>
        <label for="surname">Pavardė</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono numeris" required>
        <label for="phone">Telefono numeris</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="El. paštas" required>
        <label for="email">El. paštas</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Slaptažodis" required>
        <label for="password">Slaptažodis</label>
    </div>
    <br>
    <div class="form-floating">
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Pakartokite slaptažodį" required>
        <label for="confirm_password">Pakartokite slaptažodį</label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Registruotis</button>
</form>
</div>
</div>
</div>
   <?php require_once 'core/template/admin-footer.php';?>

