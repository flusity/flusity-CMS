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
            <div class="row">
                <div class="col-sm-12 mt-2">
                    <h2><?php echo t("Settings");?></h2>
                    <ul class="nav nav-tabs  mt-2">
                        <li class="nav-item tabs-nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#settings"><?php echo t("Website Settings");?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#backup"><?php echo t("Database Backup");?></a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#tags"><?php echo t("Delete Tag's");?></a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#cache"><?php echo t("Cache");?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="settings">
                    <form id="update-settings-form"  method="post" enctype="multipart/form-data">
                        <div class="row">
                                <div class="col-md-6  border border-dark-subtle mt-2 mb-2"> <!-- Left column -->
                                    <div class="form-group mt-2">
                                        <label for="site_title"><b><?php echo t("Website Name");?></b></label>
                                        <input type="text" class="form-control" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required>
                                    </div>
                                    <div class="form-group mt-2">  
                                        <label for="meta_description"><b><?php echo t("META description");?></b></label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required><?php echo htmlspecialchars($settings['meta_description']); ?></textarea>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="default_keywords"><b><?php echo t("META Default keywords");?></b></label>
                                        <textarea class="form-control" id="default_keywords" name="default_keywords" rows="2" required><?php echo htmlspecialchars($settings['default_keywords']); ?></textarea>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="footer_text"><b><?php echo t("Footer text");?></b></label>
                                        <textarea class="form-control" id="footer_text" name="footer_text" rows="3" required><?php echo htmlspecialchars($settings['footer_text']); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3 border border-dark-subtle mt-2 mb-2"> 
                                    <div class="form-group mt-3 w-100">
                                        <label for="pretty_url"><?php echo t("Pretty URL");?></label>
                                        <input type="checkbox" class="form-control-ch" id="pretty_url" name="pretty_url" value="1" <?php echo ($settings['pretty_url'] == 1 ? 'checked' : '');?>>
                                    </div>
									 <div class="form-group mt-2 mb-2">
                                    <label for="registration_enabled"><?php echo t("Registration Enabled");?></label>
                                    <input type="checkbox" class="form-control-ch" id="registration_enabled" name="registration_enabled" value="1" <?php echo ($settings['registration_enabled'] == 1 ? 'checked' : '');?>>
                               
                                </div>
                                    <div class="form-group">
                                        <label for="posts_per_page"><?php echo t("Posts per page");?></label>
                                        <input type="number" class="form-control w-25" id="posts_per_page" name="posts_per_page" value="<?php echo htmlspecialchars($settings['posts_per_page']); ?>" required>
                                    </div>
                                    <div class="form-group mt-2 mb-2">
                                        <label for="language"><?php echo t("Language");?></label>
                                        <select class="form-control-slc" id="language" name="language">
                                            <?php 
                                                $containsEn = array_search('en', array_column($languages, 'language_code')) !== false;
                                                if (!$containsEn) {
                                                    $languages[] = ['language_code' => 'en'];
                                                }
                                                foreach ($languages as $lang) : ?>
                                                <option value="<?php echo htmlspecialchars($lang['language_code']); ?>" <?php echo ($settings['language'] === $lang['language_code'] ? 'selected' : ''); ?>>
                                                    <?php echo htmlspecialchars($lang['language_code']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2 mb-2">
                                        <label for="session_lifetime"><?php echo t("Session lifetime in minutes");?></label>
                                        <input type="text" class="form-control  w-50" id="session_lifetime" name="session_lifetime" value="<?php echo htmlspecialchars($settings['session_lifetime']); ?>" required>
                                    </div>
                            </div>
                       
							<?php $currentImage = getCurrentImage($db); ?>

							<div class="col-md-3 border border-dark-subtle mt-2 mb-2" style="position: relative;"> 
							<h3><?php echo t("Page Brand icone");?></h3>

								<div class="row justify-content-end">
									<label for="brand_icone"><?php echo t("Brand pictures");?></label>
									<div class="col-auto mb-2">
										<!-- <input class="form-control" id="brand_icone" type="file" name="brand_icone" onchange="previewImage(event)"> -->
										<input class="form-control" id="brand_icone" type="file" name="brand_icone" onchange="previewImage(event)" data-upload-method="direct">
									</div>
								</div>
					
								<div id="preview" <?php if (!$currentImage) echo 'style="display: none;"'; ?>>
								<img id="preview_image" src="<?php echo $currentImage; ?>" alt="Preview image" style="max-width: 100%;">
								</div> 

								<div class="toast align-items-center text-bg-warning border-0" role="alert" style="margin-top:30px" aria-live="assertive" aria-atomic="true" id="toast" style="position: absolute; top: 20px; right: 20px;">
									<div class="d-flex">
										<div class="toast-body" id="toast-body">
										</div>
										<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
									</div>
								</div>
								<div class="row">
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

                         </div>
                            <input type="submit" class="btn btn-primary" value="<?php echo t("Update Settings");?>"/>
                        </form>
                    </div>
                        <div class="tab-pane fade" id="backup">
                            <form action="create_backup.php" method="post">
                                <input type="submit" name="create_backup" value="<?php echo t("Create a backup");?>" class="btn btn-success mt-2">
                            </form>
                        <?php 
                            $backupDirectory = ROOT_PATH . 'core/tools/backups/';
                            $backupFiles = getBackupFilesList($backupDirectory);
                            echo "<h3>".t('List of backups')."</h3>";
                            if (count($backupFiles) > 0) {
                                $i=1;
                                foreach ($backupFiles as $file) {
                                    echo "<p>" .$i++.". <a href='download_backup.php?file=" . urlencode($file) . "'>" . htmlspecialchars($file) . "</a> <a href='delete_backup.php?file=" . urlencode($file) . "' onclick=\"return confirm('Are you sure you want to delete this file?')\">[Ištrinti]</a></p>";
                                }
                            } else {
                                     echo '<p>'. t("No backups").'</p>';
                            }?>
                        </div>
                        <div class="tab-pane fade" id="tags">
                        <h3><?php echo t("Delete your Tags");?></h3>
                        <?php $existingTags = getExistingTags($db); ?>
                        <?php if (!empty($existingTags)): ?>
                            <?php foreach ($existingTags as $tag): ?>
                                <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($tag); ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p><?php echo t("No tags have been created");?></p>
                        <?php endif; ?>
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast-notification">
                            <div class="toast-header">
                                <strong class="me-auto"><?php echo t("Notification");?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <?php echo t("Tag has been deleted successfully.");?>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="cache">
                            <form action="clear_cache.php" method="post">
                                <input type="submit" name="clear_cache" value="<?php echo t("Clear Cache");?>" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
               </div>
            </main>
       </div>
</div>
<script>
$(document).ready(function() {
    $('.overlay').hover(
    function() {
      $(this).append('<span class="select-overlay">Select</span>');
    },
    function() {
      $(this).find('.select-overlay').remove();
    }
  );
  
  $('#update-settings-form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    if (!$('#pretty_url').is(':checked')) {
        formData.append('pretty_url', 0);
    }
    if (!$('#registration_enabled').is(':checked')) {
        formData.append('registration_enabled', 0);
    }
    $.ajax({
        url: 'actions/update_setting.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false
            }).done(function(data) { 
                location.reload();
            if (data.success_message) {
                alert(data.success_message);
            }
            if (data.error_message) {
                alert(data.error_message);
            }
            }).fail(function() {
            alert('Error while updating settings.');
            });
        });
});


