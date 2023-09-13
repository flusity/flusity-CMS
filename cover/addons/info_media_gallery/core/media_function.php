<?php

function getMediaItemsByAddonId($db, $prefix, $addonId) {
    $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_info_media_gallery_item WHERE id_info_media_gallery = :id");
    $stmt->bindParam(':id', $addonId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>