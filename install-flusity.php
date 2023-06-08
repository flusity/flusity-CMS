<?php 
//session_unset(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
require_once 'core/functions/functions.php';
$stage = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['admin_username']) && isset($_POST['admin_password'])) {
        $stage = 2;

        $db_host = $_SESSION['db_host'];
        $db_name = $_SESSION['db_name'];
        $db_user = $_SESSION['db_user'];
        $db_password = $_SESSION['db_password'];
        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password']; 
        $login_name = $_POST['login_name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        try {
            $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_password);
            $registrationSuccessful = registerUser($login_name, $admin_username, $admin_password, $surname, $phone, $email, $db);
            
            if ($registrationSuccessful) {
                $_SESSION['success_message'] = "Admin successfully created!";
                $_SESSION['stage'] = 3;
                $stmt = $db->prepare("UPDATE users SET role='admin' WHERE login_name=:login_name");
                $stmt->bindParam(':login_name', $login_name);
                $stmt->execute();
                
            } else {
                $_SESSION['error_message'] = "Error creating administrator: User with such email. The email or login name already exists, or the name you selected is on the blacklist.";
                header("Location: install-flusity.php");
                exit;
            }

        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error creating admin: " . $e->getMessage();
            header("Location: install-flusity.php");
            exit;
        }
    } else {
        $db_host = $_POST['db_host'];
        $db_name = $_POST['db_name'];
        $db_user = $_POST['db_user'];
        $db_password = $_POST['db_password'];

        $_SESSION['db_host'] = $db_host;
        $_SESSION['db_name'] = $db_name;
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_password'] = $db_password;

        try {
            $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_password);

            $_SESSION['success_message'] = "Database and system configuration installation successful!";

            try {
                $sql = file_get_contents('install/db.sql');
                $db->exec($sql);

                $stage = 2;
            } catch(PDOException $e) {
                $_SESSION['error_message'] = "Error importing data: " . $e->getMessage();
                header("Location: install-flusity.php");
                exit;
            }

        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error connecting to database: " . $e->getMessage();
            header("Location: install-flusity.php");
            exit;
        }
    }
    if ($stage == 2) {
        $language_code = isset($_POST['language']) ? $_POST['language'] : 'en';
        $config_text = "<?php\n\n\$config = [\n";
        $config_text .= "  'db_host' => '{$db_host}',\n";
        $config_text .= "  'db_name' => '{$db_name}',\n";
        $config_text .= "  'db_user' => '{$db_user}',\n";
        $config_text .= "  'db_password' => '{$db_password}',\n";
        $config_text .= "];\n";
        $config_text .= "\$language_code = '{$language_code}';\n\n?>";
    
        $config_path = __DIR__ . '/security/config.php';
        if (is_writable(dirname($config_path))) {
            file_put_contents($config_path, $config_text);
        } else {
            echo "Cannot write to directory.";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flusity CMS install</title>
    <link href="assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/fonts/fonts-quicksand.css" rel="stylesheet">
    <link href="assets/main/style.css" rel="stylesheet">
    <link href="assets/main/site.css" rel="stylesheet"> 
    
<style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    .footer {
        margin-top: auto;
    }

</style>
</head>

<body>
<div class="container  d-flex justify-content-center align-items-center">
        <div class="row">

        <div class="col-12 mb-3 mt-5">
        <img src="/core/tools/img/flusity-b.png" alt="Flusity logo">
        </div>
          <div class="col-10 mb-3 mt-1" style="margin-bottom: -50px;">
          
            <?php 
          if (isset($_SESSION['success_message'])) {
            echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
                    " . $_SESSION['success_message'];
            
            if (isset($_SESSION['stage']) && $_SESSION['stage'] == 3) { // tikriname, ar esame 3 etape
                echo "<br>
                      <a href='login.php'>Click here to log in</a>";
            } else {
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            }
            
            echo "</div>";
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
<div class="container d-flex justify-content-center align-items-center">
    <div class="row">
    <?php  if ($stage == 1):?>
        <div class="col-9 d-flex">
        <h1 class="mt-5 mb-3">Flusity CMS install</h1>
        </div>
        
            <form action="install-flusity.php" method="post">
            <div class="col-9 mb-3">
                <label for="language">Select the language of the page:</label>
                    <select id="language" name="language">
                        <option value="en" selected="selected">English</option>
                        <option value="lt">Lietuvių</option>
                    </select>
                </div>
            <div class="col-9">
                <div class="mb-3">
                    <label for="db_host" class="form-label">Database Host</label>
                    <input type="text" class="form-control" id="db_host" name="db_host" placeholder="localhost" required>
                </div>
                <div class="mb-3">
                    <label for="db_name" class="form-label">Database Name</label>
                    <input type="text" class="form-control" id="db_name" name="db_name" required>
                </div>
                <div class="mb-3">
                    <label for="db_user" class="form-label">Database User Name</label>
                    <input type="text" class="form-control" id="db_user" name="db_user" required>
                </div>
                <div class="mb-3">
                    <label for="db_password" class="form-label">Database Password</label>
                    <input type="password" class="form-control" id="db_password" name="db_password" required>
                </div>
                </div>
                <button type="submit" class="btn btn-primary w-75">Install</button>
            </form>
        
    <?php elseif ($stage == 2 && (!isset($_SESSION['stage']) || (isset($_SESSION['stage']) && $_SESSION['stage'] < 3))): ?>

        <div class="col-9 d-flex">
        <h1 class="mt-5 mb-3">Create Admin User</h1>
        </div>
       
        <form action="install-flusity.php" method="post">
            <div class="col-9 mb-3">
                <label for="admin_username" class="form-label">Administrator Username</label>
                <input type="text" class="form-control" id="admin_username" name="admin_username" required>
            </div>
            <div class="col-9 mb-3">
                <label for="admin_password" class="form-label">Administrator Password</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>
            <div class="col-9 mb-3">
                <label for="login_name" class="form-label">Login Name</label>
                <input type="text" class="form-control" id="login_name" name="login_name" required>
            </div>
            <div class="col-9 mb-3">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>
            <div class="col-9 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="col-9 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-75">Create Admin</button>
        </form>
    <?php endif; ?>
    </div>
    </div>
<footer class="footer bg-light py-3">
    <div class="container-fluid">
    <p class="text-center mb-0">
        flusity
    </p>
    </div>
</footer>
<script src="assets/popperjs/popper.min.js"></script>
<script src="assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>
