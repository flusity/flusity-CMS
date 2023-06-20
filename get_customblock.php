<?php
function getCustomBlocksByUrlNameAndPlace($db, $prefix, $page_url, $place_name) {
    $stmt = $db->prepare("SELECT ".$prefix['table_prefix']."_flussi_v_custom_blocks.* FROM ".$prefix['table_prefix']."_flussi_v_custom_blocks JOIN ".$prefix['table_prefix']."_flussi_menu ON ".$prefix['table_prefix']."_flussi_v_custom_blocks.menu_id = ".$prefix['table_prefix']."_flussi_menu.id JOIN ".$prefix['table_prefix']."_flussi_places ON ".$prefix['table_prefix']."_flussi_v_custom_blocks.place_id = ".$prefix['table_prefix']."_flussi_places.id WHERE ".$prefix['table_prefix']."_flussi_menu.page_url = :page_url AND ".$prefix['table_prefix']."_flussi_places.name = :place_name");
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':place_name', $place_name, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
}

function displayCustomBlockByPlace($db, $prefix, $page_url, $place_name, $admin_label = null) {
    $customblocks = getCustomBlocksByUrlNameAndPlace($db, $prefix, $page_url, $place_name);

    foreach ($customblocks as $customBlock) {
        echo '<div class="customblock-widget">';
        if ($admin_label) {
            echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
        } else {
            echo '<h3>' . htmlspecialchars($customBlock['name']) . '</h3>';
        }
        echo '<div>' . $customBlock['html_code'] . '</div>';
        echo '</div>';
    }
}

?>