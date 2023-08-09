<?php
    foreach ($addons as $addon) {
        $class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight' : '';

        echo '<div class="customblock-widget-'.$addon['id']. '  '. $class . '">';
        if ($admin_label) {
            echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
        } else {
            
        }echo '<div class="card">';
        echo '<img class="card-img-top w-100 d-block" width="294" height="160" src="' . $addon['img_url'] . '" title="' . htmlspecialchars($addon['title']) . '" width="200px"/>
        <div class="card-body">
        <h4 class="card-title">' . htmlspecialchars($addon['title']) . '</h4>
        ';
        echo '<p class="card-text">' . $addon['description'] . '</p>
        <a href="' . htmlspecialchars($addon['readmore']) . '" class="btn btn-primary" id="readMoreButton" type="button" 
        style="background: rgba(255,231,229,0.6);box-shadow: 2px 3px 10px rgb(207,207,207);color: rgb(162,162,162);font-family: Anaheim, sans-serif;font-size: 17px;height: 46.5px;margin: 0px;padding: 12px 25px;width: 158.675px;">Read more</a>';

        displayAddonEditButton($db, $prefix, $addon, 'jd_simple_zer');

        echo '</div></div>
        </div>';
    }
?>    