<?php 
session_start();
define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);

} else {
    header("Location: 404.php");
    exit;
}

// Tikriname, ar vartotojas yra adminas ar moderatorius
if (!checkUserRole($user_id, 'admin', $db) && !checkUserRole($user_id, 'moderator', $db)) {
    header("Location: 404.php");
    exit;
}


// Gaukite vartotojo ID iš užklausos
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Gaukite vartotojo duomenis iš duomenų bazės
$user = getUserById($db, $userId);

if ($user) {
    // Sugeneruokite HTML formą su vartotojo duomenimis
?>
<div id="edit-user-content">
    <form id="edit-user-form">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

        <div class="form-group">
            <label for="user_username">Vardas</label>
            <input type="text" class="form-control" id="user_username" name="user_username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_surname">Pavardė</label>
            <input type="text" class="form-control" id="user_surname" name="user_surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_phone">Telefono numeris</label>
            <input type="text" class="form-control" id="user_phone" name="user_phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_email">El. paštas</label>
            <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_role">Rolė</label>
            <select class="form-control" id="user_role" name="user_role" required>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>>Moderatorius</option>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Vartotojas</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Atnaujinti vartotoją</button>
        <button type="button" class="btn btn-secondary" id="cancel-edit-user">Atšaukti</button>
    </form>
</div>
<?php
} else {
    echo 'Vartotojas nerastas.';
}
?>



