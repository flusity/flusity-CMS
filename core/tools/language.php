<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';

$translations = getTranslations($db, $language_code);

$limit = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$translationsWords = getTranslationsWords($db, $limit, $offset);
$total_records = countTranslations($db);
$records_per_page = 15;
$total_pages = ceil($total_records / $records_per_page);
$i=1;
$editTranslation = null;
if (isset($_GET['edit_id'])) {
    $editTranslation = getTranslationById($db, $_GET['edit_id']);
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php require_once ROOT_PATH . 'core/template/admin-menu-horizontal.php'; ?>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row d-flex flex-nowrap">
        <div class="col-md-2 sidebar" id="sidebar">
            <?php require_once ROOT_PATH . 'core/tools/sidebar.php'; ?>
        </div>

        <div class="col-md-10 content-up">
        <div class="col-sm-9">
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
                        " . htmlspecialchars($_SESSION['success_message']) . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    unset($_SESSION['success_message']);
                }

                if (isset($_SESSION['error_message'])) {
                    echo "<div class='alert alert-danger alert-dismissible fade show slow-fade'>
                        " . htmlspecialchars($_SESSION['error_message']) . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    unset($_SESSION['error_message']);
                }
                ?>
            </div>
            <h2><?php echo t("Translation form");?></h2>
            
            <div class="row">
            <div class="col-sm-3">
            <form method="post" action="<?php echo $editTranslation ? 'edit_translation.php' : 'add_translation.php'; ?>">

            <input type="hidden" name="edit_id" value="<?php echo $editTranslation ? $editTranslation['id'] : ''; ?>">

            <div class="form-group">
    <label for="language_code"><?php echo t("Language Code");?></label>
    <select class="form-select" id="language_code" name="language_code" required>
    <?php
    $languages = getAllLanguages($db);
    $selectedLanguageCode = isset($selectedTranslation) ? $selectedTranslation['language_code'] : '';
    foreach ($languages as $language) {
        $selected = $language['language_code'] === $selectedLanguageCode ? 'selected' : '';
        echo "<option value='{$language['language_code']}' $selected>{$language['language_code']}</option>";
    }
    ?>
    <option value="new"><?php echo t("Add new");?></option>
</select>

    <input type="text" class="form-control mt-2 d-none" id="new_language_code" name="new_language_code" placeholder="<?php echo t('Enter new language code'); ?>">
</div>
            <div class="form-group">
                <label for="translation_key"><?php echo t("Translation Key");?></label>
                <input type="text" class="form-control" id="translation_key" name="translation_key" value="<?php echo $editTranslation ? $editTranslation['translation_key'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="translation_value"><?php echo t("Translation Value");?></label>
                <input type="text" class="form-control" id="translation_value" name="translation_value" value="<?php echo $editTranslation ? $editTranslation['translation_value'] : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><?php echo t("Add/Edit");?></button>
             </form>

        </div>
        <div class="col-sm-9">
                    <table class="table">
            <thead>
                <tr>
                    <th style="width: 3%;"><?php echo t("No.");?></th>
                    <th style="width: 3%;"><?php echo t("Code");?></th>
                    <th style="width: 40%;"><?php echo t("Translation Key");?></th>
                    <th style="width: 40%;"><?php echo t("Translation Value");?></th>
                    <th style="width: 14%;"><?php echo t("Actions");?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($translationsWords as $translationWord): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $translationWord['language_code']; ?></td>
                        <td><?php echo $translationWord['translation_key']; ?></td>
                        <td><?php echo $translationWord['translation_value']; ?></td>
                        
                        <td>
                        <a href="language.php?edit_id=<?php echo $translationWord['id']; ?>" class="btn btn-primary" title="<?php echo t("Edit");?>"><i class="fas fa-edit"></i></a>

                            <a href="delete_translation.php?id=<?php echo $translationWord['id']; ?>" class="btn btn-danger" title="<?php echo t("Delete");?>"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                     </a>
                 </li>
                
        <?php  $num_pages_to_display = 5;
                for ($i = max(1, $page - $num_pages_to_display); $i <= min($page + $num_pages_to_display, $total_pages); $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
            <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                        </a>
                    </li>
            </ul>
        </nav>
     </div>
    </div>
    </div>
</div>
</div>
<script>
    document.getElementById('language_code').addEventListener('change', function () {
        if (this.value === 'new') {
            document.getElementById('new_language_code').classList.remove('d-none');
        } else {
            document.getElementById('new_language_code').classList.add('d-none');
        }
    });
</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>
