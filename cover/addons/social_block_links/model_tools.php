<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$name_addon ='social_block_links';
$id = intval(htmlspecialchars($_GET['id']));
$placesId = getplaces($db, $prefix);
$menuId = getMenuItems($db, $prefix);
$settings = getSettings($db, $prefix);
$stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_social_block_links WHERE id = :id");
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
    <h4><?php echo t('Addon JD Flusity \'Social block links\' ');?></h4>
    <div class="row d-flex">
    <form id="update-addon-form" method="POST" action="../../cover/addons/social_block_links/action/<?php echo $mode === 'edit' ? 'edit_addon_post.php' : 'add_addon.php'; ?>" enctype="multipart/form-data" class="col-md-10">
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
      
            <div id="dynamicFields"></div>

            <?php if($mode === 'edit') {
                    $profile_names = explode(',', $addon['profiles_name']);
                    $profile_links = explode(',', $addon['social_profiles_link_url']);
                    $profile_icons = explode(',', $addon['fa_icone_code']);

                    for ($i = 0; $i < count($profile_names); $i++) { ?>
                        <div class="mb-3">
                            <label for="FormControlInput_social_profiles_link_<?php echo $i; ?>" class="form-label"><?php echo t('Profile name');?></label>
                            <input type="text" class="form-control" name="profiles_name[]" id="FormControlInput_social_profiles_link_<?php echo $i; ?>" placeholder="Profile name" value="<?php echo htmlspecialchars(trim($profile_names[$i])); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="FormControl_social_profiles_link_urlInput_<?php echo $i; ?>" class="form-label"><?php echo t('URL link to profile');?></label>
                            <input type="text" class="form-control" name="social_profiles_link_url[]" id="FormControl_social_profiles_link_urlInput_<?php echo $i; ?>" placeholder="URL link" value="<?php echo htmlspecialchars(trim($profile_links[$i])); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="FormControl_fa_icone_code_Input_<?php echo $i; ?>" class="form-label"><?php echo t('profile fa icon code');?></label>
                            <textarea type="text" class="form-control" name="fa_icone_code[]" id="FormControl_fa_icone_code_Input_<?php echo $i; ?>" placeholder="fa icone code" required><?php echo htmlspecialchars(trim($profile_icons[$i])); ?></textarea>
                        </div>
                    <?php }
                    } ?>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo t('Submit');?></button>
            <?php if (isset($_GET['addon_post_edit_id'])): ?>
            <a href="addons_model.php?name=social_block_links&id=<?php echo htmlspecialchars($_GET['id']) ?>" class="btn btn-secondary"><?php echo t('Cancel');?></a>
            <?php endif; ?>
        </div>
        <div class="col-md-4"> 
            <button type="button" class="btn btn-info btn-lg" data-bs-toggle="offcanvas" data-bs-target="#demoOffcanvas"><?php echo t("Help with adding icons"); ?></button>
            <div class="mt-3"> 
            <button type="button" onclick="addFields()"><?php echo t("Add a new profile"); ?></button>
            </div>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="demoOffcanvas" aria-labelledby="demoOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 id="demoOffcanvasLabel"><?php echo t("Help with adding icons"); ?></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <h2>The Icons</h2>
                    <p>The complete set of 675 icons in Font Awesome 4.7.0 <br>
                    an example of how to add an icon and set the size fa-1x --- fa-5x</p>
                    <br><p>example what must be something to add to 'profile fa icon code'</p>
                    <p style="font-size: 14px;">&lt;i class="fa fa-user-circle fa-3x" aria-hidden="true"&gt;&lt;/i&gt;</p><br>
                    <a href="https://fontawesome.com/v4/icons/" target="_blank" >https://fontawesome.com/v4/icons/</a>
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" width="20%"><?php echo t("Profile Name");?></th>
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

                    $stmt = $db->prepare("SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_social_block_links");
                    $stmt->execute();
                    $total_addons = $stmt->fetchColumn();
                    $stmt = $db->prepare("SELECT addons.id, addons.profiles_name, addons.social_profiles_link_url, addons.fa_icone_code, menu.name as menu_name, places.name as place_name, addons.menu_id
                    FROM " . $prefix['table_prefix'] . "_social_block_links as addons LEFT JOIN " .
                    $prefix['table_prefix'] . "_flussi_menu as menu ON addons.menu_id = menu.id LEFT JOIN " .
                    $prefix['table_prefix'] . "_flussi_places as places ON addons.place_id = places.id ORDER BY addons.id DESC LIMIT :limit OFFSET :offset");

                    $stmt->bindParam(':limit', $addons_per_page, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $addonResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($addonResults as $addonRes) {
                        echo '<tr>
                        <td>' . $addonRes['profiles_name'] . '</td>';
                        $short_menu = htmlspecialchars($addonRes['menu_name']);
                        $short_place = htmlspecialchars($addonRes['place_name']);
                        $shot_menu_id = htmlspecialchars($addonRes['menu_id']);
                        echo '<td>';  if($shot_menu_id >0 ){ echo $short_menu; } else { echo t('All pages');} 
                        echo '</td>';
                        echo '<td>' . $short_place . '</td>';
                        echo '<td>';
                        echo '<a href="addons_model.php?name=social_block_links&id=' . htmlspecialchars($_GET['id']) . '&addon_post_edit_id=' . htmlspecialchars($addonRes['id']) . '"><i class="fa fa-edit"></i></a> ';
                        ?>
                         <a href="javascript:void(0);" onclick="deleteAddon(<?php echo htmlspecialchars($addonRes['id']); ?>)"><i class="fa fa-trash"></i></a>
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
    function deleteAddon(addonId) {
        $.ajax({
            type: 'POST',
            url: '../../cover/addons/social_block_links/action/delete_addon_post.php',
            data: {
                name: 'social_block_links',
                id: '<?php echo htmlspecialchars($_GET['id']); ?>',
                addon_post_id: addonId
            },
            success: function(response) {
                window.location.href = 'addons_model.php?name=social_block_links&id=<?php echo htmlspecialchars($_GET['id']); ?>';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    }

    let counter = 1;

    function removeFields(...elements) {
        elements.forEach(el => el.remove());
    }

    function addFields() {
        const container = document.getElementById("dynamicFields");

        const nameLabel = document.createElement("label");
        nameLabel.setAttribute("for", `FormControlInput_social_profiles_link_${counter}`);
        nameLabel.innerHTML = "<?php echo htmlspecialchars(t('Profile name'));?>";

        const nameInput = document.createElement("input");
        nameInput.type = "text";
        nameInput.className = "form-control";
        nameInput.name = `profiles_name_${counter}`;
        nameInput.id = `FormControlInput_social_profiles_link_${counter}`;
        nameInput.placeholder = "Profile name";
        nameInput.required = true;

        const urlLabel = document.createElement("label");
        urlLabel.setAttribute("for", `FormControl_social_profiles_link_urlInput_${counter}`);
        urlLabel.innerHTML = "<?php echo htmlspecialchars(t('URL link to profile'));?>";

        const urlInput = document.createElement("input");
        urlInput.type = "text";
        urlInput.className = "form-control";
        urlInput.name = `social_profiles_link_url_${counter}`;
        urlInput.id = `FormControl_social_profiles_link_urlInput_${counter}`;
        urlInput.placeholder = "url link";
        urlInput.required = true;

        const iconLabel = document.createElement("label");
        iconLabel.setAttribute("for", `FormControl_fa_icone_code_Input_${counter}`);
        iconLabel.innerHTML = "<?php echo htmlspecialchars(t('profile fa icon code'));?>";

        const iconInput = document.createElement("textarea");
        iconInput.className = "form-control";
        iconInput.name = `fa_icone_code_${counter}`;
        iconInput.id = `FormControl_fa_icone_code_Input_${counter}`;
        iconInput.placeholder = "fa icone code";
        iconInput.required = true;

        const removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.innerHTML = "<?php echo htmlspecialchars(t('Remove'));?>";
        removeButton.className = "btn btn-danger";
        removeButton.style.float = "right"; 
        removeButton.onclick = function() {
            removeFields(nameLabel, nameInput, urlLabel, urlInput, iconLabel, iconInput, removeButton);
        };

        const clearfix = document.createElement("div"); 
        clearfix.style.clear = "both"; 

        container.appendChild(removeButton); 
        container.appendChild(nameLabel);
        container.appendChild(nameInput);
        container.appendChild(urlLabel);
        container.appendChild(urlInput);
        container.appendChild(iconLabel);
        container.appendChild(iconInput);
        container.appendChild(clearfix);

        counter++;
    }
</script>