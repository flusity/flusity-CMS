<?php 
function getAllThemes() {
    $themesDirectory = $_SERVER['DOCUMENT_ROOT'] . '/cover/themes/';
    $dirContent = scandir($themesDirectory);
    $themes = [];
    
    foreach($dirContent as $content) {
        if($content != '.' && $content != '..') {
            $themeDirectory = $themesDirectory . $content;
            if(is_dir($themeDirectory)) {
                $themeDetailsPath = $themeDirectory . '/up.php';
                if(file_exists($themeDetailsPath)) {
                    include $themeDetailsPath;
                    $themeThumbPath = $themeDirectory . '/' . $theme . '.png';
                    if(file_exists($themeThumbPath)) {
                        $themeThumbUrl = '/cover/themes/' . $content . '/' . $theme . '.png';
                    } else {
                        $themeThumbUrl = 'defaultThemeImage.png'; // default image path if specific theme image does not exist
                    }
                    
                    $themes[] = [
                        'name' => $theme,
                        'version' => $version,
                        'author' => $author,
                        'description' => $description,
                        'theme_thumb' => $themeThumbUrl
                    ];
                }
            }
        }
    }
    
    return $themes;
}

function updateThemeSetting($db, $prefix, $themeName) {
    $stmt = $db->prepare("UPDATE ".$prefix['table_prefix']."_flussi_settings SET theme = :theme");
    $stmt->bindParam(':theme', $themeName, PDO::PARAM_STR);
    return $stmt->execute();
}

function getCurrentTheme($db, $prefix) {
    $stmt = $db->prepare("SELECT theme FROM ".$prefix['table_prefix']."_flussi_settings LIMIT 1");
    $stmt->execute();
    return $stmt->fetchColumn();
}
function getThemePath($db, $prefix, $filename) {
    $settings = getSettings($db, $prefix);
    $templateName = $settings['theme'];
    return "cover/themes/{$templateName}/{$filename}";
}

?>