<?php if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

secureSession($db, $prefix);


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
?>
