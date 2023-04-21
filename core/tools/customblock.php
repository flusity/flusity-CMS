<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';
?>
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
        <?php
        $categories = getAllCategories($db);
        $menus = getMenus($db);

          $customblocks = getAllCustomBlocks($db);
          ?>
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
            <h2>Custom Blocks</h2>
            <button type="button" class="btn btn-sm btn-primary" onclick="loadCustomBlockForm('create')" title="Add">

              <i class="fas fa-plus"></i>
            </button>
            <!-- Išveda customblock redagavimo langą -->
            <div id="get-customblock-edit"></div>

            <table class="table">
    <thead>
        <tr>
            <th style="width: 3%;">ID</th>
            <th style="width: 17%;">Name</th>
            <th style="width: 40%;">HTML Code</th>
            <th style="width: 13%;">Menu Place</th>
            <th style="width: 12%;">Category</th>
            <th style="width: 15%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customblocks as $customBlock): ?>
            <tr>
                <td><?= htmlspecialchars($customBlock['id']); ?></td>
                <td><?= htmlspecialchars($customBlock['name']); ?></td>
                <td>
                  <?php
                      $html_code = htmlspecialchars($customBlock['html_code']);
                      $max_length = 100;
                      if (strlen($html_code) > $max_length) {
                          echo substr($html_code, 0, $max_length) . '...';
                      } else {
                          echo $html_code;
                      }
                  ?>
                </td>
                <td><?= htmlspecialchars(findNameById($customBlock['menu_id'], $menus)); ?></td>
                <td><?= htmlspecialchars(findNameById($customBlock['category_id'], $categories)); ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" onclick="loadCustomBlockEditForm(<?= $customBlock['id']; ?>)" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCustomblockModal" data-custom-block-id="<?php echo $customBlock['id']; ?>" title="Delete">

                                    <i class="fas fa-trash-alt"></i>
                                </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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
        Ar tikrai norite ištrinti šį bloką?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atšaukti</button>
        <button type="button" class="btn btn-danger  delete-customblock-btn" id="confirm-delete-btn">Ištrinti</button>
      </div>
    </div>
  </div>
</div>


<script>

  function loadCustomBlockEditForm(customBlockId) {
    loadCustomBlockForm('edit', customBlockId);
  }
  
$(document).ready(function () {
    // Paspaudus ištrynimo mygtuką, atidaro patvirtinimo modalą
    $('button[data-bs-target="#deleteCustomblockModal"]').on('click', function () {
        const customblockId = $(this).data('custom-block-id');
      $('#confirmDeleteModal').data('customblock-id', customblockId);
      $('#confirmDeleteModal').modal('show');
    });
  
    // Paspaudus patvirtinimo mygtuką, ištrina kategoriją
    $('#confirm-delete-btn').on('click', function () {
      const customblockId = $('#confirmDeleteModal').data('customblock-id');
      
      // Siunčia POST užklausą į delete_customblock.php failą
      $.ajax({
        type: 'POST',
        url: 'delete_customblock.php',
        data: {
          action: 'delete_customblock',
          customblock_id: customblockId
        },
        success: function(response) {
          // Uždaro modalą ir peradresuoja į customblock.php puslapį
          $('#confirmDeleteModal').modal('hide');
          window.location.href = 'customblock.php';
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Rodo klaidos pranešimą
          console.error(textStatus, errorThrown);
        }
      });
    });
  });
</script>
<script src="js/admin-customblock-edit.js"></script>

<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>