<?php 
$id = intval($_GET['id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    try {
        $file_id = null;
        $file_url = null;

        if (isset($_FILES['file_id']) && $_FILES['file_id']['error'] == 0) {
            $uploaded_file = $_FILES["file_id"];
            $unique_code = bin2hex(random_bytes(8));
            $filename_parts = pathinfo($uploaded_file["name"]);
            $new_filename = $filename_parts['filename'] . '_' . $unique_code . '.' . $filename_parts['extension'];

            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
            $addonImages = "/jd_simple_img/"; // pritaikyti paveikslėlių kopijavimą iš offcanvas ir įkelti naujai įkeltus paveikslėlius
            // iš input tačiau pridėti netik į files db ir upload dalį naujai įkeltų failus bet 
            // sudaryti kopijas šiam katalogui "/jd_simple_img/" kurių nuorodos turėtų būti ir $prefix['table_prefix'] . "_jd_simple db 
            // Reikėtų atnaujinti $prefix['table_prefix'] . "_jd_simple lentelę kad turėtų papildomus stulpelius 'url' ir 'name' o file_id nebenaudotų
            // nes failų duomenis naudotų iš kopijos tačiau pasirenkant iš offcanvas files.id naudotų kad rasti paveikslėlį ir jei jis pasiriankamas 
            // išsaugant sudarytų kopiją į naują addon katalogą. Tai sudaroma apsauga jei paveikslėlis ištrinamas o addon paliekamas veikti su tuo pačiu paveikslėliu

            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {
                $file_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $new_filename;
                
                $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_flussi_files (name, url) VALUES (:name, :url)");
                $stmt->bindParam(':name', $new_filename, PDO::PARAM_STR);
                $stmt->bindParam(':url', $file_url, PDO::PARAM_STR);
                $stmt->execute();

                $file_id = $db->lastInsertId();

                $_SESSION['success_message'] = "File uploaded successfully.";
            } else {
                throw new Exception("Error moving uploaded file.");
            }
        } elseif (isset($_POST['brand_icone_id']) && !empty($_POST['brand_icone_id'])) {
            $file = getFileById($db, $prefix, $_POST['brand_icone_id']);
            $file_id = $file['id'];
            $file_url = $file['url'];
            if ($file_id && $file_url) {
                $_SESSION['success_message'] = "File selected successfully.";
            } else {
                throw new Exception("Error selecting the file.");
            }
        } else {
            throw new Exception("No file was uploaded or selected.");
        }

        $title = $_POST['title'];
        $description = $_POST['description'];
   
        $stmt = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_jd_simple (title, description, file_id) VALUES (:title, :description, :file_id)");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':file_id', $file_id, PDO::PARAM_INT);
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
                  
                    <img id="preview_image" src="<?php echo $currentImage; ?>" alt="Preview image" style="max-width: 100%;">
								
                    <input type="hidden" id="selected_file_url" name="selected_file_url">

                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button>
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
            // Getting last 5 addons entries to display on the right
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


