<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

$db = getDBConnection($config);
secureSession($db);
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);
$db = getDBConnection($config);
$index = isset($_GET['index']) ? $_GET['index'] : 0;
$files = getFilesListFromDatabase($db);
$slicedFiles = array_slice($files, $index, 9);

$counter = 0;
foreach ($slicedFiles as $file) {
    if ($counter % 3 == 0) {
        echo '<div class="row">';
    }

    echo '<div class="col-md-4 mt-1 border border-dark-subtle image-container overlay">';
    echo '<img class="img-fluid" name="brand_icone" src="' . $file['url'] . '" alt="' . $file['name'] . '" />';
    echo '<input type="radio" class="radio" id="brand_icone_id" name="brand_icone_id" value="' . $file['id'] . '" />';
    echo '</div>';

    if ($counter % 3 == 2) {
        echo '</div>';
    }

    $counter++;
}

if ($counter % 3 != 0) {
    echo '</div>';
}
?>
