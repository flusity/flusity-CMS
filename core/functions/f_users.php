<?php
/////////////// user ////////////////
    function checkUserRole($userId, $role, $db, $prefix) {
        $stmt = $db->prepare('SELECT role FROM '.$prefix['table_prefix'].'_flussi_users WHERE id = :user_id');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['role'] === $role;
    }

        
    function checkIfAdmin() {
        
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            return true;
        } else {
            return false;
        }
    }

    function countAdmins($db, $prefix) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM ".$prefix['table_prefix']."_flussi_users WHERE role = 'admin'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getUserNameById($db, $prefix, $user_id) {
        $stmt = $db->prepare("SELECT username FROM ".$prefix['table_prefix']."_flussi_users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    function validateInput($input) {
        return trim(strip_tags(htmlspecialchars(stripslashes($input))));
    }
    
     function secureSession($db, $prefix) {
        global $prefix; 
    
        $base_url = getBaseUrl();
        // Setting secure session parameters
        $session_name = 'secure_session';
        $secure = true;
        $httponly = true;
    
        $settings = getSettings($db, $prefix);
        $session = $settings['session_lifetime'] * 60;
        $inactive = isset($session) ? $session : 1000;
    
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', 1);
            ini_set('session.use_strict_mode', 1);
            $cookieParams = session_get_cookie_params();
            session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $secure, $httponly);
            session_name($session_name);
        }
    
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive)) {
            
            $requested_url = $_SERVER['REQUEST_URI'];
            
            session_unset();
            session_destroy();
            session_start();  
    
            $_SESSION['requested_url'] = $requested_url;
    
            if (isset($requested_url)) {
                header("Location: " . $base_url . $requested_url);
                exit;
            } else {
                $redirect_home = $base_url . "/index.php"; 
                header("Location: " . $redirect_home);
                exit;
            }
        }
    
        $_SESSION['last_activity'] = time();
    }
    
    

    function authenticateUser($login_nameOrEmail, $password, $prefix) {
        global $config;
    
        $db = getDBConnection($config);
        $stmt = $db->prepare('SELECT id, password, role FROM '.$prefix['table_prefix'].'_flussi_users WHERE login_name = :login_name OR email = :email');
        $stmt->bindValue(':login_name', $login_nameOrEmail, PDO::PARAM_STR);
        $stmt->bindValue(':email', $login_nameOrEmail, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        return false;
    }
    
    
    function registerUser($login_name, $username, $password, $surname, $phone, $email, $db, $prefix) {
        $banned_words = [
            'admin', 'admina', 'adminai', 'adminas', 'admin1', 'admin2', 'admin3', 'aadmin', 'adminn', 'admi', 
            'administrator', 'administratorius','administruojantis',
            'root', 
            'master',
            'bos','bosas','boss',
            'superuser', 'supermaster','superadmin','superadministrator','supermoderator','superbos'
        ];
    
        foreach($banned_words as $word) {
            if (strpos(strtolower($login_name), $word) !== false || 
                strpos(strtolower($username), $word) !== false || 
                strpos(strtolower($email), $word) !== false) {
                
                return false;
            }
        }
    
       // $hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 1<<17, 'time_cost' => 4, 'threads' => 2]);
       $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("SELECT COUNT(*) FROM ".$prefix['table_prefix']."_flussi_users WHERE email = :email OR login_name = :login_name");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':login_name', $login_name);
        $stmt->execute();
        $exists = $stmt->fetchColumn() > 0;
    
        if ($exists) {
            return false;
        }
    
        $stmt = $db->prepare("INSERT INTO ".$prefix['table_prefix']."_flussi_users (login_name, username, password, surname, phone, email) VALUES (:login_name, :username, :password, :surname, :phone, :email)");
        $stmt->bindParam(':login_name', $login_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
    
    function handleRegister($db, $prefix, $post) {
        $csrf_token = validateInput($post['csrf_token']);
        if (!validateCSRFToken($csrf_token)) {
            return t("Invalid CSRF token. Try again.");
        } else {
            $login_name = validateInput($post['login_name']);
            $username = validateInput($post['username']);
            $password = validateInput($post['password']);
            $confirm_password = validateInput($post['confirm_password']);
            $surname = validateInput($post['surname']);
            $phone = validateInput($post['phone']);
            $email = validateInput($post['email']);

            if ($password === $confirm_password) {
                if (isUsernameTaken($username, $db, $prefix) || isLoginNameTaken($login_name, $db, $prefix)) {
                    return t("That Name or Login Name is already taken. Choose another.");
                } else {
                    if (registerUser($login_name, $username, $password, $surname, $phone, $email, $db, $prefix)) {
                        $_SESSION['success_message'] = t("User registration successful. You can now log in.");
                        header('Location: login.php');
                        exit();
                    } else {
                        return t("User registration failed. Try again.");
                    }
                }
            } else {
                return t("Passwords do not match. Try again.");
            }
        }
    }
    
    function isLoginNameTaken($login_name, $db, $prefix) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM ".$prefix['table_prefix']."_flussi_users WHERE login_name = :login_name");
        $stmt->bindParam(':login_name', $login_name, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    function isUsernameTaken($username, $db, $prefix) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM ".$prefix['table_prefix']."_flussi_users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    
    function getAllUsers($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM  '.$prefix['table_prefix'].'_flussi_users');
    $stmt->execute();
    return $stmt->fetchAll();
}

    function updateUser($db, $prefix, $id, $login_name, $username, $surname, $phone, $email, $role, $password = null) {
        $sql = "UPDATE ".$prefix['table_prefix']."_flussi_users SET login_name = :login_name, username = :username, surname = :surname, phone = :phone, email = :email, role = :role";

        if ($password !== null) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE id = :id";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':login_name', $login_name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        if ($password !== null) {
        // $hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 1<<17, 'time_cost' => 4, 'threads' => 2]);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    function getUserById($db, $prefix, $id) {
        $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }


    function deleteUser($db, $prefix, $id) {
        $stmt = $db->prepare('SELECT role FROM '.$prefix['table_prefix'].'_flussi_users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $role = $stmt->fetchColumn();

        if ($role === 'admin' && countAdmins($db, $prefix) <= 1) {
            return false;
        } else {
            $stmt = $db->prepare('DELETE FROM '.$prefix['table_prefix'].'_flussi_users WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
