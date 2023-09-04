<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('IS_ADMIN', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';


 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $prefix, $user_id);
} else {
    header("Location: 404.php");
    exit;
}

if (!checkUserRole($user_id, 'admin', $db, $prefix) && !checkUserRole($user_id, 'moderator', $db, $prefix)) {
    header("Location: 404.php");
    exit;
}
$settings = getSettings($db, $prefix);
$bilingualism = $settings['bilingualism'];

$customBlockPlace = isset($_GET['customblock_place']) ? $_GET['customblock_place'] : null;

$customBlockId = isset($_GET['customblock_id']) ? (int)$_GET['customblock_id'] : 0; // redaguojant ID skaičius
 //  print_r($_GET);
 $selected_place_name = isset($_GET['customblock_place']) ? $_GET['customblock_place'] : null;

$selected_place_id = getPlaceIdByName($db, $prefix, $selected_place_name);

$mode = $customBlockId > 0 ? 'edit' : 'create';
$customBlock = $mode === 'edit' ? getCustomBlockById($db, $prefix, $customBlockId) : $selected_place_id;

$places = getplaces($db, $prefix);
$menuId = getMenuItems($db, $prefix);


if ($mode === 'create' || $customBlock) {
?>

<div class="col-md-8">
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
            <option value="<?php echo $place['id']; ?>" 
                <?php 
                if (($mode === 'edit' && $customBlock['place_id'] === $place['id']) || 
                    ($mode === 'create' && $selected_place_id === $place['id'])) echo 'selected'; 
                ?>>
                <?php echo htmlspecialchars($place['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
        <div class="form-group">
            <label for="customblock_menu_id"><?php echo t('Menu');?></label>
            <select class="form-control" id="customblock_menu_id" name="customblock_menu_id" required>
                <option value="0"><?php echo t('To all pages');?></option>
                <?php foreach ($menuId as $menu) : ?>
                    <option value="<?php echo $menu['id']; ?>" <?php echo $mode === 'edit' && $customBlock['menu_id'] === $menu['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($menu['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="customblock_name"><?php echo t('Name');?></label>
            <input type="text" class="form-control" id="customblock_name" name="customblock_name" value="<?php echo $mode === 'edit' ? htmlspecialchars($customBlock['name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="customblock_html_code"><?php echo t('Content');?></label>
            <div class="toolbar">
            
            <button type="button" onclick="textBreak('post_content')" style="height: 35px; width: 35px;">br</button>
            <button type="button" onclick="paragraphText('post_content')" style="height: 35px; width: 35px;">p</button>
            <button type="button" onclick="boldText('post_content')" style="height: 35px; width: 35px;"><b>b</b></button>
            <button type="button" onclick="italicText('post_content')" style="height: 35px; width: 35px;"><i>i</i></button>
            <button type="button" onclick="underlineText('post_content')" style="height: 35px; width: 35px;"><u>u</u></button>
            <button type="button" onclick="markDel('post_content')" style="height: 35px;"><del>d<del></button>
            <button type="button" onclick="header1('post_content')" style="height: 35px;"><p>h1</p></button>
            <button type="button" onclick="header2('post_content')" style="height: 35px;"><p>h2</p></button>
            <button type="button" onclick="header3('post_content')" style="height: 35px;"><p>h3</p></button>
            <button type="button" onclick="hypertext('post_content')" style="height: 35px;"><p>url</p></button>
            <button type="button" onclick="listTextUl('post_content')" style="height: 35px;"><p>ul</p></button>
            <button type="button" onclick="listTextLi('post_content')" style="height: 35px;"><p>li</p></button>
            <button type="button" onclick="quotationMark('post_content')" style="height: 35px;"><p>„“</p></button>
            <button type="button" onclick="markOl('post_content')" style="height: 35px;"><p>1..</p></button>
            <button type="button" onclick="markSub('post_content')" style="height: 35px;"><sub>2</sub></button>
            <button type="button" onclick="markSup('post_content')" style="height: 35px;"><sup>4</sup></button>
            <button type="button" onclick="markHr('post_content')" style="height: 35px;"><p>__</p></button>
            <button type="button" onclick="markText('post_content')" style="height: 35px;"><p><mark>text</mark></p></button>
            <button type="button" onclick="selectImage('post_content')" style="height: 35px;"><img>img</img></button>
            <button type="button" onclick="previewPost('post_content')" style="padding: 0px;">
            <i class="fas fa-expand-arrows-alt" title="Preview"style="size:28px; color: #c2c2c2;"></i>
            </button>
        
            </div>

            <textarea class="form-control" id="post_content" name="customblock_html_code" rows="10"><?php echo $mode === 'edit' ? htmlspecialchars_decode($customBlock['html_code']) : ''; ?></textarea>
            
        </div>
<!-- Other language start-->
<?php if($bilingualism != 0): ?>
        <div class="form-group">
        <label for="post_status"><?php echo t("Next Language");?></label>
        <div class="accordion accordion-flush mb-3" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            <?php echo t("Add content in another language");?>
            </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
            <div class="form-group mb-2">
            <label for="customblock_name"><?php echo t('Other languages Name');?></label>
            <input type="text" class="form-control" id="lang_custom_name" name="lang_custom_name" value="<?php echo $mode === 'edit' ? htmlspecialchars($customBlock['lang_custom_name']) : ''; ?>">
            </div>
            <div class="toolbar">
            
            <button type="button" onclick="textBreak('lang_custom_content')" style="height: 35px; width: 35px;">br</button>
            <button type="button" onclick="paragraphText('lang_custom_content')" style="height: 35px; width: 35px;">p</button>
            <button type="button" onclick="boldText('lang_custom_content')" style="height: 35px; width: 35px;"><b>b</b></button>
            <button type="button" onclick="italicText('lang_custom_content')" style="height: 35px; width: 35px;"><i>i</i></button>
            <button type="button" onclick="underlineText('lang_custom_content')" style="height: 35px; width: 35px;"><u>u</u></button>
            <button type="button" onclick="markDel('lang_custom_content')" style="height: 35px;"><del>d<del></button>
            <button type="button" onclick="header1('lang_custom_content')" style="height: 35px;"><p>h1</p></button>
            <button type="button" onclick="header2('lang_custom_content')" style="height: 35px;"><p>h2</p></button>
            <button type="button" onclick="header3('lang_custom_content')" style="height: 35px;"><p>h3</p></button>
            <button type="button" onclick="hypertext('lang_custom_content')" style="height: 35px;"><p>url</p></button>
            <button type="button" onclick="listTextUl('lang_custom_content')" style="height: 35px;"><p>ul</p></button>
            <button type="button" onclick="listTextLi('lang_custom_content')" style="height: 35px;"><p>li</p></button>
            <button type="button" onclick="quotationMark('lang_custom_content')" style="height: 35px;"><p>„“</p></button>
            <button type="button" onclick="markOl('lang_custom_content')" style="height: 35px;"><p>1..</p></button>
            <button type="button" onclick="markSub('lang_custom_content')" style="height: 35px;"><sub>2</sub></button>
            <button type="button" onclick="markSup('lang_custom_content')" style="height: 35px;"><sup>4</sup></button>
            <button type="button" onclick="markHr('lang_custom_content')" style="height: 35px;"><p>__</p></button>
            <button type="button" onclick="markText('lang_custom_content')" style="height: 35px;"><p><mark>text</mark></p></button>
            <button type="button" onclick="selectImage('lang_custom_content')" style="height: 35px;"><img>img</img></button>
            <button type="button" onclick="previewPost('lang_custom_content')" style="padding: 0px;">
            <i class="fas fa-expand-arrows-alt" title="Preview"style="size:28px; color: #c2c2c2;"></i>
            </button>
        
            </div>
            <textarea class="form-control"  contenteditable="true" id="lang_custom_content" name="lang_custom_content" rows="16"><?php echo $mode === 'edit' ? htmlspecialchars_decode($customBlock['lang_custom_content']) : ''; ?></textarea>
            </div>
            </div>
        </div>
        </div>
        </div>

        <?php endif; ?>
        <!-- Other language end-->
        <button type="submit" class="btn btn-primary"><?php echo $mode === 'edit' ? 'Update Block' : 'Add Block'; ?></button>
        <button type="button" class="btn btn-secondary" id="cancel-customblock"><?php echo $mode === 'edit' ? 'Cancel' : 'Back'; ?></button>
    </form>
</div>
</div>

<?php
} else {
    echo t('Block not found.');
}
?>

<div class="col-md-4">

</div>
