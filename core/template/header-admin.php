<?php 
session_start();
define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);
    $translations = getTranslations($db, $language_code);
} else {
    header("Location: 404.php");
    exit;
}

// Tikriname, ar vartotojas yra adminas ar moderatorius
if (!checkUserRole($user_id, 'admin', $db) && !checkUserRole($user_id, 'moderator', $db)) {
    header("Location: 404.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
     <link href="/assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="/assets/font-awesome/6.1.0/css/all.min.css"> <script src="/assets/dist/js/jquery-3.6.0.min.js"></script>
      <script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/js/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/css/admin-style.css" rel="stylesheet">
    <script src="/assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
     @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

body {
  font-family: 'Roboto', sans-serif;

}
        
.btn-primary {
  background-color: #27ae60;
  border-color: #27ae60;
}

.btn-primary:hover {
  background-color: #16a085;
  border-color: #16a085;
}

.btn-primary:focus {
  background-color: #16a085;
  border-color: #16a085;
  box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.5);
}

.btn-primary:active {
  background-color: #1abc9c;
  border-color: #1abc9c;
}

.btn-primary:active:focus {
  background-color: #1abc9c;
  border-color: #1abc9c;
  box-shadow: 0 0 0 0.2rem rgba(26, 188, 156, 0.5);
}

@keyframes neon-glow {
  0% {
    text-shadow: 0 0 10px #27ae60, 0 0 20px #27ae60, 0 0 30px #27ae60, 0 0 40px #27ae60, 0 0 70px #27ae60, 0 0 80px #27ae60, 0 0 100px #27ae60;
  }

  100% {
    text-shadow: 0 0 5px #27ae60, 0 0 10px #27ae60, 0 0 15px #27ae60, 0 0 20px #27ae60, 0 0 35px #27ae60, 0 0 40px #27ae60, 0 0 50px #27ae60;
  }
}

.neon {
  animation: neon-glow 1s ease-in-out infinite alternate;
}
.input-wrapper {
        position: relative;
        display: inline-block;
    }

    .clear-button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        display: none;
    }
    </style>
</head>
<body>
