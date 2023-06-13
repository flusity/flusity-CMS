<?php
// Meniu
function deleteMenuItem($db, $id) {
    $stmt = $db->prepare('DELETE FROM menu WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getMenuItems($db) {
    $stmt = $db->prepare('SELECT * FROM menu ORDER BY position');
    $stmt->execute();
    return $stmt->fetchAll();
}
function createMenuItem($db, $name, $page_url, $position, $template, $show_in_menu, $parent_id) {
    $stmt = $db->prepare('INSERT INTO menu (name, page_url, position, template, show_in_menu, parent_id) VALUES (:name, :page_url, :position, :template, :show_in_menu, :parent_id)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_INT);
    $stmt->bindParam(':template', $template, PDO::PARAM_STR);
    $stmt->bindParam(':show_in_menu', $show_in_menu, PDO::PARAM_BOOL);
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function updateMenuItem($db, $id, $name, $page_url, $position, $template, $show_in_menu, $parent_id) {
    $stmt = $db->prepare('UPDATE menu SET name = :name, page_url = :page_url, position = :position, template = :template, show_in_menu = :show_in_menu, parent_id = :parent_id WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_INT);
    $stmt->bindParam(':template', $template, PDO::PARAM_STR);
    $stmt->bindParam(':show_in_menu', $show_in_menu, PDO::PARAM_BOOL);
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getMenuByPageUrl($db, $page_url) {
    $stmt = $db->prepare("SELECT * FROM menu WHERE page_url = :page_url");
    $stmt->bindParam(':page_url', $page_url);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function generateMenuUrl($db, $page_url) {
    $stmt = $db->prepare("SELECT * FROM settings");
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


