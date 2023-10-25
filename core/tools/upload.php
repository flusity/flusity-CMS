<?php 
/*  23-10-25 Update report:
 *   Session Management: The code initially checks to see if a PHP session is active, and if not, initializes it. This allows error and success messages to be safely stored.
 *   Configuration Load: Loads the necessary configuration and feature files.
 *   Database Connection: A connection to the database is opened and a security mechanism is applied.
 *   File Parameters: Defines allowed file types and maximum size.
 *   File Name Checking: If a file is uploaded, its name is cleaned and checked for illegal characters.
 *   File Upload: Executes the handleFileUpload function, which performs basic checks and, if everything is OK, uploads the file.
 *   Notifications: Success and error messages are written to the session and the user is redirected back to the file list page.
 *   Database Update: A unique code is generated for a successfully uploaded file and the information is stored in the database.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$target_dir = ROOT_PATH . "uploads/";

$allowed_file_types = ['image/png', 'image/jpeg', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
$max_file_size = 5 * 1024 * 1024;

if (isset($_FILES['uploaded_file'])) {
    $filename = $_FILES['uploaded_file']['name'];
    $filename_clean = preg_replace("/[^a-zA-Z0-9\._]+/", "", $filename);

    if ($filename !== $filename_clean) {
        $_SESSION['error_message'] = t("Invalid characters in file name.");
        header("Location: files.php");
        exit();
    }

    $file_id = handleFileUpload($db, $prefix['table_prefix'], $target_dir, $allowed_file_types, $max_file_size, $filename_clean); 

    if ($file_id !== false) {
        $_SESSION['success_message'] = t("The file has been uploaded successfully.");
        header("Location: files.php");
        exit();
    } else {
       // The error will be assigned in the handleFileUpload function
        header("Location: files.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = t("No file uploaded.");
    header("Location: files.php");
    exit();
}

?>
