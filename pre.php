<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$configurations = require 'security/config.php';
require_once 'core/functions/functions.php';
$config = $configurations['config'];
$prefix = $configurations['prefix'];

require_once 'core/functions/functions.php';

if (isset($config['display_errors']) && $config['display_errors']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (
    empty($config['db_host']) ||
    empty($config['db_user']) ||
    empty($config['db_password']) ||
    empty($config['db_name']) 
) {
    header("Location: install/install-flusity.php");
    exit;
}

try {
    $db = getDBConnection($config);
} catch (PDOException $e) {
    error_log('Database connection error: ' . $e->getMessage());
    header("Location: install/install-flusity.php");
    exit;
}
