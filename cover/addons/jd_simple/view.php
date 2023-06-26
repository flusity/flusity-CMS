<?php

function displayAddon($db, $prefix, $page_url, $place_name, $admin_label = null) {
    $addon_name="jd_simple";
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