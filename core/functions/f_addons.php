<?php 

function getAllSystemAddons() {
    $addonssDirectory = $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/';
    $dirContent = scandir($addonssDirectory);
    $addons = [];

    foreach($dirContent as $content) {
        if($content != '.' && $content != '..') {
            $addonsDirectory = $addonssDirectory . $content;
            if(is_dir($addonsDirectory)) {
                $addonsDetailsPath = $addonsDirectory . '/' . $content . '.php';
                if(file_exists($addonsDetailsPath)) {
                    include $addonsDetailsPath;
                    $addonsThumbPath = $addonsDirectory . '/thumbnail.png';
                    if(file_exists($addonsThumbPath)) {
                        $addonsThumbUrl = '/cover/addons/' . $content . '/thumbnail.png';
                    } else {
                        $addonsThumbUrl = '/core/tools/img/defaultAddonsImage.png';
                    }
                    
                    $addons[] = [
                        'name_addon' => $name_addon,
                        'version' => $version,
                        'author' => $author,
                        'description' => $description_addon,
                        'addons_thumb' => $addonsThumbUrl,
                    ];
                }
            }
        }
    }

    return $addons;
}

function installAddon($db, $prefix, $name_addon) {
    $addonsDirectory = $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/';
    $addonDetailsPath = $addonsDirectory . $name_addon . '/' . $name_addon . '.php';
    if(file_exists($addonDetailsPath)) {
        include $addonDetailsPath;

        // Check if addon already exists
        $stmt = $db->prepare('SELECT * FROM  '.$prefix['table_prefix'].'_flussi_tjd_addons WHERE name_addon = :name_addon');
        $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
        $stmt->execute();
        $addonExists = $stmt->fetch(PDO::FETCH_ASSOC);

        // If addon does not exist in the database
        if (!$addonExists) {
            $stmt = $db->prepare('INSERT INTO  '.$prefix['table_prefix'].'_flussi_tjd_addons (name_addon, version, author, description_addon, active, show_front) VALUES (:name_addon, :version, :author, :description_addon, :active, :show_front)');
            $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
            $stmt->bindParam(':version', $version, PDO::PARAM_STR);
            $stmt->bindParam(':author', $author, PDO::PARAM_STR);
            $stmt->bindParam(':description_addon', $description_addon, PDO::PARAM_STR);
            $active = 1;
            $show_front = 0;
            $stmt->bindParam(':active', $active, PDO::PARAM_INT); 
            $stmt->bindParam(':show_front', $show_front, PDO::PARAM_INT);
            $stmt->execute();

            // Check if there is a database script for the addon
            $addonDatabaseScriptPath = $addonsDirectory . $name_addon . '/' . $name_addon . '_data_base.php';
            if(file_exists($addonDatabaseScriptPath)) {
                include $addonDatabaseScriptPath;

                if(isset($databaseScript)) {
                    // Execute the database script
                    $stmt = $db->prepare($databaseScript);
                    $stmt->execute();
                }
            }

            return true;
        }
    }

    return false;
}


function getLatestUpdateTimeForAddonTable($db, $tableName) {
    $query = "SELECT MAX(updated) as latestUpdateTime FROM $tableName";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['latestUpdateTime'];
}

function getAllAddons($db, $prefix) {
   // $stmt = $db->prepare("SELECT * FROM  ".$prefix['table_prefix']."_flussi_tjd_addons");
      $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_tjd_addons ORDER BY updated_at DESC");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isActiveAddon($addonName, $db, $prefix) {
    $query = $db->prepare("SELECT active FROM  ".$prefix['table_prefix']."_flussi_tjd_addons WHERE name_addon = :name");
    $query->execute([':name' => $addonName]);
    $addon = $query->fetch();

    return $addon && $addon['active'] == 1;
}

function uninstallAddon($db, $prefix, $name_addon) {
    $addonsDirectory = $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/';
    $addonDatabaseScriptPath = $addonsDirectory . $name_addon . '/' . $name_addon . '_data_base.php';

    // Check if there is a database script for the addon 
    if(file_exists($addonDatabaseScriptPath)) {
        include $addonDatabaseScriptPath;
    
        if(isset($databaseDropScripts) && is_array($databaseDropScripts)) {  
            foreach($databaseDropScripts as $dropScript) {  
                $db->exec($dropScript);
            }
        }
    }

    // Delete addon images directory
    $imgDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $name_addon . '_img/';
    if(is_dir($imgDirectory)) {
        $files = array_diff(scandir($imgDirectory), array('.','..'));
        foreach ($files as $file) {
            unlink($imgDirectory . $file); 
        }
        rmdir($imgDirectory);
    }

    $stmt = $db->prepare("DELETE FROM  ".$prefix['table_prefix']."_flussi_tjd_addons WHERE name_addon = :name_addon");
    $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
    return $stmt->execute();
}


