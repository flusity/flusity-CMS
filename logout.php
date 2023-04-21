<?php header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");

session_start();

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
