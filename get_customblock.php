<?php
function getCustomBlocksByUrlNameAndPlace($db, $page_url, $place_name) {
    $stmt = $db->prepare("SELECT v_custom_blocks.* FROM v_custom_blocks JOIN menu ON v_custom_blocks.menu_id = menu.id JOIN places ON v_custom_blocks.place_id = places.id WHERE menu.page_url = :page_url AND places.name = :place_name");
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':place_name', $place_name, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
}

function displayCustomBlockByPlace($db, $page_url, $place_name, $admin_label = null) {
    $customblocks = getCustomBlocksByUrlNameAndPlace($db, $page_url, $place_name);

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