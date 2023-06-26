<?php
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
function displayAddon($db, $prefix, $page_url, $place_name, $admin_label = null) {
    $addon_name="jd_simple_zer";
    $addons = getAddonsByUrlNameAndPlace($db, $prefix, $addon_name, $page_url, $place_name);

    foreach ($addons as $addon) {
        echo '<div class="customblock-widget">';
        if ($admin_label) {
            echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
        } else {
            echo '<h3>' . htmlspecialchars($addon['title']) . '</h3>';
        }
        echo '<div>' . $addon['description'] . '</div>';
        echo '<div><img src="' . $addon['img_url'] . '" title="' . htmlspecialchars($addon['title']) . '"/></div>';
        echo '</div>';
    }
}
?>