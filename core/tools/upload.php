<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

secureSession();
$db = getDBConnection($config);

$target_dir = ROOT_PATH . "uploads/";

$uploaded_file = $_FILES["uploaded_file"];

// Allowed file types
$allowed_file_types = ['image/png', 'image/jpeg', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
// Maximum file size (5MB)
$max_file_size = 5 * 1024 * 1024;

if (!in_array($uploaded_file['type'], $allowed_file_types)) {
    $_SESSION['error_message'] = t("Invalid file type.");
    header("Location: files.php");
    exit();
}

if ($uploaded_file['size'] > $max_file_size) {
    $_SESSION['error_message'] = t("File size exceeded limit.");
    header("Location: files.php");
    exit();
}

$unique_code = bin2hex(random_bytes(8));

// Merged name, code and file extension
$filename_parts = pathinfo($uploaded_file["name"]);
$new_filename = $filename_parts['filename'] . '_' . $unique_code . '.' . $filename_parts['extension'];

$target_file = $target_dir . basename($new_filename);

if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {//
    $file_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $new_filename;
    
    $_SESSION['success_message'] = "File" ." ". basename($uploaded_file["name"]) . " " .t("file uploaded successfully.");
    saveFileToDatabase($db, $new_filename, $file_url);
} else {
    $_SESSION['error_message'] = t("Error loading file.");
}

header("Location: files.php");
exit();
?>
