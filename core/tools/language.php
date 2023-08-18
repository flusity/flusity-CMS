<?php
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
    require_once ROOT_PATH . 'core/template/header-admin.php';
    
    $possible_rows = [15, 35, 75, 150, 250, 350]; // galimos eilučių reikšmės
    $records_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : 15; // pasirinktos eilutės

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $records_per_page;
    $search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';
    $translationsWords = getTranslationsWords($db, $prefix, $records_per_page, $offset, $search_term);

    $total_records = countTranslations($db, $prefix);
    $total_pages = ceil($total_records / $records_per_page);
    $i=1;
    $editTranslation = null;
    if (isset($_GET['edit_id'])) {
        $editTranslation = getTranslationById($db, $prefix, $_GET['edit_id']);
    }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

        
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
            $setting_lang = $settings['language'];
            $languages = getAllLanguages($db, $prefix);
            $selectedLanguageCode = isset($selectedTranslation) ? $selectedTranslation['language_code'] : '';

            // Įterpkite jau esamų kalbų kodus
            $existingLanguageCodes = [];
            foreach ($languages as $language) {
                $existingLanguageCodes[] = $language['language_code'];
                $selected = $language['language_code'] === $selectedLanguageCode ? 'selected' : '';
                echo "<option value='{$language['language_code']}' $selected>{$language['language_code']}</option>";
            }

            // Jei kalbos kodas iš nustatymų nėra sąraše, pridėkite jį
            if (!in_array($setting_lang, $existingLanguageCodes)) {
                $selected = $setting_lang === $selectedLanguageCode ? 'selected' : '';
                echo "<option value='{$setting_lang}' $selected>{$setting_lang}</option>";
            }
        ?>
        <option value="new"><?php echo t("Add new code");?></option>
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
             <div class="col-sm-12 d-flex mt-5">
             <form method="GET" id="rows-form">
                <label for="rows"><?php echo t("Lines per page:");?></label>
                <select name="rows" class="form-select" id="rows" onchange="document.getElementById('rows-form').submit()">
                    <?php foreach($possible_rows as $rows): ?>
                        <option value="<?php echo $rows; ?>" <?php echo ($rows == $records_per_page ? 'selected' : ''); ?>>
                            <?php echo $rows; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        </div>
        
        <div class="col-sm-9">
        <table class="table">
            <thead>
                <tr>    
                <div class="input-wrapper">
                     <input type="text" id="search_term" class="form-control search-input-long" name="search_term" placeholder="<?php echo t("Search translations...");?>">
                    <span id="clear-search" class="clear-button">&times;</span>
                 </div>
                    <th style="width: 3%;"><?php echo t("No.");?></th>
                    <th style="width: 3%;"><?php echo t("Code");?></th>
                    <th style="width: 40%;"><?php echo t("Translation Key");?></th>
                    <th style="width: 40%;"><?php echo t("Translation Value");?></th>
                    <th style="width: 14%;"><?php echo t("Actions");?></th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($translationsWords as $index => $translationWord) {
                    echo "<tr class=\"translation-row\" data-key=\"" . htmlspecialchars($translationWord['translation_key']) . "\" data-value=\"" . htmlspecialchars($translationWord['translation_value']) . "\">";
                    echo "<td>" . ($index + 1) . ".</td>";
                    echo "<td>" . htmlspecialchars($translationWord['language_code']) . "</td>";
                    echo "<td>" . htmlspecialchars($translationWord['translation_key']) . "</td>";
                    echo "<td>" . htmlspecialchars($translationWord['translation_value']) . "</td>";
                    echo "<td><div class='btn-group'><a href='language.php?edit_id=" . htmlspecialchars($translationWord['id']) . "' class='btn btn-primary' title='Edit'><i class='fas fa-edit'></i></a> <a href='delete_translation.php?id=" . htmlspecialchars($translationWord['id']) . "' class='btn btn-danger' title='Delete'><i class='fas fa-trash'></i></a></div></td>";
                    echo "</tr>";
                }
                ?>
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
                 </main>
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
 
 document.querySelector('#search_term').addEventListener('input', function() {
        if (this.value !== '') {
            document.querySelector('#clear-search').style.display = 'block';
        } else {
            document.querySelector('#clear-search').style.display = 'none';
        }
 });

 document.querySelector('#clear-search').addEventListener('click', function() {
    var searchInput = document.querySelector('#search_term');
    searchInput.value = '';
    this.style.display = 'none';
    var event = new Event('keyup');
    searchInput.dispatchEvent(event);
 });
</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php'; ?>