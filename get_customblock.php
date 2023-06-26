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

?>