var MAX_FILE_SIZE = 102400; // 100KB
var MAX_DIMENSION = 500; // 500px

function previewImage(event) {
    var fileInput = event.target;
    var uploadMethod = fileInput.dataset.uploadMethod;
    
    if (uploadMethod === 'direct') {
        previewImageDirect(fileInput);
    } else if (uploadMethod === 'offcanvas') {
        previewImageOffcanvas(fileInput);
    }
}

function previewImageDirect(fileInput) {
    var file = fileInput.files[0];

    // Check if the file is an image
    if (!file.type.startsWith('image/')) { 
        showToast("File is not an image.");
        return;
    }

    // Check the file size
    if (file.size > MAX_FILE_SIZE) {
        showToast("File size should be less than " + MAX_FILE_SIZE / 1024 + "KB.");
        return;
    }

    var imgPreview = document.getElementById('preview_image');

    // Create a URL for the file
    var url = URL.createObjectURL(file);
    
    imgPreview.onload = function() {
        // Check the image dimensions
        if (this.naturalWidth > MAX_DIMENSION || this.naturalHeight > MAX_DIMENSION) {
            showToast("Image dimensions should be " + MAX_DIMENSION + "x" + MAX_DIMENSION + " pixels or less.");
            URL.revokeObjectURL(url); // Clean up
            return;
        }

        document.getElementById('preview').style.display = "block";
    };

    imgPreview.onerror = function() {
        showToast("Error loading image.");
        URL.revokeObjectURL(url); 
    };

    imgPreview.src = url;
}

function previewImageOffcanvas(fileInput) {
    var imgPreview = document.getElementById('preview_image');

    // Get the URL from the fileInput, depending on how it is set in your offcanvas implementation
    var url = getURLFromOffcanvasSelection(fileInput);

    imgPreview.src = url;
}



$(document).on('click', 'input[name="brand_icone_id"]', function() {
    var selectedImageUrl = $(this).siblings('img').attr('src');
    $('#preview_image').attr('src', selectedImageUrl);
});

function showToast(message) {
    var toastEl = document.getElementById('toast');
    document.getElementById('toast-body').innerText = message;
    
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
}




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
        index += 9;
        loadImages();
        return false; 
    });




</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>