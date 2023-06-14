<?php
/////////////// user ////////////////
function checkUserRole($userId, $role, $db) {
    $stmt = $db->prepare('SELECT role FROM users WHERE id = :user_id');
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result && $result['role'] === $role;
}
function getUserNameById($db, $user_id) {
    $stmt = $db->prepare("SELECT username FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchColumn();
}
    
    function validateInput($input) {
        return trim(strip_tags(htmlspecialchars(stripslashes($input))));
    }
    
    function secureSession($db) {
       
        $base_url = getBaseUrl();
        // Nustatomi saugųs sesijos parametrai
        $session_name = 'secure_session';
        $secure = true;
        $httponly = true;
    
        $settings = getSettings($db);
        $session=$settings['session_lifetime']*60;
        $inactive = isset($session) ? $session : 1000;  // Gauna parametrą iš settings sql db jei nustatyta 
        
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
            
            if (isset($_SESSION['user_id'])) { 
                session_unset();
                session_destroy();
                
                $redirect_login = $base_url . "/login.php";
                header("Location: " . $redirect_login);
                exit;
             
            } else {
                session_unset();
                session_destroy();
                
                $redirect_404 = $base_url . "/404.php";
                header("Location: " . $redirect_404);
                exit;
                
            }
        }
        $_SESSION['last_activity'] = time();
    }
    
    
    function authenticateUser($login_nameOrEmail, $password) {
        global $config;
    
        $db = getDBConnection($config);
        $stmt = $db->prepare('SELECT id, password, role FROM users WHERE login_name = :login_name OR email = :email');
        $stmt->bindValue(':login_name', $login_nameOrEmail, PDO::PARAM_STR);
        $stmt->bindValue(':email', $login_nameOrEmail, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        return false;
    }
    
    
    function registerUser($login_name, $username, $password, $surname, $phone, $email, $db) {
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
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR login_name = :login_name");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':login_name', $login_name);
        $stmt->execute();
        $exists = $stmt->fetchColumn() > 0;
    
        if ($exists) {
            return false;
        }
    
        $stmt = $db->prepare("INSERT INTO users (login_name, username, password, surname, phone, email) VALUES (:login_name, :username, :password, :surname, :phone, :email)");
        $stmt->bindParam(':login_name', $login_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
    
    
    function isLoginNameTaken($login_name, $db) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE login_name = :login_name");
        $stmt->bindParam(':login_name', $login_name, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    function isUsernameTaken($username, $db) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    
    function getAllUsers($db) {
    $stmt = $db->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll();
}
function updateUser($db, $id, $username, $surname, $phone, $email, $role, $password = null) {
    $sql = "UPDATE users SET username = :username, surname = :surname, phone = :phone, email = :email, role = :role";

    if ($password !== null) {
        $sql .= ", password = :password";
    }

    $sql .= " WHERE id = :id";

    $stmt = $db->prepare($sql);

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

function getUserById($db, $id) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function countAdmins($db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function deleteUser($db, $id) {
    $stmt = $db->prepare('SELECT role FROM users WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $role = $stmt->fetchColumn();

    if ($role === 'admin' && countAdmins($db) <= 1) {
        return false;
    } else {
        $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
