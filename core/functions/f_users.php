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
    
    function secureSession() {
        // Nustatomi saugųs sesijos parametrai
        $session_name = 'secure_session';
        $secure = true;
        $httponly = true;
        $inactive = 1200; //20| 15 minučių - 900
    
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', 1);
            ini_set('session.use_strict_mode', 1);
            $cookieParams = session_get_cookie_params();
            session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $secure, $httponly);
            session_name($session_name);
        }
    
        // Pradedama ar tęsiama sesija
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        // Tikrinama, ar buvo perduotas veiksmas, ir atnaujiname sesija
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive)) {
            // Sesija nebegalioja
            if (isset($_SESSION['user_id'])) { // Tikriname, ar naudotojas buvo prisijungęs
                session_unset();
                session_destroy();
                header("Location: ../../login.php");
                exit;
            } else {
                session_unset();
                session_destroy();
                header("Location: ../../404.php"); // Nukreipiame į 404 puslapį
                exit;
            }
    }

    
        // Atnaujiname sesijos laiką
        $_SESSION['last_activity'] = time();
    }
    
    function authenticateUser($usernameOrEmail, $password) {
        global $config;
    
        $db = getDBConnection($config);
        $stmt = $db->prepare('SELECT id, password, role FROM users WHERE username = :username OR email = :email');
        $stmt->bindValue(':username', $usernameOrEmail, PDO::PARAM_STR);
        $stmt->bindValue(':email', $usernameOrEmail, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        return false;
    }
    
    
    

    function registerUser($username, $password, $surname, $phone, $email, $db) {
        $hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 1<<17, 'time_cost' => 4, 'threads' => 2]);
    
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn() > 0;
    
        if ($emailExists) {
            return false;
        }
    
        $stmt = $db->prepare("INSERT INTO users (username, password, surname, phone, email) VALUES (:username, :password, :surname, :phone, :email)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
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
        $hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 1<<17, 'time_cost' => 4, 'threads' => 2]);
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

function deleteUser($db, $id) {
    $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}