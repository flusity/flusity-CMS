<?php
   foreach ($addons as $addon) {
    echo '<div class="addon-widget">';
    if ($admin_label) {
        echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
    } else {
        echo '<h3>' . htmlspecialchars($addon['title']) . '</h3>';
    }
    echo '<div>' . $addon['description'] . '</div>';
    echo '<div><img src="' . $addon['img_url'] . '" title="' . htmlspecialchars($addon['title']) . '" width="200px"/></div>';

    displayAddonEditButton($db, $prefix, $addon);

    echo '</div>';
}

?>
