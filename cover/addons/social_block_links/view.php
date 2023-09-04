<?php

$settings = getSettings($db, $prefix);
$lang_code = $settings['language']; // Kalbos kodas
$current_lang = $_SESSION['lang'] ?? $lang_code;

$class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight' : '';

// If English is selected and content is available, display English content. Otherwise - the default.
$profiles_names = explode(',', $addon['profiles_name']);
$profiles_name = ($current_lang == 'en' && isset($profiles_names[0])) ? $profiles_names[0] : $profiles_names[0];

$social_profiles_link_urls = explode(',', $addon['social_profiles_link_url']);
$fa_icone_codes = explode(',', $addon['fa_icone_code']);

echo '<div class="custom-widget-' . $addon['id'] . ' ' . $class . '">';

if (isset($admin_label)) {
    echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
}
echo '<div class="social-link-icon">';
for ($i = 0; $i < count($profiles_names); $i++) {
    $profile_name = isset($profiles_names[$i]) ? $profiles_names[$i] : "";
    $social_profiles_link_url = isset($social_profiles_link_urls[$i]) ? $social_profiles_link_urls[$i] : "";
    $fa_icone_code = isset($fa_icone_codes[$i]) ? $fa_icone_codes[$i] : "";

    echo '<div class="social-link-icon-item">';
    echo '<a href="' . htmlspecialchars($social_profiles_link_url) . '"  target="_blank" title="' . htmlspecialchars($profile_name) . '" alt="' . htmlspecialchars($profile_name) . '">' . htmlspecialchars_decode($fa_icone_code) . '</a>';
    echo '</div>';
}
echo '</div>'; 
displayAddonEditButton($db, $prefix, $addon, 'social_block_links');
echo '</div>';

?>