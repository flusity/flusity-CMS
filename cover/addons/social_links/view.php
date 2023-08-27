<?php

// Gets the currently selected language from the session or uses the default
$settings = getSettings($db, $prefix);
$lang_code = $settings['language']; // Kalbos kodas
$current_lang = $_SESSION['lang'] ?? $lang_code;

//foreach ($addons as $addon) {
    
    $class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight' : '';
    // If English is selected and content is available, display English content. Otherwise - the default.
    $display_title = ($current_lang == 'en' && !empty($addon['lang_en_title'])) ? $addon['lang_en_title'] : $addon['title'];
      
    echo '<div class="custom-widget-' . $addon['id'] . ' ' . $class . '">';

    if ($admin_label) {
        echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
    } else { 
         //  posible functionality
    }
    echo '<div class="social-link-icon"><a href="' . htmlspecialchars($addon['social_link_url']) .'" title="' . htmlspecialchars($display_title) . '" alt="' . htmlspecialchars($display_title) . '">
    <img class="social-page" src="' . $addon['img_url'] . '" title="' . htmlspecialchars($display_title) . '"  alt="' . htmlspecialchars($display_title) . '"/></a></div>';

    displayAddonEditButton($db, $prefix, $addon, 'social_links');

    echo '</div>';
//}
?>
