<?php 

$id = intval($_GET['id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    try {
        $img_url = null;
        $img_name = null;
        $addonFolder ="jd_simple_img"; // Addon default directory

        if (isset($_FILES['file_id']) && $_FILES['file_id']['error'] == 0) {
            $uploaded_file = $_FILES["file_id"];
            $result = uploadFile($uploaded_file, $db, $prefix, $addonFolder);
            $img_url = $result['img_url'];
            $img_name = $result['img_name'];
            $_SESSION['success_message'] = t("The file has been successfully uploaded to the main directory as well as the addon directory");
        
        } elseif (isset($_POST['brand_icone_id']) && !empty($_POST['brand_icone_id'])) {
            $file = getFileById($db, $prefix, $_POST['brand_icone_id']);
            
            // Copy the existing file to the new directory
            $old_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $file['name'];
            $new_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/".$addonFolder."/" . $file['name'];
            
            if (copy($old_path, $new_path)) {
                $img_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/".$addonFolder."/" . $file['name'];
                $img_name = $file['name'];
                $_SESSION['success_message'] = t("File inserting to addon directory successfully.");
            } else {
                throw new Exception(t("Error copying existing file."));
            }
        } else {
           
            throw new Exception(t("No file was uploaded or selected."));
        }

        $title = $_POST['title'];
        $description = $_POST['description'];
   
        $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_jd_simple (title, description, img_url, img_name) VALUES (:title, :description, :img_url, :img_name)");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':img_url', $img_url, PDO::PARAM_STR);
        $stmt->bindParam(':img_name', $img_name, PDO::PARAM_STR);
        $stmt->execute();
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    header('Location: ../../core/tools/addons_model.php?name=jd_simple&id='.$id);
    exit();
}
?>


<div class="col-md-12">
    <div class="row d-flex">
        <form id="update-addon-form"  method="POST" action="" enctype="multipart/form-data" class="col-md-9">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="simpleFormControlInput" class="form-label"><?php echo t('Title');?></label>
                        <input type="text" class="form-control" name="title" id="simpleFormControlInput" placeholder="Title" required>
                    </div>
                    <div class="mb-3">
                        <label for="simpleFormControlTextarea" class="form-label"><?php echo t('Description');?></label>
                        <textarea class="form-control" name="description" id="simpleFormControlTextarea" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary"><?php echo t('Submit');?></button>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="file_id" class="form-label"><?php echo t('Image');?></label>
                        <input class="form-control form-control-sm" name="file_id" id="file_id" type="file" onchange="previewFile(this)">
                    </div>
                  
					<div id="image_container">
                        <img id="preview_image"  style="max-width: 100%;">
                    </div>

                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><?php echo t('files Library');?></button>
                        <div class="offcanvas offcanvas-end" style="background-color: #494f55fa;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body" id="offcanvasBody" style="background-color: #494f55fa;">
                            
                            
                            </div>
                            <div class="offcanvas-footer">
                                <button class="btn file-left prev"><i class="fas fa-angle-left"></i></button>
                                <button class="btn file-right next"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                </div>
            </div>
        </form>
        <div class="col-md-3">
            <?php
            $stmt = $db->prepare("SELECT title, description FROM " . $prefix['table_prefix'] . "_jd_simple ORDER BY id DESC LIMIT 5");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $result) {
                echo '<h5>' . $result['title'] . '</h5>';
                echo '<p>' . $result['description'] . '</p>';
                echo '<hr>';
            }
            ?>
        </div>
    </div>
</div>

   
<script>
    $('#file_id').change(function(event) {
    var file = this.files[0];
    var imgElement = document.getElementById('preview_image');
    var imgContainer = document.getElementById('image_container');

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            imgElement.src = e.target.result;
            imgContainer.style.display = 'block'; // Show image container
        }
        reader.readAsDataURL(file);
    } else {
        imgContainer.style.display = 'none'; // Hide image container
    }
});

 $(document).on('click', '.brand_icone_id', function() {
    var selectedFileId = $(this).val();
    $('#selected_file_id').val(selectedFileId);
});

$(document).ready(function() {
    $('.overlay').hover(
    function() {
      $(this).append('<span class="select-overlay">Select</span>');
    },
    function() {
      $(this).find('.select-overlay').remove();
    }
  );
});

$(document).on('click', 'input[name="brand_icone_id"]', function() {
    var selectedImageUrl = $(this).siblings('img').attr('src');
    $('#preview_image').attr('src', selectedImageUrl);
});

var index = 0;
var loadImages = function() {
    $.ajax({
        url: 'get_images.php',
        method: 'GET',
        data: {
            index: index
        },
        success: function(data) {
            $('#offcanvasBody').html(data);
        }
    });
};

$('#offcanvasRight').on('show.bs.offcanvas', function () {
    loadImages();
});

$('.prev').click(function() {
    index = Math.max(0, index - 6);
    loadImages();
    return false; 
});
$('.next').click(function() {
    index += 6;
    loadImages();
    return false; 
});

$('#file_id').change(function(event) {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_image').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

</script>


