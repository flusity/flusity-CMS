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

function saveFileToDatabase($db, $prefix, $name, $url) {
    $query = $db->prepare("INSERT INTO  ".$prefix['table_prefix']."_flussi_files (name, url) VALUES (:name, :url)");
    $query->bindParam(':name', $name);
    $query->bindParam(':url', $url);
    return $query->execute();
}

function getFilesListForSettingsFromDatabase($db, $prefix){
	  $query = $db->query("SELECT * FROM  ".$prefix['table_prefix']."_flussi_files");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getFilesListFromDatabase($db, $prefix, $offset, $items_per_page) {
    $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_flussi_files LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalFilesCount($db, $prefix) {
    $query = $db->query("SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_flussi_files");
    return $query->fetchColumn();
}


function getFileById($db, $prefix, $id) {
    $query = $db->prepare("SELECT * FROM  ".$prefix['table_prefix']."_flussi_files WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}        

function deleteFileFromDatabase($db, $prefix, $id) {
    $query = $db->prepare("DELETE FROM  ".$prefix['table_prefix']."_flussi_files WHERE id = :id");
    $query->bindParam(':id', $id);
    return $query->execute();
}

function countFilesInDatabase($db, $prefix) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM  ".$prefix['table_prefix']."_flussi_files");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getCurrentImage($db, $prefix) {
   
    $query = $db->prepare("SELECT brand_icone FROM  ".$prefix['table_prefix']."_flussi_settings LIMIT 1");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $filename = $result ? $result['brand_icone'] : false;
    
    if ($filename) {
        $query = $db->prepare("SELECT url FROM  ".$prefix['table_prefix']."_flussi_files WHERE name = :name LIMIT 1");
        $query->bindParam(':name', $filename);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['url'] : false;
    }
    return false;
}

function handleFileUpload($db, $table_prefix, $target_dir, $allowed_file_types, $max_file_size) {
    $uploaded_file = $_FILES["uploaded_file"];
    $filename = $uploaded_file['name'];
    $filename_clean = strtolower(preg_replace("/[^a-zA-Z0-9\._]+/", "_", $filename));

    // Pridedamas plėtinio tikrinimas
    $allowed_extensions = ['png', 'jpeg', 'jpg', 'gif', 'pdf', 'doc', 'xls', 'docx', 'xlsx'];
    $filename_parts = pathinfo($filename_clean);
    if (!in_array($filename_parts['extension'], $allowed_extensions)) {
        $_SESSION['error_message'] = t("Invalid file extension.");
        return false;
    }

    if (!in_array($uploaded_file['type'], $allowed_file_types)) {
        $_SESSION['error_message'] = t("Invalid file type.");
        return false;
    }

    if ($uploaded_file['size'] > $max_file_size) {
        $_SESSION['error_message'] = t("File size exceeded limit.");
        return false;
    }

    $unique_code = bin2hex(random_bytes(8));
    $filename_parts = pathinfo($filename_clean);
    $new_filename = $filename_parts['filename'] . '_' . $unique_code . '.' . $filename_parts['extension'];

    $target_file = $target_dir . basename($new_filename);

    if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {
        $file_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $new_filename;
        $_SESSION['success_message'] = "File" ." ". basename($filename_clean) . " " .t("file uploaded successfully.");

        $stmt = $db->prepare("INSERT INTO " . $table_prefix . "_flussi_files (name, url) VALUES (:name, :url)");
        $stmt->bindParam(':name', $new_filename, PDO::PARAM_STR);
        $stmt->bindParam(':url', $file_url, PDO::PARAM_STR);
        $stmt->execute();

        return $db->lastInsertId();
    } else {
        $_SESSION['error_message'] = t("Error loading file.");
        return false;
    }
}
