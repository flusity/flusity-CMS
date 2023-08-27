<?php
   
        $class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight' : '';

        echo '<div class="customblock-widget-'.$addon['id']. '  '. $class . '">';
        if ($admin_label) {
            echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
        } else {
            echo '<h3>' . htmlspecialchars($addon['title']) . '</h3>';
        }
        echo '<div>' . $addon['description'] . '</div>';
        echo '<div><img src="' . $addon['img_url'] . '" title="' . htmlspecialchars($addon['title']) . '" width="200px"/></div>';
        displayAddonEditButton($db, $prefix, $addon, 'jd_simple');

        echo '</div>';
    
?>