function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

function totalAddons($db, $prefix) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM  ".$prefix['table_prefix']."_flussi_tjd_addons");
    $stmt->execute();
    
    $totalAddons = $stmt->fetchColumn();
    
    return $totalAddons;
}
function updateAddonShowFront($db, $prefix, $name_addon, $show_front) {
    $stmt = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_tjd_addons SET show_front = :show_front WHERE name_addon = :name_addon');
    $stmt->bindParam(':show_front', $show_front, PDO::PARAM_INT);
    $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
    return $stmt->execute();
}
function getAddonId($db, $prefix, $name_addon) {
    $stmt = $db->prepare("SELECT id FROM  ".$prefix['table_prefix']."_flussi_tjd_addons WHERE name_addon = :name_addon");
    $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['id'] : null;
}
function getAddonById($db, $prefix, $name_addon, $addonId) {
    $query = 'SELECT * FROM '.$prefix['table_prefix'].'_'.$name_addon.' WHERE id = :addonId';
    $statement = $db->prepare($query);
    $statement->bindParam(':addonId', $addonId, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function displayAddonEditButton($db, $prefix, $addone, $currentAddonName) {
    $addons = getAllAddons($db, $prefix);
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        foreach ($addons as $addon) {
            if ($addon['name_addon'] == $currentAddonName) {
                $addon_id = getAddonId($db, $prefix, $addon['name_addon']);
                echo '<a href="/core/tools/addons_model.php?name='.$addon['name_addon'].'&id='.$addon_id.'&addon_post_edit_id='.$addone['id'].'" class="edit-link"><img src="core/tools/img/pencil.png" width="20px" title="'.t("Edit Addon").'"></a>';
                break;
            }
        }
    }
}

function getAddonIdByName($db, $prefix, $AddonName) {
    $stmt = $db->prepare('SELECT id FROM '.$prefix['table_prefix'].'_flussi_tjd_addons WHERE name_addon = :name_addon');
    $stmt->execute([':name_addon' => $AddonName]);
    $result = $stmt->fetch();

    return $result ? $result['id'] : null;
}

function uploadFile($uploaded_file, $db, $prefix, $subfolder = null) {
    // Nustatomos leidžiamos failų rūšys ir maksimalus dydis
    $allowed_file_types = ['image/png', 'image/jpeg', 'image/gif'];
    $allowed_extensions = ['png', 'jpeg', 'jpg', 'gif'];
    $max_file_size = 5 * 1024 * 1024; // 5 MB

    if(!$subfolder) {
        $subfolder = "addon_default";
    }

    // Patikrinama, ar failo tipas yra leidžiamų sąraše
    if (!in_array($uploaded_file['type'], $allowed_file_types)) {
        throw new Exception("Invalid file type.");
    }

    // Patikrinama, ar failo dydis neviršija maksimalaus leidžiamo dydžio
    if ($uploaded_file['size'] > $max_file_size) {
        throw new Exception("File size exceeded limit.");
    }

    $unique_code = bin2hex(random_bytes(8));
    $filename_parts = pathinfo($uploaded_file["name"]);

    // Patikrinama, ar failo plėtinys yra leidžiamų sąraše
    if (!in_array(strtolower($filename_parts['extension']), $allowed_extensions)) {
        throw new Exception("Invalid file extension.");
    }

    // Replacing space with underscore in the filename
    $filename = str_replace(' ', '_', $filename_parts['filename']);
    
    $new_filename = $filename . '_' . $unique_code . '.' . $filename_parts['extension'];

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
    $addonImages = $subfolder . "/";

    if (!is_dir($target_dir . $addonImages)) {
        mkdir($target_dir . $addonImages, 0777, true);
    }

    $target_file = $target_dir . $new_filename;
    $target_file_addon = $target_dir . $addonImages . $new_filename;

    if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {
        copy($target_file, $target_file_addon);

        $file_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $new_filename;
        $img_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $addonImages . $new_filename;
        $img_name = $new_filename;

        // Add the new file to the "files" table
        $stmt_files = $db->prepare("INSERT INTO " . $prefix['table_prefix'] . "_flussi_files (name, url) VALUES (:name, :url)");
        $stmt_files->bindParam(':name', $new_filename, PDO::PARAM_STR);
        $stmt_files->bindParam(':url', $file_url, PDO::PARAM_STR);
        $stmt_files->execute();

        return ['img_url' => $img_url, 'img_name' => $img_name];
    } else {
        throw new Exception("Error moving uploaded file.");
    }
}


function getAddonsByUrlNameAndPlace($db, $prefix, $addon, $page_url, $place_name) {
    try {
        $stmt = $db->prepare("SELECT ".$prefix['table_prefix']."_".$addon.".* FROM ".$prefix['table_prefix']."_".$addon." 
        LEFT JOIN ".$prefix['table_prefix']."_flussi_menu ON ".$prefix['table_prefix']."_".$addon.".menu_id = ".$prefix['table_prefix']."_flussi_menu.id 
        LEFT JOIN ".$prefix['table_prefix']."_flussi_places ON ".$prefix['table_prefix']."_".$addon.".place_id = ".$prefix['table_prefix']."_flussi_places.id 
        LEFT JOIN ".$prefix['table_prefix']."_flussi_tjd_addons ON ".$prefix['table_prefix']."_".$addon.".addon_id = ".$prefix['table_prefix']."_flussi_tjd_addons.id 
        WHERE (".$prefix['table_prefix']."_flussi_menu.page_url = :page_url OR ".$prefix['table_prefix']."_".$addon.".menu_id = 0) 
        AND ".$prefix['table_prefix']."_flussi_places.name = :place_name ORDER BY updated DESC, created DESC"); 

        $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
        $stmt->bindParam(':place_name', $place_name, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function getAllAddonsCSSFiles() {
    $baseDirectory = 'cover/addons/';
    $cssFiles = [];

    $addons = scandir($baseDirectory);

    foreach ($addons as $addon) {
        if ($addon != '.' && $addon != '..' && is_dir($baseDirectory . $addon)) {
            $cssDirectory = $baseDirectory . $addon . '/assets/css/';

            if (is_dir($cssDirectory)) {
                $files = scandir($cssDirectory);
                
                foreach ($files as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
                        $cssFiles[] = $cssDirectory . $file;
                    }
                }
            }
        }
    }

    return $cssFiles;
}


function printAllAddonsCSSFiles() {
    $cssFiles = getAllAddonsCSSFiles();
    foreach($cssFiles as $cssFile) {
        echo '<link rel="stylesheet" type="text/css" href="' . $cssFile . '">
        ';
    }
}

function getAllAddonsJSFiles() {
    $addonsDir = 'cover/addons/';
    $allJSFiles = [];

    $addons = scandir($addonsDir);

    foreach ($addons as $addon) {
        if ($addon !== '.' && $addon !== '..' && is_dir($addonsDir . $addon)) {
            $jsDir = $addonsDir . $addon . '/assets/js/';
            if (is_dir($jsDir)) {
                $jsFiles = scandir($jsDir);
                foreach ($jsFiles as $jsFile) {
                    if (pathinfo($jsFile, PATHINFO_EXTENSION) === 'js') {
                        $filePath = $jsDir . $jsFile;
                        $fileContents = file_get_contents($filePath);
                        if (strpos($fileContents, '/*head*/') !== false) {
                            $allJSFiles['head'][] = $filePath;
                        } elseif (strpos($fileContents, '/*footer*/') !== false) {
                            $allJSFiles['footer'][] = $filePath;
                        } // There are no conditions here, as nothing needs to be added if neither head nor footer is specified.
                    }
                }
            }
        }
    }
    return $allJSFiles;
}

function printAddonJSFiles($context = 'footer') {
    $jsFiles = getAllAddonsJSFiles();
    $scripts = '';
    
    if (isset($jsFiles[$context])) { 
        foreach ($jsFiles[$context] as $jsFile) {
            $scripts .= '    <script src="' . $jsFile . '"></script>' . PHP_EOL;
        }
    }
    echo $scripts;
}

function printAllAddonsAssets($context) {
    if ($context == 'head') {
        printAllAddonsCSSFiles();
    }
    printAddonJSFiles($context);
}