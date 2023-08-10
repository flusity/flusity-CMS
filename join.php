<?php 
$site_title = isset($settings['site_title']) ? $settings['site_title'] : '';
$menu_id = isset($menu['id']) ? $menu['id'] : null; 
$site_brand_icone = isset($settings['brand_icone']) ? $settings['brand_icone'] : '';
$meta_default_description = isset($settings['meta_description']) ? $settings['meta_description'] : '';
$meta_default_keywords = isset($settings['default_keywords']) ? $settings['default_keywords'] : '';
$footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';
$meta = [
    'description' => $meta_default_description,
    'keywords' => $meta_default_keywords,
];

if (!empty($postSeo)) {
    foreach ($postSeo as $postS) {
        if ($postS['priority'] == 1) {
        
            $meta['description'] = $postS['description'];
            $meta['keywords'] = $postS['keywords'];
            break;
        }
    }
}
?>