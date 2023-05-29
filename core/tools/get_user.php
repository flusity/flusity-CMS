<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
secureSession();

$db = getDBConnection($config);

$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);

} else {
    header("Location: 404.php");
    exit;
}

if (!checkUserRole($user_id, 'admin', $db) && !checkUserRole($user_id, 'moderator', $db)) {
    header("Location: 404.php");
    exit;
}

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$user = getUserById($db, $userId);

if ($user) { ?>
<div id="edit-user-content">
    <form id="edit-user-form">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

        <div class="form-group mb-3 mt-3">
            <label for="login_name"><?php echo t("Login Name:");?></label>
            &nbsp;<b><?php echo htmlspecialchars($user['login_name']); ?></b>
        </div>
        <div class="form-group">
            <label for="user_username"><?php echo t("Username");?></label>
            <input type="text" class="form-control" id="user_username" name="user_username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_surname"><?php echo t("Surname");?></label>
            <input type="text" class="form-control" id="user_surname" name="user_surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_phone"><?php echo t("Phone");?></label>
            <input type="text" class="form-control" id="user_phone" name="user_phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_email"><?php echo t("Email");?></label>
            <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_password"><?php echo t("Password");?></label>
            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="<?php echo t("Enter new password"); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_confirm_password"><?php echo t("Confirm Password");?></label>
            <input type="password" class="form-control" id="user_confirm_password" name="user_confirm_password" placeholder="<?php echo t("Confirm new password"); ?>" required>
        </div>
        <div class="form-group">
            <label for="user_role"><?php echo t("Role");?></label>
            <select class="form-control" id="user_role" name="user_role" required>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>><?php echo t("Admin") ?></option>
                <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>><?php echo t("Moderator") ?></option>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>><?php echo t("User") ?></option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2 mb-2"><?php echo t("Update User");?></button>
        <button type="button" class="btn btn-secondary" id="cancel-edit-user"><?php echo t("Cancel");?></button>
    </form>
</div>
<?php
} else {
    echo t("User not found.");
}
?>
