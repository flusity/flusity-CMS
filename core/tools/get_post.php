<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];

} else {
    header("Location: 404.php");
    exit;
}

if (!checkUserRole($user_id, 'admin', $db) && !checkUserRole($user_id, 'moderator', $db)) {
    header("Location: 404.php");
    exit;
}

$postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
$mode = $postId > 0 ? 'edit' : 'create';
$post = $mode === 'edit' ? getPostById($db, $postId) : null;
$existingTags = getExistingTags($db);
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
            
            <label for="post_tags" class="form-label"><?php echo t("Tags");?></label>
            <input type="text" class="form-control" id="post_tags" name="post_tags" value="<?php echo $mode === 'edit' ? htmlspecialchars($post['tags']) : ''; ?>"/>
            <div id="tag-suggestions" class="mt-2"></div>
            <p><?php echo t("Existing Tag's");?></p>
            <?php foreach ($existingTags as $tag): ?>
                <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($tag); ?></span>
                <?php endforeach; ?>
            </div>
            
            <div class="form-group">
            <label for="post_menu"><?php echo t("Menu");?></label>
            <select class="form-control" id="post_menu" name="post_menu" required>
                <?php foreach ($menuId as $menu) : ?>
                    <option value="<?php echo $menu['id']; ?>" <?php echo $mode === 'edit' && $post['menu_id'] === $menu['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($menu['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="post_title"><?php echo t("Name");?></label>
            <input type="text" class="form-control" id="post_title" name="post_title" value="<?php echo $mode === 'edit' ? htmlspecialchars($post['title']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="post_content"><?php echo t("Content");?></label>
            <div class="toolbar">
            <button type="button" onclick="paragraphText()" style="height: 35px; width: 35px;">p</button>
            <button type="button" onclick="boldText()" style="height: 35px; width: 35px;"><b>b</b></button>
            <button type="button" onclick="italicText()" style="height: 35px; width: 35px;"><i>i</i></button>
            <button type="button" onclick="underlineText()" style="height: 35px; width: 35px;"><u>u</u></button>
            <button type="button" onclick="markDel()" style="height: 35px;"><del>d<del></button>
            <button type="button" onclick="header1()" style="height: 35px;"><p>h1</p></button>
            <button type="button" onclick="header2()" style="height: 35px;"><p>h2</p></button>
            <button type="button" onclick="header3()" style="height: 35px;"><p>h3</p></button>
            <button type="button" onclick="hypertext()" style="height: 35px;"><p>url</p></button>
            <button type="button" onclick="listTextUl()" style="height: 35px;"><p>ul</p></button>
            <button type="button" onclick="listTextLi()" style="height: 35px;"><p>li</p></button>
            <button type="button" onclick="quotationMark()" style="height: 35px;"><p>„“</p></button>
            <button type="button" onclick="markOl()" style="height: 35px;"><p>1..</p></button>
            <button type="button" onclick="markSub()" style="height: 35px;"><sub>2</sub></button>
            <button type="button" onclick="markSup()" style="height: 35px;"><sup>4</sup></button>
            <button type="button" onclick="markHr()" style="height: 35px;"><p>__</p></button>
            <button type="button" onclick="markText()" style="height: 35px;"><p><mark>text</mark></p></button>
            <button type="button" onclick="selectImage()" style="height: 35px;"><img>img</img></button>
            </div>
            <textarea class="form-control"  contenteditable="true" id="post_content" name="post_content" rows="10" required><?php echo $mode === 'edit' ? htmlspecialchars_decode($post['content']) : ''; ?></textarea>
        </div>
        <div class="form-group">
                <label for="post_status"><?php echo t("Post status");?></label>
            <select class="form-control" id="post_status" name="post_status" required>
            <option value="draft" <?php echo $mode === 'edit' && $post['status'] === 'draft' ? 'selected' : ''; ?>><?php echo t("Draft");?></option>
            <option value="published" <?php echo $mode === 'edit' && $post['status'] === 'published' ? 'selected' : ''; ?>><?php echo t("Published");?></option>
            </select>

        </div>
        <button type="submit" class="btn btn-primary"><?php echo $mode === 'edit' ? t('Update Post') : t('Add Post'); ?></button>
        <button type="button" class="btn btn-secondary" id="cancel-post"><?php echo $mode === 'edit' ? t('Cancel') : t('Back'); ?></button>
     </form>

     </div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="imageSelectOffcanvas" data-bs-backdrop="false" data-bs-scroll="false">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Select an Image</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <img src="images/img1.jpg" class="selectable-image" data-image-name="img1.jpg">
    <img src="images/img2.jpg" class="selectable-image" data-image-name="img2.jpg">
    <!-- More images... -->
  </div>
</div>

<?php
} else {
    echo t('Post not found.');
}
?>
