<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);


$result = ['success' => false];

if (isset($_POST['user_id'], $_POST['user_username'], $_POST['user_surname'], $_POST['user_phone'], $_POST['user_email'], $_POST['user_role'])) {
    $userId = (int)$_POST['user_id'];
    $username = $_POST['user_username'];
    $surname = $_POST['user_surname'];
    $phone = $_POST['user_phone'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];

    $updated = updateUser($db, $userId, $username, $surname, $phone, $email, $role);

    if ($updated) {
        $_SESSION['success_message'] = 'Vartotojas sėkmingai atnaujintas.';
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = 'Klaida atnaujinant vartotoją. Bandykite dar kartą.';
    }
}

echo json_encode($result);
exit;
?>
