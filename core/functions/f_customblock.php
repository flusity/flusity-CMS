<?php

function getAllCustomBlocks($db, $prefix, $start, $limit) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_v_custom_blocks'.' LIMIT :start, :limit');
 
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function createCustomBlock($db, $prefix, $name, $menu_id, $place_id, $html_code, $lang_custom_name, $lang_custom_content) {
    $stmt = $db->prepare('INSERT INTO '.$prefix['table_prefix'].'_flussi_v_custom_blocks (name, menu_id, place_id, html_code, lang_custom_name, lang_custom_content) VALUES (:name, :menu_id, :place_id, :html_code, :lang_custom_name, :lang_custom_content)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':place_id', $place_id, PDO::PARAM_INT);
    $stmt->bindParam(':html_code', $html_code, PDO::PARAM_STR);
    $stmt->bindParam(':lang_custom_name', $lang_custom_name, PDO::PARAM_STR);
    $stmt->bindParam(':lang_custom_content', $lang_custom_content, PDO::PARAM_STR);
    return $stmt->execute();
}
    function deleteCustomBlock($db, $prefix, $id) {
    $stmt = $db->prepare('DELETE FROM '.$prefix['table_prefix'].'_flussi_v_custom_blocks WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
function updateCustomBlock($db, $prefix, $id, $name, $menu_id, $place_id, $html_code, $lang_custom_name, $lang_custom_content) {
    $stmt = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_v_custom_blocks SET name = :name, menu_id = :menu_id, place_id = :place_id, html_code = :html_code, lang_custom_name = :lang_custom_name, lang_custom_content = :lang_custom_content WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':place_id', $place_id, PDO::PARAM_INT);
    $stmt->bindParam(':html_code', $html_code, PDO::PARAM_STR);
    $stmt->bindParam(':lang_custom_name', $lang_custom_name, PDO::PARAM_STR);
    $stmt->bindParam(':lang_custom_content', $lang_custom_content, PDO::PARAM_STR);
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

function getCustomBlocksByUrlNameAndPlace($db, $prefix, $page_url, $place_name, $lang) {
   
    $nameField = 'name';
    $contentField = 'html_code';

    if ($lang == 'en') {
        $nameField = 'IF('.$prefix['table_prefix'].'_flussi_v_custom_blocks.lang_custom_name != "", '.$prefix['table_prefix'].'_flussi_v_custom_blocks.lang_custom_name, '.$prefix['table_prefix'].'_flussi_v_custom_blocks.name)';
        $contentField = 'IF('.$prefix['table_prefix'].'_flussi_v_custom_blocks.lang_custom_content != "", '.$prefix['table_prefix'].'_flussi_v_custom_blocks.lang_custom_content, '.$prefix['table_prefix'].'_flussi_v_custom_blocks.html_code)';
    } else {
        $nameField = $prefix['table_prefix'].'_flussi_v_custom_blocks.name';
        $contentField = $prefix['table_prefix'].'_flussi_v_custom_blocks.html_code';
    }
    
    $stmt = $db->prepare("
    SELECT 
        ".$prefix['table_prefix']."_flussi_v_custom_blocks.id, 
        ".$nameField." AS dynamic_name,
        ".$contentField." AS dynamic_content,
        ".$prefix['table_prefix']."_flussi_v_custom_blocks.menu_id, 
        ".$prefix['table_prefix']."_flussi_v_custom_blocks.place_id,
        ".$prefix['table_prefix']."_flussi_v_custom_blocks.updated 
        FROM ".$prefix['table_prefix']."_flussi_v_custom_blocks 
        LEFT JOIN ".$prefix['table_prefix']."_flussi_menu ON ".$prefix['table_prefix']."_flussi_v_custom_blocks.menu_id = ".$prefix['table_prefix']."_flussi_menu.id 
        JOIN ".$prefix['table_prefix']."_flussi_places ON ".$prefix['table_prefix']."_flussi_v_custom_blocks.place_id = ".$prefix['table_prefix']."_flussi_places.id 
        WHERE (".$prefix['table_prefix']."_flussi_menu.page_url = :page_url OR ".$prefix['table_prefix']."_flussi_v_custom_blocks.menu_id = 0) 
        AND ".$prefix['table_prefix']."_flussi_places.name = :place_name
        ORDER BY ".$prefix['table_prefix']."_flussi_v_custom_blocks.updated DESC
");

    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':place_name', $place_name, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();

}

