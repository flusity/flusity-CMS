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
                $items_per_page = 20; // Rodyti 20 failų viename puslapyje
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $current_page = max($current_page, 1); // Užtikrinkite, kad puslapis būtų teigiamas skaičius
                $offset = ($current_page - 1) * $items_per_page;
                $files = getFilesListFromDatabase($db, $prefix, $offset, $items_per_page);
                
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
          //  echo '<a href="file_delete.php?id=' . urlencode($file['id']) . '" title="'.t("Delete").'" style="color: white;"><i class="fas fa-trash"></i></a>';
            echo '<a href="#" class="delete-link" data-id="' . urlencode($file['id']) . '" title="'.t("Delete").'" style="color: white;"><i class="fas fa-trash"></i></a>';

            echo '</p>';
            echo '</div>';
    
            echo '<div class="card-footer p-0 text-center" style="font-size: 10px;">';
            echo '<p class="m-0">' . htmlspecialchars($shortName) . '</p>';
            echo '</div>';
    
            echo '</div>';
            echo '</div>';
        }
    echo '</div>'; 

    $total_files = getTotalFilesCount($db, $prefix);
    $total_pages = ceil($total_files / $items_per_page);
?>

                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                </a>
                            </li>
                            <?php
                            $num_pages_to_display = 5;
                            $start = max(1, $current_page - $num_pages_to_display);
                            $end = min($current_page + $num_pages_to_display, $total_pages);

                            for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
    </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel"><?php echo t("Confirm Deletion"); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php echo t("Are you sure you want to delete this file?"); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
                <button type="button" class="btn btn-danger" id="confirmDelete"><?php echo t("Delete");?></button>
            </div>
        </div>
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

document.querySelectorAll('.delete-link').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var fileId = link.getAttribute('data-id');
        var deleteButton = document.getElementById('confirmDelete');
        deleteButton.setAttribute('data-id', fileId);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteModal.show();
    });
});

document.getElementById('confirmDelete').addEventListener('click', function() {
    var fileId = this.getAttribute('data-id');
    window.location.href = 'file_delete.php?id=' + fileId;
});

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>
