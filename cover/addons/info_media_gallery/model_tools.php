
<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/info_media_gallery/core/media_function.php';

$name_addon ='info_media_gallery';
$id = intval(htmlspecialchars($_GET['id']));
$placesId = getplaces($db, $prefix);
$menuId = getMenuItems($db, $prefix);
$settings = getSettings($db, $prefix);
$bilingualism = $settings['bilingualism'];

$stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_info_media_gallery WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$addonId = isset($_GET['addon_post_edit_id']) ? (int)htmlspecialchars($_GET['addon_post_edit_id']) : 0;
$addonPlace = isset($_GET['place_name']) ? $_GET['place_name'] : null; 
$addonMenuId = isset($_GET['menu']) ? $_GET['menu'] : null; 
$mode = $addonId > 0 ? 'edit' : 'create';
$selected_place_id = getPlaceIdByName($db, $prefix, $addonPlace);
$addon = $mode === 'edit' ? getAddonById($db, $prefix, $name_addon, $addonId) : null;
$selectedMenuId = ($mode === 'edit' && $addon) ? $addon['menu_id'] : $addonMenuId;


if ($mode === 'create' || $addon) { ?>

<div class="col-md-12">
    <h4><?php echo t('Addon JD Flusity \'Media gallery with description\' ');?></h4>
    <div class="row d-flex">
        
    <form id="update-addon-form" method="POST" action="../../cover/addons/info_media_gallery/action/<?php echo $mode === 'edit' ? 'edit_addon_post.php' : 'add_addon.php'; ?>" enctype="multipart/form-data" class="col-md-10">
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
            <div class="form-group row">  
            <div class="col-md-6 mb-3">    
                    <label for="FormControlInput_social_gallery_link" class="form-label"><?php echo t('Gallery name');?></label>
                    <input type="text" class="form-control" name="gallery_name" id="FormControlInput_social_gallery_link" placeholder="Gallery name" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['gallery_name']) : ''; ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="FormControl_gallery_css_style_settings_Select" class="form-label"><?php echo t('Style gallery'); ?></label>
                <select class="form-control" name="gallery_css_style_settings" id="FormControl_gallery_css_style_settings_Select">
                    <option value="dark" <?php echo $mode === 'edit' && $addon['gallery_css_style_settings'] === 'dark' ? 'selected' : ''; ?>><?php echo t('Dark');?></option>
                    <option value="light" <?php echo $mode === 'edit' && $addon['gallery_css_style_settings'] === 'light' ? 'selected' : ''; ?>><?php echo t('Light');?></option>
                </select>
            </div>
            <div class="col-md-2 mb-3">    
                    <label for="FormControlInput_image_width" class="form-label"><?php echo t('Image Width');?></label>
                    <input type="text" class="form-control" name="img_w" id="FormControlInput_image_width" placeholder="Width px" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['img_w']) : ''; ?>" >
            </div>
            <div class="col-md-2" style="margin-top: 32px;"> 
            <button type="button"  style="min-height: 38px;" onclick="addFields()"><?php echo t("+ image & description"); ?></button>
            </div>
            </div>
        
    <div id="dynamicFields"></div>

