<?php require_once 'core/functions/functions.php';
$baseUrl = getBaseUrl();
list($db, $config, $prefix) = initializeSystem();
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$db = getDBConnection($config);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

// Naikinami visi sesijos kintamieji
$_SESSION = array();

// Naikinami sesijos sausainis (cookie)
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
// Regeneruojamas sesijos ID
session_regenerate_id(true);
// Sunaikinama sesija
session_destroy();

// Nukreipiamas vartotojas į pradinį puslapį
header("Location: /");
exit;
?>
