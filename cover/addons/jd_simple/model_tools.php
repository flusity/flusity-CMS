<?php 

 $id = intval($_GET['id']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    try {
        if (!isset($_FILES['file_id'])) {
            throw new Exception("File was not uploaded.");
        }

        if ($_FILES['file_id']['error'] != 0) { 
            throw new Exception("File upload error.");
        }

        // New part for file upload handling
        $uploaded_file = $_FILES["file_id"];
        $unique_code = bin2hex(random_bytes(8));
        $filename_parts = pathinfo($uploaded_file["name"]);
        $new_filename = $filename_parts['filename'] . '_' . $unique_code . '.' . $filename_parts['extension'];

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {
            $file_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $new_filename;
            
            $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_flussi_files (name, url) VALUES (:name, :url)");
            $stmt->bindParam(':name', $new_filename, PDO::PARAM_STR);
            $stmt->bindParam(':url', $file_url, PDO::PARAM_STR);
            $stmt->execute();

            $file_id = $db->lastInsertId();

            $title = $_POST['title'];
            $description = $_POST['description'];
       
            $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_jd_simple (title, description, file_id) VALUES (:title, :description, :file_id)");
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':file_id', $file_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['success_message'] = "File uploaded successfully.";
        } else {
            throw new Exception("Error moving uploaded file.");
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    header('Location: ../../core/tools/addons_model.php?name=jd_simple&id='.$id);
    exit();
    
   
}
?>

<div class="row d-flex">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="simpleFormControlInput" class="form-label"><?php echo t('Title');?></label>
                <input type="text" class="form-control" name="title" id="simpleFormControlInput" placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="simpleFormControlTextarea" class="form-label"><?php echo t('Description');?></label>
                <textarea class="form-control" name="description" id="simpleFormControlTextarea" rows="3"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="file_id" class="form-label"><?php echo t('Image');?></label>
                <input class="form-control form-control-sm" name="file_id" id="formFileSm" type="file">
            </div>
            <img src="..." class="img-thumbnail" alt="...">
        </div>
        <div class="col-md-12">
            <button type="submit" name="submit" class="btn btn-primary"><?php echo t('Submit');?></button>
        </div>
    </form>
</div>
