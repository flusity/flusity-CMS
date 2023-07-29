<?php
// Meniu
function deleteMenuItem($db, $prefix, $id) {
    $stmt = $db->prepare('DELETE FROM '.$prefix['table_prefix'].'_flussi_menu WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getMenuItems($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_menu ORDER BY position');
    $stmt->execute();
    return $stmt->fetchAll();
}
function getSubMenuItems($db, $prefix, $parentId) {
    $stmt = $db->prepare('SELECT * FROM ' . $prefix['table_prefix'] . '_flussi_menu WHERE parent_id = ? ORDER BY position');
    $stmt->execute([$parentId]);
    return $stmt->fetchAll();
}
function getParentMenuItems($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_menu WHERE parent_id IS NULL OR parent_id = 0 ORDER BY position');
    $stmt->execute();
    return $stmt->fetchAll();
}

function createMenuItem($db, $prefix, $name, $page_url, $position, $template, $show_in_menu, $parent_id) {
    $stmt = $db->prepare('INSERT INTO '.$prefix['table_prefix'].'_flussi_menu (name, page_url, position, template, show_in_menu, parent_id) VALUES (:name, :page_url, :position, :template, :show_in_menu, :parent_id)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_INT);
    $stmt->bindParam(':template', $template, PDO::PARAM_STR);
    $stmt->bindParam(':show_in_menu', $show_in_menu, PDO::PARAM_BOOL);
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function updateMenuItem($db, $prefix, $id, $name, $page_url, $position, $template, $show_in_menu, $parent_id) {
    $stmt = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_menu SET name = :name, page_url = :page_url, position = :position, template = :template, show_in_menu = :show_in_menu, parent_id = :parent_id WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_INT);
    $stmt->bindParam(':template', $template, PDO::PARAM_STR);
    $stmt->bindParam(':show_in_menu', $show_in_menu, PDO::PARAM_BOOL);
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getMenuByPageUrl($db, $prefix, $page_url) {
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_menu WHERE page_url = :page_url");
    $stmt->bindParam(':page_url', $page_url);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function generateMenuUrl($db, $prefix, $page_url) {
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_settings");
    $stmt->execute();
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    
    if ($settings['pretty_url'] == 1) {
        if ($page_url == 'index') {
            return $base_url;
        }
        return $base_url . '/' . $page_url;
    }
    else {
        return $base_url . '/?page=' . $page_url;
    }
}

function getMenuItemById($db, $prefix, $id) {
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_menu WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

