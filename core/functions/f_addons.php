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


function installAddon($db, $name_addon) {
    $addonsDirectory = $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/';
    $addonDetailsPath = $addonsDirectory . $name_addon . '/' . $name_addon . '.php';
    if(file_exists($addonDetailsPath)) {
        include $addonDetailsPath;

        // Check if addon already exists
        $stmt = $db->prepare("SELECT * FROM tjd_addons WHERE name_addon = :name_addon");
        $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
        $stmt->execute();
        $addonExists = $stmt->fetch(PDO::FETCH_ASSOC);

        // If addon does not exist in the database
        if (!$addonExists) {
            $stmt = $db->prepare("INSERT INTO tjd_addons (name_addon, version, author, description_addon, sidebar_id, active, show_front) VALUES (:name_addon, :version, :author, :description_addon, :sidebar_id, :active, :show_front)");
            $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
            $stmt->bindParam(':version', $version, PDO::PARAM_STR);
            $stmt->bindParam(':author', $author, PDO::PARAM_STR);
            $stmt->bindParam(':description_addon', $description_addon, PDO::PARAM_STR);
            $active = 1;  
            $sidebar_id = 8;
            $show_front = 0;
            $stmt->bindParam(':sidebar_id', $sidebar_id, PDO::PARAM_INT);
            $stmt->bindParam(':active', $active, PDO::PARAM_INT); 
            $stmt->bindParam(':show_front', $show_front, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
}


function getAllAddons($db) {
    $stmt = $db->prepare("SELECT * FROM tjd_addons");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isActiveAddon($addonName, $db) {
    $query = $db->prepare('SELECT active FROM tjd_addons WHERE name_addon = :name');
    $query->execute([':name' => $addonName]);
    $addon = $query->fetch();

    return $addon && $addon['active'] == 1;
}

function uninstallAddon($db, $name_addon) {
    $stmt = $db->prepare("DELETE FROM tjd_addons WHERE name_addon = :name_addon");
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

function totalAddons($db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM tjd_addons");
    $stmt->execute();
    
    $totalAddons = $stmt->fetchColumn();
    
    return $totalAddons;
}
function updateAddonShowFront($db, $name_addon, $show_front) {
    $stmt = $db->prepare("UPDATE tjd_addons SET show_front = :show_front WHERE name_addon = :name_addon");
    $stmt->bindParam(':show_front', $show_front, PDO::PARAM_INT);
    $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
    return $stmt->execute();
}
