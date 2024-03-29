<?php
session_start(); 
//session_unset(); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
$language_code = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';

$stage = isset($_SESSION['stage']) ? $_SESSION['stage'] : 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);
    $_SESSION['language'] = $selected_language;
    
    if (isset($_POST['admin_username']) && isset($_POST['admin_password'])) {
        $stage = 2;
        $prxConfig = require $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
        $prefix = $prxConfig['prefix'];

        $db_host = $_SESSION['db_host'];
        $db_name = $_SESSION['db_name'];
        $table_prefix = $_SESSION['table_prefix'];
        $db_user = $_SESSION['db_user'];
        $db_password = $_SESSION['db_password'];

        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password']; 
        $login_name = $_POST['login_name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];
        //$email = $_POST['email'];
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        // Check if email is valid
        if ($email === false) {
            $_SESSION['error_message'] = "Invalid email address provided.";
            header("Location: install-flusity.php?stage=2");
            exit;
        }
/*         $blacklist = ['word1', 'word2', 'word3', 'character1', 'character2'];
        foreach ($blacklist as $word) {
            if (strpos($admin_username, $word) !== false || strpos($email, $word) !== false) {
                $_SESSION['error_message'] = "Your username or email contains a forbidden word or character.";
                header("Location: install-flusity.php?stage=2");
                exit;
            }
        } */
        try {
            
            $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_password);
            $registrationSuccessful = registerUser($login_name, $admin_username, $admin_password, $surname, $phone, $email, $db, $prefix);
              
            if ($registrationSuccessful) {
                $_SESSION['success_message'] = "Admin successfully created!";
                $_SESSION['stage'] = 3;
              
                $stage = 3;
                $stmt = $db->prepare("UPDATE ".$table_prefix."_flussi_users SET role='admin' WHERE login_name=:login_name");
                $stmt->bindParam(':login_name', $login_name);
                $stmt->execute();
                session_unset();
            } else {
                $_SESSION['error_message'] = "Error creating administrator: User with such email. The email or login name already exists, or the name you selected is on the blacklist.";
                $_SESSION['stage'] = 2;
                //session_unset();
                header("Location: install-flusity.php?stage=2");
                exit;
            }

        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error creating admin: " . $e->getMessage();
            header("Location: install-flusity.php");
            exit;
        }
    } else {
        $db_host = filter_input(INPUT_POST, 'db_host', FILTER_SANITIZE_STRING);
        $db_name = filter_input(INPUT_POST, 'db_name', FILTER_SANITIZE_STRING);
        $db_user = filter_input(INPUT_POST, 'db_user', FILTER_SANITIZE_STRING);
        $db_password = filter_input(INPUT_POST, 'db_password', FILTER_SANITIZE_STRING);
        $table_prefix = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table_prefix']);


        $_SESSION['db_host'] = $db_host;
        $_SESSION['db_name'] = $db_name;
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_password'] = $db_password;
        $_SESSION['table_prefix'] = $table_prefix;

        try {
            $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_password);
            
            $_SESSION['success_message'] = "<p class='d-flex justify-content-center align-items-center'>Database and system configuration installation successful!</p> <p class='d-flex justify-content-center align-items-center'><b>Very important:&nbsp;</b> You can now create an admin user</p>";
            $_SESSION['alert-warning'] = "<p class='d-flex justify-content-center align-items-center'>
            You may not create an Admin user, then you will be able to log in with the <br>Login Name: Tester and the password: 1234 <br> for which you must change the password and other data after logging in.
            </p>";
            
            $directory = $_SERVER['DOCUMENT_ROOT'].'/core/tools/backups/'; 
        $files = scandir($directory); 

        $sql_files = array_filter($files, function($filename) {
            return pathinfo($filename, PATHINFO_EXTENSION) === 'sql'; 
        });

        $newest_file = '';
        $newest_file_time = 0;

        foreach ($sql_files as $file) {
            $file_time = filemtime($directory . $file);
            if ($file_time > $newest_file_time) {
                $newest_file = $file;
                $newest_file_time = $file_time;
            }
        }

        if ($newest_file !== '') {
            $newest_file_path = $directory . $newest_file;
            $sql = file_get_contents($newest_file_path); 

            $create_table_pattern = '/(CREATE TABLE\s+`?)(\w+)(`?)/i';
            $insert_into_pattern = '/(INSERT INTO\s+`?)(\w+)(`?)/i';
            $drop_table_pattern = '/(DROP TABLE IF EXISTS\s+`?)(\w+)(`?)/i';
            $foreignKeyPattern = '/(CONSTRAINT\s+`?)(\w+)(`\s+FOREIGN KEY \(`?\w+`?\) REFERENCES `?)(\w+)(`?)/i';

        $replacement = function ($matches) {
            $table_prefix = $_SESSION['table_prefix'];
            return $matches[1] . $table_prefix . '_' . $matches[2] . $matches[3];
        };

        $sql = preg_replace_callback($create_table_pattern, $replacement, $sql);

        $sql = preg_replace_callback($insert_into_pattern, $replacement, $sql);

        $sql = preg_replace_callback($drop_table_pattern, $replacement, $sql);

        $foreignKeyReplacement = function ($matches) {
            $table_prefix = $_SESSION['table_prefix'];
            return $matches[1] . $table_prefix . '_' . $matches[2] . $matches[3] . $table_prefix . '_' . $matches[4] . $matches[5];
        };

        $sql = preg_replace_callback($foreignKeyPattern, $foreignKeyReplacement, $sql);

        $db->exec($sql);
        try {
            $stmt = $db->prepare("UPDATE ".$table_prefix."_flussi_settings SET language=:language");
            $stmt->bindParam(':language', $selected_language);
            $stmt->execute();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error updating language in settings: " . $e->getMessage();
            header("Location: install-flusity.php");
            exit;
        }
            $stage = 2;
        } else {
            throw new Exception("No SQL files found in the directory");
        }

        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error connecting to database or importing data: " . $e->getMessage();
            header("Location: install-flusity.php");
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location: install-flusity.php");
            exit;
        }
    }

    if ($stage == 2) {
        $config_text = "<?php\n\n";
        $config_text .= "\$config = [\n";
        $config_text .= "  'db_host' => '{$db_host}',\n";
        $config_text .= "  'db_name' => '{$db_name}',\n";
        $config_text .= "  'db_user' => '{$db_user}',\n";
        $config_text .= "  'db_password' => '{$db_password}',\n";
        $config_text .= "  'encryption_key' => 'My_ENC_PaSSw_18534',\n";
        $config_text .= "];\n\n";
        
        $config_text .= "\$prefix = [\n";
        $config_text .= "  'table_prefix' => '{$table_prefix}',\n";
        $config_text .= "];\n";

        $config_text .= "return ['config' => \$config, 'prefix' => \$prefix];\n"; 
    
    
        $config_path = $_SERVER['DOCUMENT_ROOT'].'/security/config.php';
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
    <link href="<?php $_SERVER['DOCUMENT_ROOT'];?>/assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php $_SERVER['DOCUMENT_ROOT'];?>/assets/fonts/fonts-quicksand.css" rel="stylesheet">
    <link href="<?php $_SERVER['DOCUMENT_ROOT'];?>/assets/main/style.css" rel="stylesheet">
    <link href="<?php $_SERVER['DOCUMENT_ROOT'];?>/assets/main/site.css" rel="stylesheet"> 
    
<style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    .footer {
        margin-top: auto;
    }
    button.btn-close:hover {
    background-color: transparent;
    border: none;
    box-shadow:none;
    filter: brightness(0) saturate(100%) invert(38%) sepia(51%) saturate(2788%) hue-rotate(1deg) brightness(90%) contrast(88%);
    }

</style>
</head>

<body>
<div class="container d-flex justify-content-center align-items-center">
        <div class="row justify-content-center align-items-center">

        <div class="col-12 mb-3 mt-5">
        <img src="<?php $_SERVER['DOCUMENT_ROOT'];?>/core/tools/img/flusity-b.png" alt="Flusity logo">
        </div>
          <div class="col-10 mb-3 mt-1" style="margin-bottom: -50px;">
          
            <?php 
          if (isset($_SESSION['success_message'])) {
            echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
                    " . $_SESSION['success_message'];
                    if (isset($_SESSION['stage']) && $_SESSION['stage'] < 2) : ?>
                           <button type='button' class='btn-close install-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    <?php else : ?>
                   <?php endif;
            
            echo "</div>";
            unset($_SESSION['success_message']);
        }
         if (isset($_SESSION['alert-warning'])) {
                echo "<div class='alert alert-warning alert-dismissible fade show slow-fade'>
                        " . $_SESSION['alert-warning'] . "
                        <button type='button' class='btn-close install-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                unset($_SESSION['alert-warning']);
            }
            if (isset($_SESSION['alert-warning'])) {
                echo "<div class='alert alert-warning alert-dismissible fade show slow-fade'>
                        " . $_SESSION['alert-warning'] . "
                        <button type='button' class='btn-close install-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                unset($_SESSION['alert-warning']);
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
<div class="container">
    <div class="row justify-content-center align-items-center">
    <?php  if ($stage == 1): 
       // echo "Stage: $stage<br>";
        ?>
        <div class="col-4">
            <h1 class="mt-5 mb-3">Flusity CMS install</h1>
            <form action="install-flusity.php" method="post">
                <div class="mb-3">
                    <label for="language">Select the language of the page:</label>
                        <select id="language" name="language" class="form-control">
                        <option value="en">English</option>
                        <option value="lt">Lietuvių</option>
                        <option value="de">Deutsch</option>
                        <option value="it">Italiano</option>
                        <option value="fr">Français</option>
                        </select>
                </div>
                <div class="mb-3">
                    <label for="db_host" class="form-label">Database Host</label>
                    <input type="text" class="form-control" id="db_host" name="db_host" placeholder="localhost" required>
                </div>
                <div class="mb-3">
                    <label for="db_name" class="form-label">Database Name</label>
                    <input type="text" class="form-control" id="db_name" name="db_name" required>
                </div>
                <div class="mb-3">
                    <label for="table_prefix" class="form-label">Table prefix</label>
                    <input type="text" class="form-control" id="table_prefix" name="table_prefix" required>
                </div>
                <div class="mb-3">
                    <label for="db_user" class="form-label">Database User Name</label>
                    <input type="text" class="form-control" id="db_user" name="db_user" required>
                </div>
                <div class="mb-3">
                    <label for="db_password" class="form-label">Database Password</label>
                    <input type="password" class="form-control" id="db_password" name="db_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Install</button>
            </form>
        </div>
    <?php elseif ($stage == 2 && $language_code !=''): 
  
        ?>
        <div class="col-4">
            <h1 class="mt-5 mb-3"><?php echo t("Create Admin User");?></h1>
            <form action="install-flusity.php" method="post">
            <div class="mb-3">
                    <label for="login_name" class="form-label">Login Name</label>
                    <input type="text" class="form-control" id="login_name" name="login_name" required>
                </div>
                <div class="mb-3">
                    <label for="admin_username" class="form-label">Administrator Username</label>
                    <input type="text" class="form-control" id="admin_username" name="admin_username" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Surname</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>
                <div class="mb-3">
                    <label for="admin_password" class="form-label">Administrator Password</label>
                    <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Admin</button>
            </form>
        </div>
        <?php elseif ($stage == 3 ): ?>
<div class="col-4">
    <h1 class="mt-5 mb-3"><?php echo t("Admin Creation Successful");?></h1>
    <div class="alert alert-warning" role="alert">
 <p> <b><?php echo t("VERY IMPORTANT:");?></b>&nbsp;<?php echo t("Remember to be sure to delete or rename to a complex name from the FTP install folder, as this can be an easy way to damage your site!");?></p>
</div>
    <p>
        <?php echo t("Congratulations! You have successfully created an administrator account. You can now log in to the system using your administrator credentials.");?>
        <!-- Sveikiname! Sėkmingai sukūrėte administratoriaus paskyrą. Dabar galite prisijungti prie sistemos naudodamiesi administratoriaus prisijungimo duomenimis. 
    --> 
</p>
<a href="<?php echo getBaseUrl(); ?>/login.php" class="btn btn-primary">Prisijungti</a>

</div>
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
<script src="<?php $_SERVER['DOCUMENT_ROOT'];?>/assets/popperjs/popper.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT'];?>/assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>
