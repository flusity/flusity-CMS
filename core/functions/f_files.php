
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
