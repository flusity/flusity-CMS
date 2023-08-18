<?php $lang_code = $settings['language'];
$current_lang = $_SESSION['lang'] ?? $lang_code; ?>
<div class="custom-dropdown" onclick="toggleDropdown()">
    <div class="selected-option">
        <div class="flag <?php echo $current_lang; ?>"></div>
    </div>
    <div class="options">
        <div class="option" data-value="?lang=en">
            <div class="flag en"></div>
        </div>
        <div class="option" data-value="?lang=<?php echo $lang_code;?>">
            <div class="flag <?php echo $lang_code;?>"></div>
        </div>
    </div>
</div>