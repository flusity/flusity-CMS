<?php 
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php'; ?>
<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
        <?php require_once ROOT_PATH . 'core/template/admin-menu-horizontal.php';?>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row d-flex flex-nowrap">
        <div class="col-md-2 sidebar" id="sidebar">
            <?php require_once ROOT_PATH . 'core/tools/sidebar.php';?>
        </div>
<?php $categories = getAllCategories($db); ?>
<div class="col-md-10 content-up">
    <div class="col-sm-9">
        <?php  if (isset($_SESSION['success_message'])) {
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
            } ?>
    </div>
    <h1><?php echo t("Categories");?></h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-mode="add">
    <?php echo t("Add Category");?>
     </button>
        <table class="table">
            <thead>
                <tr>
                    <th><?php echo t("No.");?></th>
                    <th><?php echo t("Name");?></th>
                    <th><?php echo t("Actions");?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                 foreach ($categories as $category) { ?>
                    <tr>  
                        <td><?php $i++; echo htmlspecialchars($i); ?></td>
                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                        <td>  
                          <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-category-id="<?php echo $category['id']; ?>" data-mode="update" title="<?php echo t("Edit");?>">
                          <i class="fas fa-edit"></i>
                          </button>
                        
                          <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal" data-category-id="<?php echo $category['id']; ?>" title="<?php echo t("Delete");?>">
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
     </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel"><?php echo t("Add Category");?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-category-form">
          <div class="form-group">
            <label for="category_name"><?php echo t("Category Name");?></label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
          </div>
          <button type="submit" class="btn btn-primary" id="submit-button"><?php echo t("Add Category");?></button>
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
      <?php echo t("Are you sure you want to delete this category?");?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger  delete-category-btn" id="confirm-delete-btn"><?php echo t("Delete");?></button>
      </div>
    </div>
  </div>
</div>
<script>
// Prideda kategoriją po paspaudimo
$('#add-category-form').on('submit', function (e) {
  e.preventDefault();

  const categoryName = $('#category_name').val();
  const mode = $('#addCategoryModal').data('mode');
  const categoryId = $('#addCategoryModal').data('category-id');

  let url;
  let action;

  if (mode === 'add') {
    url = 'add_categories.php';
    action = 'add_category';
  } else if (mode === 'update') {
    url = 'update_category.php';
    action = 'update_category';
  } else {
    console.error('Invalid mode');
    return;
  }

  $.ajax({
    type: 'POST',
    url: url,
    data: {
      action: action,
      category_id: categoryId,
      category_name: categoryName,
    },
    success: function (response) {
      console.log(response);

      // Uždaro modal
      $('#addCategoryModal').modal('hide');

      // Išvalo input laukus
      $('#category_name').val('');
      location.reload();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
    },
  });
});

$('#addCategoryModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget); 
  const mode = button.data('mode'); 
  const categoryId = button.data('category-id'); 

  const modal = $(this);
  modal.data('mode', mode);
  modal.data('category-id', categoryId);

  if (mode === 'update') {
    const categoryName = button.closest('tr').find('td:nth-child(2)').text();
    $('#category_name').val(categoryName);
    modal.find('.modal-title').text('Edit Category');
    modal.find('#submit-button').text('Update Category');
  } else {
    $('#category_name').val('');
    modal.find('.modal-title').text('Add Category');
    modal.find('#submit-button').text('Add Category');
  }
});

$(document).ready(function () {
  // Paspaudus ištrynimo mygtuką, atidaro patvirtinimo modalą
  $('button[data-bs-target="#deleteCategoryModal"]').on('click', function () {
    const categoryId = $(this).data('category-id');
    $('#confirmDeleteModal').data('category-id', categoryId);
    $('#confirmDeleteModal').modal('show');
  });

  // Paspaudus patvirtinimo mygtuką, ištrina kategoriją
  $('#confirm-delete-btn').on('click', function () {
    const categoryId = $('#confirmDeleteModal').data('category-id');
    
    // Siunčia POST užklausą į delete_category.php failą
    $.ajax({
      type: 'POST',
      url: 'delete_category.php',
      data: {
        action: 'delete_category',
        category_id: categoryId
      },
      success: function(response) {
        // Uždaro modalą ir peradresuoja į categories.php puslapį
        $('#confirmDeleteModal').modal('hide');
        window.location.href = 'categories.php';
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });
});

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>