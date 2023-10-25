<?php   
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once ROOT_PATH . 'core/template/header-admin.php';
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

            <div class="col-sm-9">
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
                        " . htmlspecialchars($_SESSION['success_message']) . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    unset($_SESSION['success_message']);
                   }
                    if (isset($_SESSION['error_message'])) {
                        echo "<div class='alert alert-danger alert-dismissible fade show slow-fade'>
                            " . htmlspecialchars($_SESSION['error_message']) . "
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                        unset($_SESSION['error_message']);
                    }
                ?>
            </div>
            <h2><?php echo t("Files");?></h2>
            <div class="col-sm-12">

                <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="row justify-content-end">
                <label for="formFile" class="form-label"><?php echo t("Select a file:");?></label>
                <div class="col-auto">
                    <input class="form-control" id="formFile" type="file" name="uploaded_file">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit"><?php echo t("Upload file");?></button>
                </div>
                </div>

                </form>
                <?php
           $files = getFilesListFromDatabase($db, $prefix);
        echo "<h3>";?><?php echo t("File list");?><?php echo "</h3>";
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        foreach ($files as $file) {
            $fileUrl = $file['url'];
            
            if (strpos($fileUrl, 'http://localhost') === 0) {
               // If URL starts with "http://localhost", use link without "http://localhost"
                $url = str_replace('http://localhost', '', $fileUrl);
            } else {
                // Otherwise use full URL
                $url = $fileUrl;
            }
            $is_image = preg_match('/\.(gif|jpe?g|png)$/i', $file['name']);
    
            $filename_parts = explode('_', $file['name']);
            array_pop($filename_parts);
            $shortName = implode('_', $filename_parts);
            $shortName = (strlen($shortName) > 10) ? substr($shortName, 0, 7) . '...' : $shortName;
    
            echo '<div class="col mt-3" style="margin: 7px; width: 150px; position: relative;">';
            echo '<div class="card h-100" style="padding: 3px; width: 160px;">'; 
    
            // Alternate images for non-image files
            $default_image = '/img/default.png'; // will add default photo
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    
            switch (strtolower($file_extension)) {
                case 'pdf':
                   $pdfImage ='img/pdf.png';
                    $default_image = $pdfImage;
                    break;
                case 'docx':
                    $default_image = 'img/docx.png';
                    break;
                case 'xlsx':
                    $default_image = 'img/xlsx.png';
                    break;
                           
                // add appropriate references to other file types
            }
    
            if ($is_image) {
                echo '<img src="' . $url . '" class="card-img-top" alt="' . htmlspecialchars($shortName) . '" style="width: 100%; height: 124px; object-fit: cover; border-radius: .25rem;" title="' . htmlspecialchars($shortName) . '">'; 
            } else {
                echo '<img src="' . $default_image . '" class="card-img-top" alt="' . htmlspecialchars($shortName) . '" style="width: 100px; height: 124px; object-fit: cover; border-radius: .25rem;" title="' . htmlspecialchars($shortName) . '">';
            }

            echo '<div class="card-body p-0" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); color: white; border-radius: .25rem;">'; 
            echo '<p class="card-text m-0" style="position: absolute; bottom: 0; width: 100%; text-align: center;">';
            echo '<a href="' . $url . '" target="_blank" title="'.t("Preview").'" style="color: white;"><i class="fas fa-eye"></i></a> ';
            echo '<a href="#" onclick="copyToClipboard(\'' . $url . '\')" title="'.t("Copy url").'" style="color: white;"><i class="fas fa-copy"></i></a> ';
            echo '<a href="file_delete.php?id=' . urlencode($file['id']) . '" title="'.t("Delete").'" style="color: white;"><i class="fas fa-trash"></i></a>';
            echo '</p>';
            echo '</div>';
    
            echo '<div class="card-footer p-0 text-center" style="font-size: 10px;">';
            echo '<p class="m-0">' . htmlspecialchars($shortName) . '</p>';
            echo '</div>';
    
            echo '</div>';
            echo '</div>';
        }
    echo '</div>'; 
?>
            </div>
    </main>
    </div>
</div>
<script>
    function copyToClipboard(text) {
        var textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("Nuoroda nukopijuota!");
    }
    document.querySelectorAll('.card-img-top').forEach((img) => {
        img.addEventListener('mouseover', (event) => {
            event.target.parentElement.querySelector('.card-body').style.display = 'block';
        });

        img.addEventListener('mouseout', (event) => {
            event.target.parentElement.querySelector('.card-body').style.display = 'none';
        });
    });
    function showCardTools(cardBody) {
        cardBody.style.display = 'block';
    }

    function hideCardTools(cardBody) {
        cardBody.style.display = 'none';
    }

    document.querySelectorAll('.card').forEach((card) => {
    card.addEventListener('mouseover', (event) => {
        let cardBody = event.currentTarget.querySelector('.card-body');
        if (cardBody) {
            cardBody.style.display = 'block';
        }
    });

    card.addEventListener('mouseout', (event) => {
        let cardBody = event.currentTarget.querySelector('.card-body');
        if (cardBody) {
            cardBody.style.display = 'none';
        }
    });
});

document.querySelectorAll('.card-body').forEach((cardBody) => {
    cardBody.addEventListener('mouseover', () => {
        showCardTools(cardBody);
    });

    cardBody.addEventListener('mouseout', () => {
        hideCardTools(cardBody);
    });
});

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>
