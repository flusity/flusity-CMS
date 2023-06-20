<?php

function getAllCustomBlocks($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_v_custom_blocks');
    $stmt->execute();
    return $stmt->fetchAll();
}

function createCustomBlock($db, $prefix, $name, $menu_id, $place_id, $html_code) {
    $stmt = $db->prepare('INSERT INTO '.$prefix['table_prefix'].'_flussi_v_custom_blocks (name, menu_id, place_id, html_code) VALUES (:name, :menu_id, :place_id, :html_code)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':place_id', $place_id, PDO::PARAM_INT);
    $stmt->bindParam(':html_code', $html_code, PDO::PARAM_STR);
    return $stmt->execute();
}
    function deleteCustomBlock($db, $prefix, $id) {
    $stmt = $db->prepare('DELETE FROM '.$prefix['table_prefix'].'_flussi_v_custom_blocks WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
function updateCustomBlock($db, $prefix, $id, $name, $menu_id, $place_id, $html_code) {
    $stmt = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_v_custom_blocks SET name = :name, menu_id = :menu_id, place_id = :place_id, html_code = :html_code WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':place_id', $place_id, PDO::PARAM_INT);
    $stmt->bindParam(':html_code', $html_code, PDO::PARAM_STR);
    return $stmt->execute();
}

function getCustomBlocks($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_v_custom_blocks');
    $stmt->execute();
    return $stmt->fetchAll();
}
function getCustomBlockById($db, $prefix, $customBlockId) {
    $query = 'SELECT * FROM '.$prefix['table_prefix'].'_flussi_v_custom_blocks WHERE id = :customBlockId';
    $statement = $db->prepare($query);
    $statement->bindParam(':customBlockId', $customBlockId, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}