<?php

// Gets the currently selected language from the session or uses the default
$settings = getSettings($db, $prefix);
$lang_code = $settings['language']; // Kalbos kodas
$current_lang = $_SESSION['lang'] ?? $lang_code;


    $class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight' : '';
    $display_title = ($current_lang == 'en' && !empty($addon['lang_en_title'])) ? $addon['lang_en_title'] : $addon['title'];
      
    echo '<div class="customblock-widget-' . $addon['id'] . ' ' . $class . '">';

    if ($admin_label) {
        echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
    } else { 
      
    }

    echo '<div class="card">
    <img class="card-img-top w-100 d-block" width="294" height="160" src="' . $addon['img_url'] . '" title="' . htmlspecialchars($display_title) . '" width="200px"/>
    <div class="card-body">';

    // If English is selected and content is available, display English content. Otherwise - the default.
    $display_description = ($current_lang == 'en' && !empty($addon['lang_en_description'])) ? $addon['lang_en_description'] : $addon['description'];

    echo '<h4 class="card-title">' . htmlspecialchars($display_title) . '</h4>';
    echo '<p class="card-text">' . $display_description . '</p>';

    echo '<a href="' . htmlspecialchars($addon['readmore']) . '" class="btn btn-primary" id="readMoreButton" type="button" 
    style="background: rgba(255,231,229,0.6);box-shadow: 2px 3px 10px rgb(207,207,207);color: rgb(162,162,162);font-family: Anaheim, sans-serif;font-size: 17px;height: 46.5px;margin: 0px;padding: 12px 25px;width: 158.675px;">Read more</a>';

    displayAddonEditButton($db, $prefix, $addon, 'jd_simple_zer');

    echo '</div></div>
    </div>';

?>
