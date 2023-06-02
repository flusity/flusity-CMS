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
$customBlockId = isset($_GET['customblock_id']) ? (int)$_GET['customblock_id'] : 0;
$mode = $customBlockId > 0 ? 'edit' : 'create';
$customBlock = $mode === 'edit' ? getCustomBlockById($db, $customBlockId) : null;

$places = getplaces($db);
$menuId = getMenuItems($db);

if ($mode === 'create' || $customBlock) {
?>
<div id="customblock-form-content">
    <form id="customblock-form">
        <input type="hidden" name="mode" value="<?php echo $mode; ?>">
        <?php if ($mode === 'edit'): ?>
            <input type="hidden" name="customblock_id" value="<?php echo $customBlock['id']; ?>">
        <?php endif; ?>
   
        <div class="form-group">
            <label for="customblock_place_id"><?php echo t('Place');?></label>
            <select class="form-control" id="customblock_place_id" name="customblock_place_id" required>
                <?php foreach ($places as $place) : ?>
                    <option value="<?php echo $place['id']; ?>" <?php echo $mode === 'edit' && $customBlock['place_id'] === $place['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($place['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="customblock_menu_id"><?php echo t('Menu');?></label>
            <select class="form-control" id="customblock_menu_id" name="customblock_menu_id" required>
                <?php foreach ($menuId as $menu) : ?>
                    <option value="<?php echo $menu['id']; ?>" <?php echo $mode === 'edit' && $customBlock['menu_id'] === $menu['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($menu['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="customblock_name"><?php echo t('Name');?></label>
            <input type="text" class="form-control" id="customblock_name" name="customblock_name" value="<?php echo $mode === 'edit' ? htmlspecialchars($customBlock['name']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="customblock_html_code"><?php echo t('Content');?></label>
            <textarea class="form-control" id="customblock_html_code" name="customblock_html_code" rows="10" required><?php echo $mode === 'edit' ? htmlspecialchars($customBlock['html_code']) : ''; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $mode === 'edit' ? 'Update Block' : 'Add Block'; ?></button>
        <button type="button" class="btn btn-secondary" id="cancel-customblock"><?php echo $mode === 'edit' ? 'Cancel' : 'Back'; ?></button>
    </form>
</div>
<?php
} else {
    echo t('Block not found.');
}
?>

