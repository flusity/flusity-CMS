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




function getAllAddons($db, $prefix) {
    $stmt = $db->prepare("SELECT * FROM  ".$prefix['table_prefix']."_flussi_tjd_addons");
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

        if(isset($databaseDropScript)) {
            // Execute the database drop script
            $db->exec($databaseDropScript);
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

function uploadFile($uploaded_file, $db, $prefix, $subfolder = null) {
    
    if(!$subfolder) {
        $subfolder = "addon_default";
    }

    $unique_code = bin2hex(random_bytes(8));
    $filename_parts = pathinfo($uploaded_file["name"]);

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
    
    $stmt = $db->prepare("SELECT ".$prefix['table_prefix']."_".$addon.".* FROM ".$prefix['table_prefix']."_".$addon." JOIN ".$prefix['table_prefix']."_flussi_menu ON ".$prefix['table_prefix']."_".$addon.".menu_id = ".$prefix['table_prefix']."_flussi_menu.id JOIN ".$prefix['table_prefix']."_flussi_places ON ".$prefix['table_prefix']."_".$addon.".place_id = ".$prefix['table_prefix']."_flussi_places.id WHERE ".$prefix['table_prefix']."_flussi_tjd_addons.id = ".$prefix['table_prefix']."_".$addon.".addon_id AND ".$prefix['table_prefix']."_flussi_menu.page_url = :page_url AND ".$prefix['table_prefix']."_flussi_places.name = :place_name");
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':place_name', $place_name, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
}