<?php if($mode === 'edit') {
 if ($addon && isset($addon['id'])) {
    $gallery_items = getMediaItemsByAddonId($db, $prefix, $addon['id']);
  
    foreach ($gallery_items as $i => $item)  { 
       
        $item_title[] = $item['title'];
        $item_description[] = $item['media_description'];
        $lang_en_title[] = isset($item['lang_en_title']) ? $item['lang_en_title'] : '';
        $lang_en_media_description[] = isset($item['lang_en_media_description']) ? $item['lang_en_media_description'] : '';

        $item_link_url[] = $item['hyperlink'];
        $item_media_file_id[] = $item['media_file_id'];
        $item_id[] = $item['id'];
        $imageData = getFileById($db, $prefix, $item_media_file_id[$i]);
        $image_url = $imageData['url'] ?? ''; 
        ?>
<div id="dynamic_fields_<?php echo $i?>">
        <p class="media-item-label"><?php echo  t('Media Item');?> <?php echo $i+1;?></p>
                 
    <div class="form-row">
        <label for="FormControlInput_media_title_<?php echo $i;?>" class="col-md-12"><?php echo  t('Title');?></label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="media_title[]" id="FormControlInput_media_title_<?php echo $i;?>" placeholder="<?php echo  t('Title');?>" value="<?php echo htmlspecialchars(trim($item_title[$i])); ?>" required>
            </div>
            <div class="col-md-12 form-group row mt-3 d-flex justify-content-between align-items-center">
                <div class="col-md-2" id="ImageContainer_<?php echo $i;?>" data-image-id="<?php echo $i; ?>">
                    <img src="<?php echo $image_url; ?>" width="75px" height="auto">
                    <input type="hidden" name="image_id[]" value="<?php echo htmlspecialchars(trim($item_media_file_id[$i])); ?>">
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-secondary form-control" onclick="selectImageForDynamicField('ImageContainer_<?php echo $i;?>')"><?php echo t('+ Image');?></button>
                </div>

                <div class="col-md-2">
                    <button type="button" onclick="removeEditFields('<?php echo $item_id[$i]; ?>', '<?php echo htmlspecialchars($_GET['id']); ?>', '<?php echo $addon['id']; ?>')" class="btn btn-danger form-control"><?php echo t('Remove');?></button>
                </div>
            </div>
    </div>
            <input type="hidden" name="item_id[]"  value="<?php echo htmlspecialchars(trim($item_id[$i])); ?>" >
            <label><?php echo  t('URL link');?></label>
            <input type="text" class="form-control" name="media_url[]" placeholder="<?php echo  t('URL link');?>" value="<?php echo htmlspecialchars(trim($item_link_url[$i])); ?>" required>
            <label><?php echo  t('Description');?></label>
            <textarea class="form-control" name="media_desc[]" placeholder="<?php echo  t('Description');?>" required><?php echo htmlspecialchars(trim($item_description[$i])); ?></textarea>

<!-- Other language start-->
<?php if($bilingualism != 0): ?>
    <div class="form-group">
        <label for="post_status"><?php echo t("Next Language");?></label>
            <div class="accordion accordion-flush mb-3" id="accordionFlushExample_<?php echo $i;?>">
            <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne_<?php echo $i;?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne_<?php echo $i;?>" aria-expanded="false" aria-controls="flush-collapseOne_<?php echo $i;?>">
                <?php echo t("Add content in another language");?>
                </button>
            </h2>
        <div id="flush-collapseOne_<?php echo $i;?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne_<?php echo $i;?>" data-bs-parent="#accordionFlushExample_<?php echo $i;?>">
            <div class="accordion-body">
                <div class="form-group mb-2">
                <label for="lang_en_title"><?php echo t('Other language title');?></label>
                <input type="text" class="form-control" id="lang_en_title" name="lang_en_title[]" value="<?php echo isset($lang_en_title[$i]) ? htmlspecialchars($lang_en_title[$i]) : ''; ?>">

                </div>
                <div class="mb-3">
                    <label for="simpleFormControlTextarea" class="form-label"><?php echo t('Other language description');?></label>
                    <textarea class="form-control" name="lang_en_media_description[]" id="simpleFormControlTextarea" rows="3"><?php echo isset($lang_en_media_description[$i]) ? htmlspecialchars($lang_en_media_description[$i]) : ''; ?></textarea>

                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
    <?php endif; ?>
<!-- Other language end-->

        </div>
<?php }
    } 
}
?>
        </div>
        <div class="col-md-4"> 
            <button type="button" class="btn btn-info btn-lg" data-bs-toggle="offcanvas" data-bs-target="#demoOffcanvas"><?php echo t("Demo view"); ?></button>

            <div class="mt-3">
            <button type="submit" name="submit" class="btn btn-primary btn-lg"><?php echo t('Create or Edit Gallery');?></button>
            </div>

            <div class="mt-3">
            <?php if (isset($_GET['addon_post_edit_id'])): ?>
            <a href="addons_model.php?name=info_media_gallery&id=<?php echo htmlspecialchars($_GET['id']) ?>" class="btn btn-secondary"><?php echo t('Cancel');?></a>
            <?php endif; ?>
            </div>

           
            <div class="offcanvas offcanvas-start" tabindex="-1" id="demoOffcanvas" aria-labelledby="demoOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 id="demoOffcanvasLabel"><?php echo t("Demo view"); ?></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <h2>Gallery demo view</h2>
                  
                   <?php require_once "assets/demo/demo.php";?>
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" width="20%"><?php echo t("Gallery name");?></th>
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

                    $stmt = $db->prepare("SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_info_media_gallery");
                    $stmt->execute();
                    $total_addons = $stmt->fetchColumn();
                    $stmt = $db->prepare("SELECT addons.id, addons.gallery_name, addons.gallery_css_style_settings, menu.name as menu_name, places.name as place_name, addons.menu_id
                    FROM " . $prefix['table_prefix'] . "_info_media_gallery as addons LEFT JOIN " .
                    $prefix['table_prefix'] . "_flussi_menu as menu ON addons.menu_id = menu.id LEFT JOIN " .
                    $prefix['table_prefix'] . "_flussi_places as places ON addons.place_id = places.id ORDER BY addons.id DESC LIMIT :limit OFFSET :offset");

                    $stmt->bindParam(':limit', $addons_per_page, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $addonResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($addonResults as $addonRes) {
                        echo '<tr>
                        <td>' . $addonRes['gallery_name'] . '</td>';
                        $short_menu = $addonRes['menu_name'];
                        $short_place = $addonRes['place_name'];
                        $shot_menu_id = $addonRes['menu_id'];
                        echo '<td>';  if($shot_menu_id >0 ){ echo $short_menu; } else { echo t('All pages');} 
                        echo '</td>';
                        echo '<td>' . $short_place . '</td>';
                        echo '<td>';
                        echo '<a href="addons_model.php?name=info_media_gallery&id=' . htmlspecialchars($_GET['id']) . '&addon_post_edit_id=' . htmlspecialchars($addonRes['id']) . '"><i class="fa fa-edit"></i></a> ';
                        ?>
                         <a href="javascript:void(0);" onclick="deleteAddonGallery(<?php echo htmlspecialchars($addonRes['id']); ?>)"><i class="fa fa-trash"></i></a>
                       <?php
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
<?php  } else { echo t("No such record exists"); } ?>

<script>

    function deleteAddonGallery(addonId) {
        $.ajax({
            type: 'POST',
            url: '../../cover/addons/info_media_gallery/action/delete_addon_post.php',
            data: {
                name: 'info_media_gallery',
                id: '<?php echo htmlspecialchars($_GET['id']); ?>',
                addon_post_id: addonId
            },
            success: function(response) {
                window.location.href = 'addons_model.php?name=info_media_gallery&id=<?php echo htmlspecialchars($_GET['id']); ?>';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    }
let counter = 1;
let divs = [];

function removeEditFields(itemId, addonId, galleryId) {
    $.ajax({
        url: '../../cover/addons/info_media_gallery/action/remove_item.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: itemId }),
        success: function(data) {
            if (data.success) {
                alert(data.message); 
                window.location.href = '/core/tools/addons_model.php?name=info_media_gallery&id=' + addonId + '&addon_post_edit_id=' + galleryId;
            } else {
                alert(data.message); 
            }
        },
        error: function(error) {
            alert('Klaida vykdant užklausą: ' + error);
        }
    });
}


function removeFields(containerDiv) {
    const index = divs.indexOf(containerDiv);
    if (index > -1) {
        divs.splice(index, 1);
    }
    containerDiv.remove();
}

function addFields() {
    const mainContainer = document.getElementById("dynamicFields");
    const containerDiv = document.createElement("div");

    const mediaItemLabel = document.createElement("p");
    mediaItemLabel.className = "media-item-label"; 
    var mediaItem = t('Media item&nbsp;'); 
    mediaItemLabel.innerHTML = `${mediaItem}${divs.length + 1}`;


    const titleRowDiv = document.createElement("div");
    titleRowDiv.className = "form-row d-flex justify-content-between";

    const titleColDiv = document.createElement("div");
    titleColDiv.className = "col-md-7";

    const buttonColDiv = document.createElement("div");
    buttonColDiv.className = "col-md-2";

    const titleLabel = document.createElement("label");
    titleLabel.setAttribute("for", `FormControlInput_media_title_${counter}`);
    titleLabel.innerHTML = t("Title");

    const titleInputGroup = document.createElement("div");
    titleInputGroup.className = "d-flex align-items-center";

    const titleInput = document.createElement("input");
    titleInput.type = "text";
    titleInput.className = "form-control";
    titleInput.name = `media_title[]`; 
    titleInput.id = `FormControlInput_media_title_${counter}`;
    titleInput.placeholder = t("Title");
    titleInput.required = true;
    

  // Sukurti "Other language" dalį
  const otherLanguageDiv = document.createElement("div");
    otherLanguageDiv.className = "form-group";

    const otherLanguageLabel = document.createElement("label");
    otherLanguageLabel.innerHTML = t("Next Language");

    const otherLanguageAccordion = document.createElement("div");
    otherLanguageAccordion.className = "accordion accordion-flush mb-3";
    otherLanguageAccordion.id = `accordionFlushExample_${counter}`;
  
    const accordionItem = document.createElement("div");
    accordionItem.className = "accordion-item";
  
    const accordionHeader = document.createElement("h2");
    accordionHeader.className = "accordion-header";
    accordionHeader.id = `flush-headingOne_${counter}`;
  
    const accordionButton = document.createElement("button");
    accordionButton.className = "accordion-button collapsed";
    accordionButton.type = "button";
    accordionButton.dataset.bsToggle = "collapse";
    accordionButton.dataset.bsTarget = `#flush-collapseOne_${counter}`;
    accordionButton.setAttribute("aria-expanded", "false");
    accordionButton.setAttribute("aria-controls", `flush-collapseOne_${counter}`);
    accordionButton.innerHTML = t("Add content in another language");

    accordionHeader.appendChild(accordionButton);

    const accordionCollapse = document.createElement("div");
    accordionCollapse.id = `flush-collapseOne_${counter}`;
    accordionCollapse.className = "accordion-collapse collapse";
    accordionCollapse.setAttribute("aria-labelledby", `flush-headingOne_${counter}`);
    accordionCollapse.dataset.bsParent = `#accordionFlushExample_${counter}`;
  
    const accordionBody = document.createElement("div");
    accordionBody.className = "accordion-body";

    const otherLanguageTitleInput = document.createElement("input");
    otherLanguageTitleInput.type = "text";
    otherLanguageTitleInput.className = "form-control";
    otherLanguageTitleInput.name = `lang_en_title[]`;
    otherLanguageTitleInput.placeholder = t("Other language title");

    const otherLanguageDescInput = document.createElement("textarea");
    otherLanguageDescInput.className = "form-control";
    otherLanguageDescInput.name = `lang_en_description[]`;
    otherLanguageDescInput.placeholder = t("Other language description");

    accordionBody.appendChild(otherLanguageTitleInput);
    accordionBody.appendChild(otherLanguageDescInput);
  
    accordionCollapse.appendChild(accordionBody);
    accordionItem.appendChild(accordionHeader);
    accordionItem.appendChild(accordionCollapse);
  
    otherLanguageAccordion.appendChild(accordionItem);
  
    otherLanguageDiv.appendChild(otherLanguageLabel);
    otherLanguageDiv.appendChild(otherLanguageAccordion);




    const imageContainer = document.createElement("div");
    imageContainer.id = `ImageContainer_${counter}`; 
  

    const imageSelectButton = document.createElement("button");
    imageSelectButton.type = "button";
    imageSelectButton.className = "btn btn-secondary";
    imageSelectButton.style.marginLeft = "10px";

    const imageText = document.createElement("span");
    imageText.innerHTML = t("+ Image");
    imageSelectButton.appendChild(imageText);

    imageSelectButton.onclick = (function(localCounter) {
    return function() {
        const targetId = `ImageContainer_${localCounter}`;
        
        console.log(document.getElementById(targetId)); 
        selectImageForDynamicField(targetId);
        
    };
    })(counter);
    titleInputGroup.appendChild(titleInput);
    titleInputGroup.appendChild(imageSelectButton);

    titleColDiv.appendChild(titleLabel);
    titleColDiv.appendChild(titleInputGroup);

    
    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.innerHTML = t("Remove");
    removeButton.className = "btn btn-danger";
    removeButton.onclick = function() {
        removeFields(containerDiv);
    };

    buttonColDiv.appendChild(removeButton);

    titleRowDiv.appendChild(titleColDiv);
    titleRowDiv.appendChild(buttonColDiv);

    const urlLabel = document.createElement("label");
    urlLabel.innerHTML = t("URL link");
    const urlInput = document.createElement("input");
    urlInput.type = "text";
    urlInput.className = "form-control";
    urlInput.name = `media_url[]`; /// masyvas
    urlInput.placeholder = t("URL link");
    urlInput.required = true;

    const descLabel = document.createElement("label");
    descLabel.innerHTML = t("Description");
    const descInput = document.createElement("textarea");
    descInput.className = "form-control";
    descInput.name = `media_desc[]`;   /// masyvas
    descInput.placeholder = t("Description");
    descInput.required = true;

    containerDiv.appendChild(mediaItemLabel);
    containerDiv.appendChild(titleRowDiv); 

    containerDiv.appendChild(imageContainer);

    containerDiv.appendChild(urlLabel);
    containerDiv.appendChild(urlInput);
    containerDiv.appendChild(descLabel);
    containerDiv.appendChild(descInput);
    containerDiv.appendChild(otherLanguageDiv);

    mainContainer.appendChild(containerDiv);
    divs.push(containerDiv);
    counter++;
}


</script>