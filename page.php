<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
require_once 'security/config.php';
require_once 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
// Patikrinti ar vartotojas prisijungęs
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);

} else {
    header('Location: login.php');
    exit();
}

// Puslapiavimo parametrai
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;


$posts = getPosts($db, $limit, $offset);
$total_posts = countPosts($db);
$total_pages = ceil($total_posts / $limit);
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>
<h1>Sveiki, <?php echo htmlspecialchars($user_name); ?>!</h1>

    <a href="logout.php">Atsijungti</a>
    <?php if (checkUserRole($user_id, 'admin', $db) || checkUserRole($user_id, 'moderator', $db)): ?>
    <p>Tik adminams ir moderatoriams skirta funkcija.</p>
<?php endif; ?>

<?php if (checkUserRole($user_id, 'user', $db)): ?>
    <p>Tik paprastiems vartotojams skirta funkcija.</p>
<?php endif; ?>
    <a href="logout.php">Atsijungti</a>

    <?php foreach ($posts as $post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
    <?php endforeach; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>
