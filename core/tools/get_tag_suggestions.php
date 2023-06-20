<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

 $db = getDBConnection($config);
secureSession($db, $prefix);
$input = isset($_POST['input']) ? trim($_POST['input']) : '';

$tags = getTagSuggestionsFromDatabase($db, $prefix, $input);

//file_put_contents('debug.txt', json_encode($tags));
// Siunčiamas žymių pasiūlymus JSON formatu

header('Content-Type: text/html');

echo json_encode($tags);

function getTagSuggestionsFromDatabase($db, $prefix, $input) {
    $query = "SELECT DISTINCT `tags` FROM `posts` WHERE `tags` LIKE :input LIMIT 10";
    $stmt = $db->prepare($query);
    $search_term = '%' . $input . '%';
    $stmt->bindValue(':input', $search_term, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->get_result();
    $tags = [];

    while ($row = $result->fetch_assoc()) {
        $tags = array_merge($tags, explode(',', $row['tags']));
    }

    // Filtruoja unikalias žymes ir grąžina tik tas, kurios atitinka įvestį
    $filtered_tags = [];
    foreach ($tags as $tag) {
        if (stripos($tag, $input) !== false && !in_array($tag, $filtered_tags)) {
            $filtered_tags[] = $tag;
        }
    }

    return $filtered_tags;
}


?>