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

    
    function getCurrentPageUrl($db, $prefix) {
        $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_settings");
        $stmt->execute();
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Čia nustatome protokolą automatiškai pagal tai, ar yra naudojamas SSL
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
        
        $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $menus = getMenuItems($db, $prefix);
        $default_url_name = 'index';
        
        if($settings['pretty_url'] == 1){
            foreach ($menus as $menu) {
                $menu_url = $protocol . $_SERVER['HTTP_HOST'] . '/' . $menu['page_url'];
                if ($current_url == $menu_url) {
                    return $menu['page_url'];
                }
            }
        } else{
            foreach ($menus as $menu) {
                $menu_url = $protocol . $_SERVER['HTTP_HOST'] . '/?page=' . $menu['page_url'];
                if ($current_url == $menu_url) {
                    return $menu['page_url'];
                }
            }
        }
        return $default_url_name;
    }
    
    
    function getBaseUrl() {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
        $domain = $_SERVER['HTTP_HOST'];
        return $protocol . "://" . $domain;
    }
    
    
function getTemplates($dir, $templateName) {
    $templateFiles = glob($dir . $templateName . "/template/template_*.php");
    $templates = [];

    foreach ($templateFiles as $file) {
        $templates[] = basename($file, ".php");
    }

    return $templates;
}

