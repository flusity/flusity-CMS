<?php   
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once ROOT_PATH . 'core/template/header-admin.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php require_once ROOT_PATH . 'core/template/admin-menu-horizontal.php'; ?>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row d-flex flex-nowrap">
        <div class="col-md-2 sidebar" id="sidebar">
            <?php require_once ROOT_PATH . 'core/tools/sidebar.php'; ?>
        </div>

        <div class="col-md-10 content-up">
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
            <div class="col-sm-8">

                <form action="upload.php" method="POST" enctype="multipart/form-data">
                <?php echo t("Select a file:");?>
                    <input type="file" name="uploaded_file">
                    <button type="submit"><?php echo t("Upload file");?></button>
                </form>
                <?php
           $files = getFilesListFromDatabase($db);
        echo "<h3>";?><?php echo t("File list");?><?php echo "</h3>";
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
    foreach ($files as $file) {
        $url = $file['url'];
        $is_image = preg_match('/\.(gif|jpe?g|png)$/i', $file['name']);

        $filename_parts = explode('_', $file['name']);
        array_pop($filename_parts);
        $shortName = implode('_', $filename_parts);
        $shortName = (strlen($shortName) > 10) ? substr($shortName, 0, 7) . '...' : $shortName;

        echo '<div class="col mt-3" style="margin: 7px; width: 150px; position: relative;">';
        echo '<div class="card h-100" style="padding: 3px; width: 160px;">'; 
        
        if ($is_image) {
            echo '<img src="' . $url . '" class="card-img-top" alt="' . htmlspecialchars($shortName) . '" style="width: 100%; height: 144px; object-fit: cover; border-radius: .25rem;" title="' . htmlspecialchars($shortName) . '">'; // pridėtas 'border-radius: .25rem;'

            echo '<div class="card-body p-0" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); color: white; border-radius: .25rem;">'; // pridėtas 'border-radius: .25rem;'
            echo '<p class="card-text m-0" style="position: absolute; bottom: 0; width: 100%; text-align: center;">';
        echo '<a href="' . $url . '" target="_blank" title="'.t("Preview").'" style="color: white;"><i class="fas fa-eye"></i></a> ';
            echo '<a href="#" onclick="copyToClipboard(\'' . $url . '\')" title="'.t("Copy url").'" style="color: white;"><i class="fas fa-copy"></i></a> ';
            echo '<a href="file_delete.php?id=' . urlencode($file['id']) . '" title="'.t("Delete").'" style="color: white;"><i class="fas fa-trash"></i></a>';
            echo '</p>';
            echo '</div>';
        } else {
            echo '<div class="card-header">' . htmlspecialchars($file['name']) . '</div>';
        }
        echo '<div class="card-footer p-0 text-center" style="font-size: 10px;">';
        echo '<p class="m-0">' . htmlspecialchars($shortName) . '</p>';
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
    }
    echo '</div>'; 
?>
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
        event.currentTarget.querySelector('.card-body').style.display = 'block';
    });

    card.addEventListener('mouseout', (event) => {
        event.currentTarget.querySelector('.card-body').style.display = 'none';
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
