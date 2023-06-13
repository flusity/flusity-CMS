<?php
function listFilesInDirectory($dir) {
    $files = array();
    if ($handle = opendir($dir)) {
        while (($entry = readdir($handle)) !== false) {
            if ($entry != "." && $entry != "..") {
                $files[] = $entry;
            } 
        }
        closedir($handle);
    }
    return $files;
}
function saveFileToDatabase($db, $name, $url) {
    $query = $db->prepare("INSERT INTO files (name, url) VALUES (:name, :url)");
    $query->bindParam(':name', $name);
    $query->bindParam(':url', $url);
    return $query->execute();
}
function getFilesListFromDatabase($db) {
    $query = $db->query("SELECT * FROM files");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function getFileById($db, $id) {
    $query = $db->prepare("SELECT * FROM files WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}        

function deleteFileFromDatabase($db, $id) {
    $query = $db->prepare("DELETE FROM files WHERE id = :id");
    $query->bindParam(':id', $id);
    return $query->execute();
}
function countFilesInDatabase($db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM `files`");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getCurrentImage($db) {
    // Pirmiausia gauname brand_icone reikšmę iš settings lentelės
    $query = $db->prepare("SELECT brand_icone FROM settings LIMIT 1");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $filename = $result ? $result['brand_icone'] : false;

    // Tada, jei turime failo pavadinimą, ieškome jo URL files lentelėje
    if ($filename) {
        $query = $db->prepare("SELECT url FROM files WHERE name = :name LIMIT 1");
        $query->bindParam(':name', $filename);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['url'] : false;
    }
    return false;
}



