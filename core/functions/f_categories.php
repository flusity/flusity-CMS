<?php
function getCategories($db) {
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    return $stmt->fetchAll();
}
function createCategory($db, $name) {
    // Patikrina, ar kategorija su tokiu pavadinimu jau egzistuoja
    $stmt = $db->prepare('SELECT * FROM categories WHERE name = :name');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        // Jei kategorija egzistuoja, grąžina klaidą
        return 'Category already exists';
    }

    // Jei kategorijos nėra, pridedame ją
    $stmt = $db->prepare('INSERT INTO categories (name) VALUES (:name)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    if ($stmt->execute()) {
        // Jei įterpimo operacija buvo sėkminga, grąžiname teigiamą rezultatą
        return 'Category added successfully';
    } else {
        // Jei įterpimo operacija nepavyko, grąžiname klaidą
        return 'Error adding category';
    }
}

function getAllCategories($db) {
    $stmt = $db->prepare("SELECT * FROM categories");
    $stmt->execute();

    return $stmt->fetchAll();
}
function updateCategory($db, $id, $name) {
    // Patikrina, ar kategorija su tokiu pavadinimu jau egzistuoja (išskyrus atnaujinamąją)
    $stmt = $db->prepare('SELECT * FROM categories WHERE name = :name AND id != :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        // Jei kategorija egzistuoja, grąžina klaidą
        return 'Category already exists';
    }

    // Jei kategorijos nėra, atnaujiname ją
    $stmt = $db->prepare('UPDATE categories SET name = :name WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        // Jei atnaujinimo operacija buvo sėkminga, grąžina teigiamą rezultatą
        return 'Category updated successfully';
    } else {
        // Jei atnaujinimo operacija nepavyko, grąžina klaidą
        return 'Error updating category';
    }
}

function deleteCategory($db, $id) {
    $stmt = $db->prepare('DELETE FROM categories WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
