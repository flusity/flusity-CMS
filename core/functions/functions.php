<?php

function getDBConnection($config) {
    try {
        $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO($dsn, $config['db_user'], $config['db_password'], $options);
    } catch (PDOException $e) {
        die('Nepavyko prisijungti prie duomenų bazės: ' . $e->getMessage());
    }
}

function getFullUrl($relativePath) {
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    return $base_url . $relativePath;
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

    function findNameById($id, $items) {
        foreach ($items as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
        return null;
    }

    
    function getCurrentPageUrl($db) {
        // Gaukite nustatymus iš duomenų bazės
        $stmt = $db->prepare("SELECT * FROM settings");
        $stmt->execute();
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $menus = getMenuItems($db);
    
        // Nustato numatytąjį URL pavadinimą
        $default_url_name = 'index';
        
        // Jei pretty_url nustatymas yra 1, tikrina "gražų" URL
        if($settings['pretty_url'] == 1){
            foreach ($menus as $menu) {
                $menu_url = "http://" . $_SERVER['HTTP_HOST'] . '/' . $menu['page_url'];
                if ($current_url == $menu_url) {
                    return $menu['page_url'];
                }
            }
        } else{
            foreach ($menus as $menu) {
                $menu_url = "http://" . $_SERVER['HTTP_HOST'] . '/?page=' . $menu['page_url'];
                if ($current_url == $menu_url) {
                    return $menu['page_url'];
                }
            }
        }
    
        // Jei nerandamas joks kitas URL pavadinimas, grąžina numatytąjį
        return $default_url_name;
    }
    
    
    
    function getTemplates($dir) {
        $templateFiles = glob($dir . "/template_*.php");
        $templates = [];
    
        foreach ($templateFiles as $file) {
            $templates[] = basename($file, ".php");
        }
    
        return $templates;
    }

    function getSettings($db) {
        $stmt = $db->prepare("SELECT * FROM settings");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    function updateSettings($db, $site_title, $meta_description, $footer_text, $pretty_url, $language, $posts_per_page, $registration_enabled, $session_lifetime, $default_keywords) {
        $stmt = $db->prepare("UPDATE settings SET site_title = :site_title, meta_description = :meta_description, footer_text = :footer_text, pretty_url = :pretty_url, language = :language, posts_per_page = :posts_per_page, registration_enabled = :registration_enabled, session_lifetime = :session_lifetime, default_keywords = :default_keywords");
        $stmt->bindParam(':site_title', $site_title, PDO::PARAM_STR);
        $stmt->bindParam(':meta_description', $meta_description, PDO::PARAM_STR);
        $stmt->bindParam(':footer_text', $footer_text, PDO::PARAM_STR);
        $stmt->bindParam(':pretty_url', $pretty_url, PDO::PARAM_INT);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->bindParam(':posts_per_page', $posts_per_page, PDO::PARAM_INT);
        $stmt->bindParam(':registration_enabled', $registration_enabled, PDO::PARAM_INT);
        $stmt->bindParam(':session_lifetime', $session_lifetime, PDO::PARAM_STR);
        $stmt->bindParam(':default_keywords', $default_keywords, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    
    function createBackupFilename($db) {
        $names = [
            ['Emily', 'Sophia', 'Amelia', 'Harper', 'Evelyn', 'Abigail', 'Ella', 'Ava', 'Sophie', 'Isabella'],
            ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor']
        ];
    $firstName = $names[0][array_rand($names[0])];
    $lastName = $names[1][array_rand($names[1])];
    $randomCode = rand(1000, 9999);
    $timestamp = date('Y-m-d_H-i-s');
    $filename = "{$firstName}_{$lastName}_{$randomCode}_{$timestamp}.sql";
    return $filename;
}

function createDatabaseBackup($db, $backupFilename) {
    $tables = [];
    $result = $db->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }

    $backupFileContent = '';
    foreach ($tables as $table) {
        $result = $db->query("SELECT * FROM $table");
        $numFields = $result->columnCount();

        $backupFileContent .= "DROP TABLE IF EXISTS $table;";
        $row2 = $db->query("SHOW CREATE TABLE $table")->fetch(PDO::FETCH_NUM);
        $backupFileContent .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $numFields; $i++) {
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $backupFileContent .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $numFields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $backupFileContent .= '"' . $row[$j] . '"';
                        } else {
                        $backupFileContent .= '""';
                        }
                        if ($j < ($numFields - 1)) {
                        $backupFileContent .= ',';
                        }
                        }
                        $backupFileContent .= ");\n";
                        }
                        }
                        $backupFileContent .= "\n\n\n";
                        }
                        $backupFolder = 'backups/';
                        if (!is_dir($backupFolder)) {
                            mkdir($backupFolder, 0777, true);
                        }
                        
                        $backupFilepath = $backupFolder . $backupFilename;
                        if (file_put_contents($backupFilepath, $backupFileContent)) {
                            return true;
                        } else {
                            return false;
                        }
}                        
    
    function getBackupFilesList($backupDir) {
        $files = array_diff(scandir($backupDir), array('..', '.'));
        $backupFiles = [];
        foreach ($files as $file) {
            if (is_file($backupDir . $file)) {
                $backupFiles[] = $file;
            }
        }
        usort($backupFiles, function($a, $b) use ($backupDir) {
            return filemtime($backupDir . $b) - filemtime($backupDir . $a);
        });

        return $backupFiles;
    }

        
    function getContactFormSettings($db) {
        $stmt = $db->prepare("SELECT * FROM `contact_form_settings`");
        $stmt->execute();
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $settings;
    }

    function createPagination($url, $total_urls) {
        ob_start();
        if($total_urls > 1) {
            echo '<div class="pagination">';
            if($url > 1) {
                echo '<a href="?url=1"><<</a>';
            }
            for($i = max(1, $url - 2); $i <= min($url + 2, $total_urls); $i++) {
                echo ($i == $url) ? '<a class="active" href="?url='.$i.'">'.$i.'</a>' : '<a href="?url='.$i.'">'.$i.'</a>';
            }
            if($url < $total_urls) {
                echo '<a href="?url='.$total_urls.'">>></a>';
            }
            echo '</div>';
        } 
        return ob_get_clean();
    }


    

    require_once 'f_users.php';
    require_once 'f_posts.php';
    require_once 'f_menu.php';
    require_once 'f_customblock.php';
    require_once 'f_files.php';
    require_once 'f_places.php';
    require_once 'f_translations.php';
    