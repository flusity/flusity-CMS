<?php
function getCustomBlocksByUrlNameAndCategory($db, $page_url, $category_name) {
    $stmt = $db->prepare("SELECT custom_blocks.* FROM custom_blocks JOIN menu ON custom_blocks.menu_id = menu.id JOIN categories ON custom_blocks.category_id = categories.id WHERE menu.page_url = :page_url AND categories.name = :category_name");
    $stmt->bindParam(':page_url', $page_url, PDO::PARAM_STR);
    $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
}

function displayCustomBlockByCategory($db, $page_url, $category_name, $admin_label = null) {
    $customblocks = getCustomBlocksByUrlNameAndCategory($db, $page_url, $category_name);

    foreach ($customblocks as $customBlock) {
        echo '<div class="customblock-widget">';
        if ($admin_label) {
            echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
        } else {
            echo '<h3>' . htmlspecialchars($customBlock['name']) . '</h3>';
        }
        echo '<div>' . $customBlock['html_code'] . '</div>';
        echo '</div>';
    }
}

?>