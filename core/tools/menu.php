<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once ROOT_PATH . 'core/template/header-admin.php';?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

        <?php $allMenu = getMenuItems($db); ?>
        
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
            <h2><?php echo t("Page Menu");?></h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal" data-mode="add">
            <i class="fas fa-plus"></i>
            </button>
            <table class="table">
    <thead>
        <tr>
            <th style="width: 3%;"><?php echo t("No.");?></th>
            <th style="width: 17%;"><?php echo t("Name");?></th>
            <th style="width: 20%;"><?php echo t("Page URL");?></th>
            <th style="width: 12%;"><?php echo t("Template");?></th>
            <th style="width: 10%;"><?php echo t("Position");?></th>
            <th style="width: 3%;"><?php echo t("Show");?></th>
            <th style="width: 20%;"><?php echo t("Parent");?></th>
            <th style="width: 8%;"><?php echo t("Actions");?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1;
        foreach ($allMenu as $menu) { ?>
            <tr>
                <td><?php echo $i++; ?>.</td>
                <td><?php echo htmlspecialchars($menu['name']); ?></td>
                <td><?php echo htmlspecialchars($menu['page_url']); ?></td>
                <td><?php echo htmlspecialchars($menu['template']); ?></td>
                <td><?php echo htmlspecialchars($menu['position']); ?></td>
                <td><?php echo htmlspecialchars($menu['show_in_menu']); ?></td>
                <td>
                    <?php
                        $parentName = '';
                        foreach ($allMenu as $menuItem) {
                            if ($menuItem['id'] == $menu['parent_id']) {
                                $parentName = $menuItem['name'];
                                break;
                            }
                        }
                        echo $parentName;
                    ?>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal" data-menu-id="<?php echo $menu['id']; ?>" data-parent-id="<?php echo $menu['parent_id']; ?>" data-mode="update" title="<?php echo t("Edit");?>">
                        <i class="fas fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMenuModal" data-menu-id="<?php echo $menu['id']; ?>" title="<?php echo t("Delete");?>">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

                      </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addMenuModalLabel"><?php echo t('Add Menu');?></h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form id="add-menu-form">
        <div class="form-group">
          <label for="menu_name"><?php echo t("Menu Name");?></label>
          <input type="text" class="form-control" id="menu_name" name="menu_name" required>
        </div>
        <div class="form-group">
          <label for="page_url"><?php echo t("Page URL");?></label>
          <input type="text" class="form-control" id="page_url" name="page_url">
        </div>
        <div class="form-group">
          <label for="position"><?php echo t("Position");?></label>
          <input type="number" class="form-control" id="position" name="position" required>
        </div>
        <div class="form-group">
          <label for="template"><?php echo t("Template");?></label>
      <?php
          $settings = getSettings($db);
          $templateName = $settings['theme']; 
          $dir = ROOT_PATH ."cover/themes/";
          $templates = getTemplates($dir, $templateName);
      ?>
    <select class="form-control" id="template" name="template">
        <?php foreach ($templates as $template): ?>
            <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
        <?php endforeach; ?>
    </select>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu">
          <label class="form-check-label" for="show_in_menu"><?php echo t("Show in menu");?></label>
        </div>
        <div class="form-group">
          <label for="parent_id"><?php echo t("Parent");?></label>
          <select class="form-control" id="parent_id" name="parent_id">
              <option value=""><?php echo t("None");?></option>
              <?php foreach ($allMenu as $menu): ?>
                  <option value="<?php echo $menu['id']; ?>"><?php echo $menu['name']; ?></option>
              <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3" id="submit-button"><?php echo t("Add Menu");?></button>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="confirmDeleteModalLabel"><?php echo t("Confirm deletion");?></h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <?php echo t("Are you sure you want to delete this menu?");?>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
      <button type="button" class="btn btn-danger  delete-menu-btn" id="confirm-delete-btn"><?php echo t("Delete");?></button>
    </div>
  </div>
</div>
</div>

<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>
<script src="js/admin-menu.js"></script>