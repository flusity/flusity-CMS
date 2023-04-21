<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';
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
        <?php $allMenu = getMenuItems($db); ?>

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

            <h2>Page Menu</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal" data-mode="add">
            <i class="fas fa-plus"></i>
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 3%;">ID</th>
                        <th style="width: 17%;">Name</th>
                        <th style="width: 30%;">Page URL</th>
                        <th style="width: 22%;">Template</th>
                        <th style="width: 13%;">Position</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($allMenu as $menu) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($menu['id']); ?></td>
                            <td><?php echo htmlspecialchars($menu['name']); ?></td>
                            <td><?php echo htmlspecialchars($menu['page_url']); ?></td>
                            <td><?php echo htmlspecialchars($menu['template']); ?></td>
                            <td><?php echo htmlspecialchars($menu['position']); ?></td>
                            <td>

                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal" data-menu-id="<?php echo $menu['id']; ?>" data-mode="update" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMenuModal" data-menu-id="<?php echo $menu['id']; ?>" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addMenuModalLabel">Add Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form id="add-menu-form">
        <div class="form-group">
          <label for="menu_name">Menu Name</label>
          <input type="text" class="form-control" id="menu_name" name="menu_name" required>
        </div>
        <div class="form-group">
          <label for="page_url">Page URL</label>
          <input type="text" class="form-control" id="page_url" name="page_url">
        </div>
        <div class="form-group">
          <label for="position">Position</label>
          <input type="number" class="form-control" id="position" name="position" required>
        </div>
        <div class="form-group">
          <label for="template">Template</label>

          <!-- <input type="text" class="form-control" id="template" name="template" required> -->
         <?php $templates = getTemplates("../../template/"); // Čia įrašykite katalogo kelią su šablonais
         ?>

          <select class="form-control" id="template" name="template">
              <?php foreach ($templates as $template): ?>
                  
                  <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
              <?php endforeach; ?>
          </select>
        
        
        
        </div>
        <button type="submit" class="btn btn-primary mt-3" id="submit-button">Add Menu</button>
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
      <h5 class="modal-title" id="confirmDeleteModalLabel">Patvirtinkite šalinimą</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      Ar tikrai norite ištrinti šį menu?
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atšaukti</button>
      <button type="button" class="btn btn-danger  delete-menu-btn" id="confirm-delete-btn">Ištrinti</button>
    </div>
  </div>
</div>
</div>
<script src="js/admin-menu.js"></script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>
