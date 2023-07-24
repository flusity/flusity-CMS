<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once ROOT_PATH . 'core/template/header-admin.php';
?>
<?php require_once ROOT_PATH . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  ROOT_PATH . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">
            <?php
              $i = 1;  
        $items_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : 5; // selected rows
        $total_items = count(getAllPlaces($db, $prefix));
        $total_pages = ceil($total_items / $items_per_page);
        $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
        $start = ($current_page - 1) * $items_per_page;

        $places = getAllPlaces($db, $prefix); // It appears that this function call is duplicate
        $menus = getMenuItems($db, $prefix); // It appears that this function call is duplicate
        $customblocks = getAllCustomBlocks($db, $prefix, $start, $items_per_page ); // Make sure to include this function in your code
?>

       
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
            <h2><?php echo t("Custom Blocks");?></h2>
            <button type="button" class="btn btn-sm btn-primary" onclick="loadCustomBlockForm('create')" title="<?php echo t("Add");?>">

              <i class="fas fa-plus"></i>
            </button>
            <div class="col-md-12 mt-3">
            <!-- Išveda customblock redagavimo langą -->
            <div id="get-customblock-edit"></div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 3%;"><?php echo t("No.");?></th>
                        <th style="width: 17%;"><?php echo t("Name");?></th>
                        <th style="width: 40%;"><?php echo t("HTML Code");?></th>
                        <th style="width: 13%;"><?php echo t("Menu Place");?></th>
                        <th style="width: 12%;"><?php echo t("Place");?></th>
                        <th style="width: 15%;"><?php echo t("Actions");?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=0;
                    foreach ($customblocks as $customBlock): ?>
                        <tr>
                            <td><?= $i=$i+1; ?>.</td>
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
                            <td>
                                <?= $customBlock['menu_id'] == 0 ? t('All pages') : htmlspecialchars(findNameById($customBlock['menu_id'], $menus)); ?>
                            </td>

                            <td><?= htmlspecialchars(findNameById($customBlock['place_id'], $places)); ?></td>
                            <td>
                            <button type="button" class="btn btn-sm btn-primary" onclick="loadCustomBlockEditForm(<?= $customBlock['id']; ?>)" title="<?php echo t("Edit");?>">
                                <i class="fas fa-edit"></i>
                            </button>
                        
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCustomblockModal" data-custom-block-id="<?php echo $customBlock['id']; ?>" title="<?php echo t("Delete");?>">
                            <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
         </table>

         <div class="d-flex justify-content-center mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <?php
                $num_pages_to_display = 5;
                for ($i = max(1, $current_page - $num_pages_to_display); $i <= min($current_page + $num_pages_to_display, $total_pages); $i++):
                ?>
                    <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
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

<!-- Modal -->

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel"><?php echo t("Confirm deletion");?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php echo t("Are you sure you want to delete this block?");?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger  delete-customblock-btn" id="confirm-delete-btn"><?php echo t("Delete");?></button>
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