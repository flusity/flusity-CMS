<?php
require $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/info_media_gallery/core/media_function.php';
$settings = getSettings($db, $prefix);
$lang_code = $settings['language'];
$current_lang = $_SESSION['lang'] ?? $lang_code;
$class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight-drag' : '';
$galleryStyleCss = $addon['gallery_css_style_settings'];
$items = fetchGalleryItems($db, $prefix, $addon, $current_lang);
?>

<div id="styleCss" class="gallery-container d-flex <?= $class ?>" data-style-css="<?= $galleryStyleCss ?>">
    <?php if (isset($admin_label)): ?>
        <h3><?= htmlspecialchars($admin_label) ?></h3>
    <?php endif; ?>

    <?php foreach ($items as $item): ?>
        <div class="image-card" data-desc="<?= htmlspecialchars($item['desc']) ?>" style="width: calc(50% - 20px);">
            <img src="<?= $item['url'] ?>" alt="<?= htmlspecialchars($item['title']) ?>">
        </div>
    <?php endforeach; ?>
    
    <?php displayAddonEditButton($db, $prefix, $addon, 'info_media_gallery'); ?>
</div>