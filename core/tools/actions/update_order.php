<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

error_log(print_r($_POST, true));

if (isset($_POST['singleMovedBlock'])) {
    $singleMovedBlock = $_POST['singleMovedBlock'];
    $blockId = $singleMovedBlock['blockId'];
    $placeId = isset($singleMovedBlock['newPlaceId']) ? $singleMovedBlock['newPlaceId'] : null;
    $addonName = isset($singleMovedBlock['addonName']) ? $singleMovedBlock['addonName'] : null;
    $updatedTime = date("Y-m-d H:i:s");

    $tableName = '';
    if ($addonName) {
        $tableName = $prefix['table_prefix'] . "_" . $addonName;
    } else {
        $tableName = $prefix['table_prefix'] . "_flussi_v_custom_blocks";
    }

     $query = "UPDATE $tableName SET updated = :updatedTime";
    
    if ($placeId !== null) {
        $query .= ", place_id = :placeId";
    }
    
    $query .= " WHERE id = :blockId";

    $stmt = $db->prepare($query);
    $params = ['updatedTime' => $updatedTime, 'blockId' => $blockId];

    if ($placeId !== null) {
        $params['placeId'] = $placeId;
    }

    if ($stmt->execute($params)) {
        echo json_encode(["message" => "Block updated"]);
    } else {
        error_log(print_r($stmt->errorInfo(), true));
        echo json_encode(["message" => "Failed to update block"]);
    }
} else {
    echo json_encode(["message" => "Invalid or missing parameters"]);
}

?>
