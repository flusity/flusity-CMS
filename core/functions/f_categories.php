<?php
function getCategories($db) {
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    return $stmt->fetchAll();
}

function createCategory($db, $name) {
    $stmt = $db->prepare('INSERT INTO categories (name) VALUES (:name)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    return $stmt->execute();
}

function getAllCategories($db) {
    $stmt = $db->prepare("SELECT * FROM categories");
    $stmt->execute();

    return $stmt->fetchAll();
}
function updateCategory($db, $id, $name) {
    $stmt = $db->prepare('UPDATE categories SET name = :name WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function deleteCategory($db, $id) {
    $stmt = $db->prepare('DELETE FROM categories WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
