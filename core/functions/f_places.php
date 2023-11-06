<?php

function createPlace($db, $prefix, $name) {
    $stmt = $db->prepare('SELECT * FROM  '.$prefix['table_prefix'].'_flussi_places WHERE name = :name');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return 'Place already exists';
    }

    $stmt = $db->prepare('INSERT INTO  '.$prefix['table_prefix'].'_flussi_places (name) VALUES (:name)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    if ($stmt->execute()) {
        return 'Place added successfully';
    } else {
        return 'Error adding place';
    }
}
function getPlaces($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_places');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllPlaces($db, $prefix) {
    $stmt = $db->prepare('SELECT * FROM  '.$prefix['table_prefix'].'_flussi_places');
    $stmt->execute();

    return $stmt->fetchAll();
}
function updatePlace($db, $prefix, $id, $name) {
    $stmt = $db->prepare('SELECT * FROM '.$prefix['table_prefix'].'_flussi_places WHERE name = :name AND id != :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return 'Place already exists';
    }

    $stmt = $db->prepare('UPDATE  '.$prefix['table_prefix'].'_flussi_places SET name = :name WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        return 'Place updated successfully';
    } else {
        return 'Error updating place';
    }
}
function getPlaceIdByName($db, $prefix, $placeName) {
    $stmt = $db->prepare('SELECT id FROM '.$prefix['table_prefix'].'_flussi_places WHERE name = :name');
    $stmt->execute([':name' => $placeName]);
    $result = $stmt->fetch();

    return $result ? $result['id'] : null;
}

function deletePlace($db, $prefix, $id) {
    $stmt = $db->prepare('DELETE FROM  '.$prefix['table_prefix'].'_flussi_places WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
