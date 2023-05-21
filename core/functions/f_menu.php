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
function getMenus($db) {
    $stmt = $db->prepare('SELECT * FROM menu ORDER BY position');
    $stmt->execute();
    return $stmt->fetchAll();
}

function createMenuItem($db, $name, $page_url, $position, $template) {
    $stmt = $db->prepare('INSERT INTO menu (name, page_url, position, template) VALUES (:name, :page_url, :position, :template)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_INT);
    $stmt->bindParam(':template', $template, PDO::PARAM_STR);
    return $stmt->execute();
}

function updateMenuItem($db, $id, $name, $page_url, $position, $template) {
    $stmt = $db->prepare('UPDATE menu SET name = :name, page_url = :page_url, position = :position, template = :template WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_INT);
    $stmt->bindParam(':template', $template, PDO::PARAM_STR);
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
    // Gaukite nustatymus iš duomenų bazės
    $stmt = $db->prepare("SELECT * FROM settings");
    $stmt->execute();
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    
    // Jei pretty_url nustatymas yra 1, grąžinkite "gražų" URL
    if ($settings['pretty_url'] == 1) {
        return $base_url . '/' . $page_url;
    }
    // Jei pretty_url nustatymas nėra 1, grąžinkite įprastą URL
    else {
        return $base_url . '/?page=' . $page_url;
    }
}

