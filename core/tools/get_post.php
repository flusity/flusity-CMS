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
    
    $user_role = getUserById($db, $user_id);
     $role = $user_role['role'];
} else {
    header("Location: 404.php");
    exit;
}

// Tikriname, ar vartotojas yra adminas ar moderatorius
if (!checkUserRole($user_id, 'admin', $db) && !checkUserRole($user_id, 'moderator', $db)) {
    header("Location: 404.php");
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Gaunami puslapio ID iš užklausos
$postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

// Nustatomas režimas (redagavimas arba kūrimas) pagal puslapio ID
$mode = $postId > 0 ? 'edit' : 'create';

// Gaunami puslapio duomenis iš duomenų bazės, jei režimas yra "edit"
$post = $mode === 'edit' ? getPostById($db, $postId) : null;
$existingTags = getExistingTags($db);
$categories = getCategories($db);
$menuId = getMenuItems($db);

if ($mode === 'create' || $post) {
?>
<div id="post-form-content">
    <form id="post-form">
        <input type="hidden" name="mode" value="<?php echo $mode; ?>">
        <?php if ($mode === 'edit'): ?>
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
        <?php endif; ?>
        <input type="hidden" id="role"  name="role" value="<?php echo $role; ?>">
        
 <div class="form-group">
 
  <label for="post_tags" class="form-label">Tags</label>
  <input type="text" class="form-control" id="post_tags" name="post_tags" value="<?php echo $mode === 'edit' ? htmlspecialchars($post['tags']) : ''; ?>" required>
  <div id="tag-suggestions" class="mt-2"></div>
  <p>Existing Tag's
  <?php foreach ($existingTags as $tag): ?>
      <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($tag); ?></span>
    <?php endforeach; ?></p>
  </div>
</div>
    <div class="form-group">
    <label for="post_menu">Menu</label>
    <select class="form-control" id="post_menu" name="post_menu" required>
        <?php foreach ($menuId as $menu) : ?>
            <option value="<?php echo $menu['id']; ?>" <?php echo $mode === 'edit' && $post['menu_id'] === $menu['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($menu['name']); ?>
             
            </option>
        <?php endforeach; ?>
    </select>
</div>
        
<div class="form-group">
    <label for="post_title">Pavadinimas</label>
    <input type="text" class="form-control" id="post_title" name="post_title" value="<?php echo $mode === 'edit' ? htmlspecialchars($post['title']) : ''; ?>" required>
</div>
<div class="form-group">
    <label for="post_content">Turinys</label>
    <textarea class="form-control" id="post_content" name="post_content" rows="10" required><?php echo $mode === 'edit' ? htmlspecialchars($post['content']) : ''; ?></textarea>
</div>
<div class="form-group">
    <label for="post_status">Puslapio būsena</label>
<select class="form-control" id="post_status" name="post_status" required>
<option value="draft" <?php echo $mode === 'edit' && $post['status'] === 'draft' ? 'selected' : ''; ?>>Juodraštis</option>
<option value="published" <?php echo $mode === 'edit' && $post['status'] === 'published' ? 'selected' : ''; ?>>Publikuotas</option>
</select>

</div>
<button type="submit" class="btn btn-primary"><?php echo $mode === 'edit' ? 'Atnaujinti puslapį' : 'Pridėti puslapį'; ?></button>
    <button type="button" class="btn btn-secondary" id="cancel-post"><?php echo $mode === 'edit' ? 'Atšaukti' : 'Grįžti'; ?></button>
</form>
</div>
<?php
} else {
    echo 'Puslapis nerastas.';
}
?>
