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