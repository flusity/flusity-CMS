<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

secureSession();
$db = getDBConnection($config);

$input = isset($_POST['input']) ? trim($_POST['input']) : '';

$tags = getTagSuggestionsFromDatabase($db, $input);

// Siunčia žymių pasiūlymus JSON formatu

header('Content-Type: application/json');

echo json_encode($tags);

function getTagSuggestionsFromDatabase($db, $input) {

    $query = "SELECT DISTINCT `tags` FROM `posts` WHERE `tags` LIKE ? LIMIT 10";
    $stmt = $db->prepare($query);
    $search_term = "%" . $input . "%";
    $stmt->bind_param("s", $search_term);
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