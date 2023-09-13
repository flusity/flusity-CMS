<?php
$settings = getSettings($db, $prefix);
$lang_code = $settings['language']; // Kalbos kodas
$current_lang = $_SESSION['lang'] ?? $lang_code;

$class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight-drag' : '';

$stmt = $db->prepare("SELECT * FROM  ". $prefix['table_prefix'] ."_info_media_gallery WHERE id = :addon_id");
$stmt->bindParam(':addon_id', $addon['id'], PDO::PARAM_INT);
$stmt->execute();
$galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);
$galleryStyleCss = $addon['gallery_css_style_settings'];

    echo '<div id="styleCss" class="gallery-container ' . $class . '" data-style-css="'. $galleryStyleCss .'">';
    if (isset($admin_label)) {
        echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
    }
    foreach ($galleries as $gallery) {

        $stmt = $db->prepare("SELECT * FROM ". $prefix['table_prefix'] ."_info_media_gallery_item WHERE id_info_media_gallery = :gallery_id");
        $stmt->bindParam(':gallery_id', $gallery['id'], PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
        $image_id = $item['media_file_id'];  
        
            $file_stmt = $db->prepare("SELECT url FROM " . $prefix['table_prefix'] . "_flussi_files WHERE id = :file_id");
            $file_stmt->bindParam(':file_id', $image_id, PDO::PARAM_INT);
            $file_stmt->execute();
            $file_data = $file_stmt->fetch(PDO::FETCH_ASSOC);
            $file_url = $file_data['url'] ?? ''; 

            echo '<div class="image-card" data-desc="' . htmlspecialchars($item['media_description']) . '">';
        echo '<img src="' . $file_url . '" alt="' . htmlspecialchars($item['title']). '">';
            echo '</div>';
        }
  } 
    displayAddonEditButton($db, $prefix, $addon, 'info_media_gallery');
    echo '</div>';
?>