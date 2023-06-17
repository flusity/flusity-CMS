<?php 
/* function installAddon222222($db, $addonName) {
    // Check if addon exists
    $addons = getAllAddons($db);
    $addonExists = array_values(array_filter($addons, function ($addon) use ($addonName) {
        return $addon['name_addon'] === $addonName;
    }));

    if (empty($addonExists)) {
        echo "Addon does not exist";
        return false;
    }

    $addonToInstall = $addonExists[0];

    // If addon exists, then insert 
    try {
        $stmt = $db->prepare("INSERT INTO tjd_addons (name_addon, description_addon, active, version, author) VALUES (:name_addon, :description_addon, :active, :version, :author)");
        $stmt->bindParam(':name_addon', $addonName);
        $stmt->bindParam(':description_addon', $addonToInstall['description_addon']);
        $active = 1;  
        $stmt->bindParam(':active', $active, PDO::PARAM_INT); // Bind as integer
        $stmt->bindParam(':version', $addonToInstall['version']);
        $stmt->bindParam(':author', $addonToInstall['author']);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }

    return true;
}



function getAllAddons222222($db) {
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
                    
                    // Fetch active status from the database
                    $stmt = $db->prepare("SELECT active FROM tjd_addons WHERE name_addon = :name_addon");
                    $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
                    $stmt->execute();
                    $active = $stmt->fetchColumn();

                    $addons[] = [
                        'name_addon' => $name_addon,
                        'version' => $version,
                        'author' => $author,
                        'description_addon' => $description_addon,
                        'addons_thumb' => $addonsThumbUrl,
                        'active' => $active
                    ];
                }
            }
        }
    }

    return $addons;
}


function getCurrentAddon2222222($db) {
    $stmt = $db->prepare("SELECT name_addon FROM tjd_addons LIMIT 1");
    $stmt->execute();
    return $stmt->fetchColumn();
}

 */


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

        // Check if addon already exists in the database
        $stmt = $db->prepare("SELECT * FROM tjd_addons WHERE name_addon = :name_addon");
        $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
        $stmt->execute();
        $addonExists = $stmt->fetch(PDO::FETCH_ASSOC);

        // If addon does not exist in the database, insert it
        if (!$addonExists) {
            $stmt = $db->prepare("INSERT INTO tjd_addons (name_addon, version, author, description_addon, active) VALUES (:name_addon, :version, :author, :description_addon, :active)");
            $stmt->bindParam(':name_addon', $name_addon, PDO::PARAM_STR);
            $stmt->bindParam(':version', $version, PDO::PARAM_STR);
            $stmt->bindParam(':author', $author, PDO::PARAM_STR);
            $stmt->bindParam(':description_addon', $description_addon, PDO::PARAM_STR);
            $active = 1;  // Add this line
            $stmt->bindParam(':active', $active, PDO::PARAM_INT);  // And this line
            // $stmt->execute();
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
