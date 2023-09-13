<?php
function fetchGalleryItems($db, $prefix, $addon, $current_lang) {
    $result = [];

    $stmt = $db->prepare("SELECT * FROM  ". $prefix['table_prefix'] ."_info_media_gallery WHERE id = :addon_id");
    $stmt->bindParam(':addon_id', $addon['id'], PDO::PARAM_INT);
    $stmt->execute();
    $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($galleries as $gallery) {
        $stmt = $db->prepare("SELECT * FROM ". $prefix['table_prefix'] ."_info_media_gallery_item WHERE id_info_media_gallery = :gallery_id");
        $stmt->bindParam(':gallery_id', $gallery['id'], PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            $image_id = $item['media_file_id'];  
            $galleryTitle = ($current_lang == 'en' && !empty($item['lang_en_title'])) ? $item['lang_en_title'] : $item['title'];
            $galleryInfoDesc = ($current_lang == 'en' && !empty($item['lang_en_media_description'])) ? $item['lang_en_media_description'] : $item['media_description'];

            $file_stmt = $db->prepare("SELECT url FROM " . $prefix['table_prefix'] . "_flussi_files WHERE id = :file_id");
            $file_stmt->bindParam(':file_id', $image_id, PDO::PARAM_INT);
            $file_stmt->execute();
            $file_data = $file_stmt->fetch(PDO::FETCH_ASSOC);
            $file_url = $file_data['url'] ?? ''; 

            $result[] = ['title' => $galleryTitle, 'desc' => $galleryInfoDesc, 'url' => $file_url];
        }
    }

    return $result;
}

function getMediaItemsByAddonId($db, $prefix, $addonId) {
    $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_info_media_gallery_item WHERE id_info_media_gallery = :id");
    $stmt->bindParam(':id', $addonId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>