<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';


// Duomenų gavimas iš duomenų bazės
 $db = getDBConnection($config);
secureSession($db, $prefix);
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$result = ['success' => false];

if (isset($_POST['user_id'], $_POST['login_name'], $_POST['user_username'], $_POST['user_surname'], $_POST['user_phone'], $_POST['user_email'], $_POST['user_role'])) {
    $userId = (int)$_POST['user_id'];
    $login_name = $_POST['login_name'];
    $username = $_POST['user_username'];
    $surname = $_POST['user_surname'];
    $phone = $_POST['user_phone'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];

    // Patikrinti ar username yra unikalus
    $stmt = $db->prepare("SELECT COUNT(*) FROM ".$prefix['table_prefix']."_flussi_users WHERE  username = :username AND id != :id");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $usernameExists = $stmt->fetchColumn() > 0;

    if ($usernameExists) {
        $_SESSION['error_message'] = t('Username is already taken. Try a different one.');
        echo json_encode($result);
        exit;
    }

    $password = isset($_POST['user_password']) ? $_POST['user_password'] : null;
    $confirm_password = isset($_POST['user_confirm_password']) ? $_POST['user_confirm_password'] : null;

    if (($password || $confirm_password) && $password !== $confirm_password) {
        $_SESSION['error_message'] = t('The passwords do not match. Try again.');
        echo json_encode($result);
        exit;
    }

    $updated = updateUser($db, $prefix, $userId, $login_name, $username, $surname, $phone, $email, $role, $password); 

    if ($updated) {
        $_SESSION['success_message'] = t('User successfully updated.');
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = t('Error updating user. Try again.');
    }
}

echo json_encode($result);
exit;
