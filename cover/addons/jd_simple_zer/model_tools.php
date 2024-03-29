<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$name_addon ='jd_simple_zer';

$id = intval(htmlspecialchars($_GET['id']));

$placesId = getplaces($db, $prefix);
$menuId = getMenuItems($db, $prefix);

$settings = getSettings($db, $prefix);
$bilingualism = $settings['bilingualism'];

$stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_jd_simple_zer WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$addonId = isset($_GET['addon_post_edit_id']) ? (int)htmlspecialchars($_GET['addon_post_edit_id']) : 0;
$addonPlace = isset($_GET['place_name']) ? $_GET['place_name'] : null; // paima pavadinimą
$addonMenuId = isset($_GET['menu']) ? $_GET['menu'] : null; // paima id

$mode = $addonId > 0 ? 'edit' : 'create';
$selected_place_id = getPlaceIdByName($db, $prefix, $addonPlace);

$addon = $mode === 'edit' ? getAddonById($db, $prefix, $name_addon, $addonId) : null;

$selectedMenuId = ($mode === 'edit' && $addon) ? $addon['menu_id'] : $addonMenuId;

if ($mode === 'create' || $addon) {
?>

<div class="col-md-12">
    <h4><?php echo t('Addon JD Simple');?></h4>
    <div class="row d-flex">

    <form id="update-addon-form" method="POST" action="../../cover/addons/jd_simple_zer/action/<?php echo $mode === 'edit' ? 'edit_addon_post.php' : 'add_addon.php'; ?>" enctype="multipart/form-data" class="col-md-10">
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
    <input type="hidden" name="mode" value="<?php echo $mode; ?>">
     <input type="hidden" name="addon_post_edit_id" value="<?php echo isset($addon['id']) ? $addon['id'] : ''; ?>">
    <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
     
     
    <div class="row">
        <div class="col-md-8">
        <div class="form-group row">
            <div class="col-md-5 mb-3">
                    <label for="addon_place_id"><?php echo t('Place');?></label>
                    <select class="form-control" id="addon_place_id" name="addon_place_id" required>
                        
                    <?php foreach ($placesId as $place) : ?>
                            <option value="<?php echo $place['id']; ?>" 
                                <?php 
                                if (($mode === 'edit' && $addon['place_id'] === $place['id']) || 
                                    ($mode === 'create' && $selected_place_id === $place['id'])) echo 'selected'; 
                                ?>>
                                <?php echo htmlspecialchars($place['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6 mb-3">
                <label for="addon_menu_id"><?php echo t('Menu');?></label>
                <select class="form-control" id="addon_menu_id" name="addon_menu_id" required>
                <option value="0"><?php echo t('To all pages');?></option>
                    <?php  foreach ($menuId as $menu) : ?>
                        <option value="<?php echo $menu['id']; ?>"
                        <?php echo ($selectedMenuId == $menu['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($menu['name']); ?>
                        </option>
                    <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="simpleFormControlInput" class="form-label"><?php echo t('Title');?></label>
                <input type="text" class="form-control" name="title" id="simpleFormControlInput" placeholder="Title" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['title']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="simpleFormControlTextarea" class="form-label"><?php echo t('Description');?></label>
                <textarea class="form-control" name="description" id="simpleFormControlTextarea" rows="3" required><?php echo $mode === 'edit' ? htmlspecialchars($addon['description']) : ''; ?></textarea>
            </div>
                <!-- Other language start-->
                <?php if($bilingualism != 0): ?>
                    <div class="form-group">
                        <label for="post_status"><?php echo t("Next Language");?></label>
                            <div class="accordion accordion-flush mb-3" id="accordionFlushExample">
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <?php echo t("Add content in another language");?>
                                </button>
                            </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="form-group mb-2">
                                <label for="lang_en_title"><?php echo t('Other language title');?></label>
                                    <input type="text" class="form-control" id="lang_en_title" name="lang_en_title" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['lang_en_title']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="simpleFormControlTextarea" class="form-label"><?php echo t('Other language description');?></label>
                                    <textarea class="form-control" name="lang_en_description" id="simpleFormControlTextarea" rows="3" ><?php echo $mode === 'edit' ? htmlspecialchars($addon['lang_en_description']) : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Other language end-->
            <div class="mb-3">
                <label for="simpleFormControlReadmoreInput" class="form-label"><?php echo t('Read more url');?></label>
                
                <input type="text" class="form-control" name="readmore" id="simpleFormControlReadmoreInput" placeholder="read more url" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['readmore']) : ''; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo t('Submit');?></button>
                <?php if (isset($_GET['addon_post_edit_id'])): ?>
                <a href="addons_model.php?name=jd_simple_zer&id=<?php echo htmlspecialchars($_GET['id']) ?>" class="btn btn-secondary"><?php echo t('Cancel');?></a>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="file_id" class="form-label"><?php echo t('Image');?></label>
                    <input class="form-control form-control-sm" name="file_id" id="file_id" type="file" onchange="previewFile(this)">
                    <input type="hidden" name="file_id"  id="file_id" value="<?php echo isset($addon['img_url']) ? $addon['img_url'] : ''; ?>">
            </div>
            <div id="image_container">
                <img id="preview_image"  style="max-width: 100%;" src="<?php echo $mode === 'edit' ? $addon['img_url'] : ''; ?>">
                <input type="hidden" name="db_img_name" value="<?php echo $mode === 'edit' ? $addon['img_name'] : ''; ?>">
            </div>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><?php echo t('files Library');?></button>
                <!-- Demo view start -->
                <button type="button" class="btn btn-info btn-lg" data-bs-toggle="offcanvas" data-bs-target="#demoOffcanvas">DEMO View</button>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="demoOffcanvas" aria-labelledby="demoOffcanvasLabel">
                    <div class="offcanvas-header">
                        <h5 id="demoOffcanvasLabel">DEMO View</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="card">
                            <img id="demoCardImage" class="card-img-top w-100 d-block" width="294" height="160" src="/cover/addons/jd_simple_zer/img/7646653_f9f1c35fca142b93.jpg">
                            <div class="card-body">
                                <h4 id="demoCardTitle" class="card-title text-dark">DEMO</h4>
                                <p id="demoCardText" class="card-text text-dark">Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
                                <button class="btn btn-primary" id="readMoreButton" type="button">Button</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Demo view end -->
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
        <div class="col-md-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" width="10%"><?php echo t("Image");?></th>
                        <th scope="col" width="20%"><?php echo t("Title");?></th>
                        <th scope="col" width="40%"><?php echo t("Description");?></th>
                        <th scope="col" width="15%"><?php echo t("Menu");?></th>
                        <th scope="col" width="10%"><?php echo t("Place");?></th>
                        <th scope="col" width="8%"><?php echo t("Actions");?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $get_params = $_GET;
                unset($get_params['page']);
                
                $get_param_str = '';
                if (!empty($get_params)) {
                    $get_param_str = http_build_query($get_params) . '&';
                }
                    $addons_per_page = 5;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page > 1) ? ($page - 1) * $addons_per_page : 0;

                    $stmt = $db->prepare("SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_jd_simple_zer");
                    $stmt->execute();
                    $total_addons = $stmt->fetchColumn();
                    $stmt = $db->prepare("SELECT addons.id, addons.title, addons.description, addons.readmore, addons.img_url, menu.name as menu_name, places.name as place_name, addons.menu_id
                    FROM " . $prefix['table_prefix'] . "_jd_simple_zer as addons LEFT JOIN " .
                     $prefix['table_prefix'] . "_flussi_menu as menu ON addons.menu_id = menu.id LEFT JOIN " .
                      $prefix['table_prefix'] . "_flussi_places as places ON addons.place_id = places.id ORDER BY addons.id DESC LIMIT :limit OFFSET :offset");

                    $stmt->bindParam(':limit', $addons_per_page, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $addonResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($addonResults as $addonRes) {

                        echo '<tr>';
                        if($addonRes['img_url'] != '') {
                            echo '<td><img src="' . $addonRes['img_url'] . '" alt="Addon Image" style="width: 35px; height: 35px;"></td>';
                        } else {
                            echo '<td>No Image</td>';
                        }
                        echo '<td>' . $addonRes['title'] . '</td>';
                        
                        $short_description = htmlspecialchars(mb_substr($addonRes['description'], 0, 60));
                        $short_menu = htmlspecialchars($addonRes['menu_name']);
                        $short_place = htmlspecialchars($addonRes['place_name']);
                        $shot_menu_id = htmlspecialchars($addonRes['menu_id']);
                        echo '<td>' . $short_description . '...</td>';
                       
                        echo '<td>';  if($shot_menu_id >0 ){ echo $short_menu; } else { echo t('All pages');} 
                        echo '</td>';
                        echo '<td>' . $short_place . '</td>';
                        echo '<td>';
                        echo '<a href="addons_model.php?name=jd_simple_zer&id=' . htmlspecialchars($_GET['id']) . '&addon_post_edit_id=' . htmlspecialchars($addonRes['id']) . '"><i class="fa fa-edit"></i></a> ';
                        echo '<a href="../../cover/addons/jd_simple_zer/action/delete_addon_post.php?name=jd_simple_zer&id=' . htmlspecialchars($_GET['id']) . '&addon_post_id=' . htmlspecialchars($addonRes['id']) . '"><i class="fa fa-trash"></i></a>';
                        echo '</td>';
                        echo '</tr>';
                    } ?></form>
                </tbody>
            </table>
                <?php 
                $total_pages = ceil($total_addons / $addons_per_page);

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo $i . " ";
                    } else {
                        echo "<a class='btn btn-primary' href='?" . $get_param_str . "page=" . $i . "'>" . $i . "</a> ";
                    }
                }
                ?>
        </div>
    </div>
</div>
<?php  } else {
           echo "Toks įrašas neegzistuoja";
}?>
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

function previewImageOffcanvas(fileInput) {
    var imgPreview = document.getElementById('preview_image');

    // Get the URL from the fileInput, depending on how it is set in your offcanvas implementation
    var url = getURLFromOffcanvasSelection(fileInput);

    imgPreview.src = url;
}
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

</script>