function getSettings($db, $prefix) {
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_settings");

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    function updateSettings($db, $prefix, $site_title, $meta_description, $footer_text, $pretty_url, $bilingualism, $language, $posts_per_page, $registration_enabled, $session_lifetime, $default_keywords, $brand_icone) {
        $stmt = $db->prepare("UPDATE ".$prefix['table_prefix']."_flussi_settings  SET site_title = :site_title, meta_description = :meta_description, footer_text = :footer_text, pretty_url = :pretty_url, bilingualism = :bilingualism, language = :language, posts_per_page = :posts_per_page, registration_enabled = :registration_enabled, session_lifetime = :session_lifetime, default_keywords = :default_keywords" . ($brand_icone != "" ? ", brand_icone = :brand_icone" : ""));
        $stmt->bindParam(':site_title', $site_title, PDO::PARAM_STR);
        $stmt->bindParam(':meta_description', $meta_description, PDO::PARAM_STR);
        $stmt->bindParam(':footer_text', $footer_text, PDO::PARAM_STR);
        $stmt->bindParam(':pretty_url', $pretty_url, PDO::PARAM_INT);
        $stmt->bindParam(':bilingualism', $bilingualism, PDO::PARAM_INT);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->bindParam(':posts_per_page', $posts_per_page, PDO::PARAM_INT);
        $stmt->bindParam(':registration_enabled', $registration_enabled, PDO::PARAM_INT);
        $stmt->bindParam(':session_lifetime', $session_lifetime, PDO::PARAM_STR);
        $stmt->bindParam(':default_keywords', $default_keywords, PDO::PARAM_STR);
        
        if ($brand_icone != "") {
            $stmt->bindParam(':brand_icone', $brand_icone, PDO::PARAM_STR);
        }
        
        return $stmt->execute();
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

    function initializeSystem() {
        $configurations = require 'security/config.php';
        require_once 'core/functions/functions.php';
        $config = $configurations['config'];
        $prefix = $configurations['prefix'];
    
        if (isset($config['display_errors']) && $config['display_errors']) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    
        if (
            empty($config['db_host']) ||
            empty($config['db_user']) ||
            empty($config['db_password']) ||
            empty($config['db_name']) 
        ) {
            header("Location: install/install-flusity.php");
            exit;
        }
    
        try {
            $db = getDBConnection($config);
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            header("Location: install/install-flusity.php");
            exit;
        }
    
        return array($db, $config, $prefix);
    }

    function remove_duplicates_by_key($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    function displayPlace($db, $prefix, $page_url, $place_name, $admin_label = null) {
    
        $settings = getSettings($db, $prefix);
        $lang_code = $settings['language']; // Kalbos kodas
        $class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight' : '';
        $placeIdGet = getPlaceIdByName($db, $prefix, $place_name);
        echo '<div class="customblock-container ' . $class;

        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            echo ' droppable-area';
            echo '" data-place-id="' . $placeIdGet;
        }
        
        echo '">';
        
        $current_lang = $_SESSION['lang'] ?? $lang_code;
       
        $customblocks = getCustomBlocksByUrlNameAndPlace($db, $prefix, $page_url, $place_name, $current_lang);
            /*    echo '<pre>';
            var_dump($customblocks);
            echo '</pre>'; */
        if (empty($customblocks) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
            //echo $placeIdGet;
        }
        $addonsDirectory = $_SERVER['DOCUMENT_ROOT'] . '/cover/addons/';
        $latestUpdates = [];
        $allAddons = [];
        
        foreach (glob($addonsDirectory . "/*", GLOB_ONLYDIR) as $dir) {
            $contentAddonsName = basename($dir);
            $addons = getAddonsByUrlNameAndPlace($db, $prefix, $contentAddonsName, $page_url, $place_name, $latestUpdates);
            $tableName = $prefix['table_prefix'] . "_" . $contentAddonsName;
        
            foreach ($addons as $currentAddon) {
                $getAllAddonTimes = getLatestUpdateTimeForAddonTable($db, $tableName);
                $currentAddon['latestUpdateTime'] = $getAllAddonTimes;
                $currentAddon['contentAddonsName'] = $contentAddonsName;
                $allAddons[] = $currentAddon;
            }
        }
        
        usort($allAddons, function($a, $b) {
            return strcmp($b['latestUpdateTime'], $a['latestUpdateTime']);
        });
        
        $combinedArray = [];

        foreach ($customblocks as $customBlock) {
            $customBlock['type'] = 'customBlock';
            if (isset($customBlock['updated'])) {
                $customBlock['latestUpdateTime'] = $customBlock['updated'];
            } else {
                $customBlock['latestUpdateTime'] = null; 
            }
            $combinedArray[] = $customBlock;
        }

        foreach ($allAddons as $currentAddon) {
            $currentAddon['type'] = 'addon';
            $currentAddon['latestUpdateTime'] = $currentAddon['latestUpdateTime'];
            $combinedArray[] = $currentAddon;
        }

        usort($combinedArray, function($a, $b) {
            return strcmp($b['latestUpdateTime'], $a['latestUpdateTime']);
        });
        
        foreach ($combinedArray as $item) {
            if ($item['type'] === 'customBlock') {
                $blockName = isset($item['dynamic_name']) ? htmlspecialchars_decode($item['dynamic_name']) : ''; 
                $blockHtmlCode = isset($item['dynamic_content']) ? htmlspecialchars_decode($item['dynamic_content']) : '';
        
                echo '<div class="widget-'. $item['id'] .' highlight-drag"';
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    echo ' data-block-id="' . $item['id'] . '"  data-block-type="customblock"';
                }
                echo '>';
                if ($admin_label) {
                    echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
                } else {
                    echo '<h3>' . htmlspecialchars($blockName) . '</h3>'; 
                }
                echo '<div>' . $blockHtmlCode . '</div>';
                echo '</div>';
        
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    echo '<a href="/core/tools/customblock.php?edit_customblock_id='.$item['id'].'" class="edit-link"><img src="core/tools/img/pencil.png" width="20px" title="'.t("Edit Block").'"></a>';
                }
            } else if ($item['type'] === 'addon') {
                echo '<div class="widget-' . $item['id'] . '"';
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    echo ' data-block-id="' . $item['id'] . '" data-block-type="addon"';
                    echo ' data-addon-name="' . $item['contentAddonsName'] . '"';
                }
                echo '>';
        
                $viewPath = $addonsDirectory . '/' . $item['contentAddonsName'] . "/view.php";
        
                if (file_exists($viewPath)) {
                    $addon = $item;
                    require_once ($viewPath);
                }
                echo '</div>';
            }
        }
        
        
    
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        echo '
        <div class="myDropdown">
            <button class="add-link">
                <img src="core/tools/img/plus.png" width="20px" title="'. t("Add New") .'">
            </button>
            <div class="myDropdown-menu">
                <button class="add-option-btn dropdown-item" onclick="window.location.href=\'/core/tools/customblock.php?customblock_place=' . htmlspecialchars($place_name) . '\'">+ Customblock</button>
                <button class="add-option-btn dropdown-item addons-button">+ Addons</button>
                <div id="addons-menu">';
               
                $allAddons = getAllAddons($db, $prefix);
                foreach ($allAddons as $addon) { 
                    $displayName = str_replace("_", " ", $addon['name_addon']);
                    $menuName = getMenuIdByPageUrl($db, $prefix, $page_url);
                    echo '<button class="add-option-btn dropdown-item" onclick="window.location.href=\'/core/tools/addons_model.php?name=' . $addon['name_addon'] . '&id=' . $addon['id'] . '&place_name=' . htmlspecialchars($place_name) . '&menu='.$menuName.'\'">' . htmlspecialchars($displayName) . '</button>';
                }
                    echo '</div>
                        </div>
                    </div>';
        }
        echo '</div>';
    }
    
    

    function getDataFromDatabase($db, $prefix, $page_url, $place_id) {

        $query = "SELECT * FROM {$prefix}_places WHERE page_url = ? AND place_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $page_url, $place_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    function includeThemeTemplate($themeName, $templateName, $db, $prefix) {
        global $db,
        $prefix, 
        $meta, 
        $site_title, 
        $site_brand_icone, 
        $posts, $menu_id, 
        $url, $total_urls, 
        $settings, 
        $footer_text, 
        $bilingualism, 
        $lang_code, 
        $blockId,
        $translations;  
       
        $templateDirectory = "cover/themes/{$themeName}/template/";
        $templateFilePath = $templateDirectory . $templateName . '.php';
        
        if (file_exists($templateFilePath)) {
            require_once $templateFilePath;
        } else {
            echo t("Template {$templateName} not found!");
        }
    }
    
    
    
    require_once 'f_users.php';
    require_once 'f_contact_form.php';
    require_once 'f_backup.php';
    require_once 'f_posts.php';
    require_once 'f_menu.php';
    require_once 'f_customblock.php';
    require_once 'f_files.php';
    require_once 'f_places.php';
    require_once 'f_translations.php';
    require_once 'f_themes.php';
    require_once 'f_addons.php';
    