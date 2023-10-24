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
              
              $items_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : 5; // selected rows

               // $total_items = count(getAllPlaces($db, $prefix));
               // $total_pages = ceil($total_items / $items_per_page);
               $stmt = $db->prepare('SELECT COUNT(*) as total FROM ' . $prefix['table_prefix'] . '_flussi_v_custom_blocks');
                $stmt->execute();
                $total_items = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                $total_pages = ceil($total_items / $items_per_page);
                $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
                $start = ($current_page - 1) * $items_per_page;

                $places = getAllPlaces($db, $prefix); 
                $menus = getMenuItems($db, $prefix); 
                $customblocks = getAllCustomBlocks($db, $prefix, $start, $items_per_page );
             
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
            <div id="get-customblock-edit"></div><!-- Selektorius -->

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
                            <td><?= htmlspecialchars_decode($customBlock['name']); ?></td>
                            <td>
                              <?php
                                  $html_code = htmlspecialchars_decode($customBlock['html_code']);
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
                        
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmCustomDeleteModal" data-custom-block-id="<?php echo $customBlock['id']; ?>" title="<?php echo t("Delete");?>">
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
<div class="modal fade" id="confirmCustomDeleteModal" tabindex="-1" aria-labelledby="confirmCustomDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmCustomDeleteModalLabel"><?php echo t("Confirm deletion");?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php echo t("Are you sure you want to delete this block?");?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger  delete-customblock-btn" id="confirm-custom-delete-btn"><?php echo t("Delete");?></button>
      </div>
    </div>
  </div>
</div>
<script>

function loadCustomBlockEditForm(customBlockId) {
    loadCustomBlockForm('edit', customBlockId);
  }
  function loadCustomBlocCreateForm(customBlockPlace) {
    loadCustomBlockForm('create', customBlockPlace);
  }
  
  $(document).ready(function () {
    $('button[data-bs-target="#confirmCustomDeleteModal"]').on('click', function () {
        const customblockId = $(this).data('custom-block-id');
      $('#confirmCustomDeleteModal').data('customblock-id', customblockId);
      $('#confirmCustomDeleteModal').modal('show');
    });
  
    $('#confirm-custom-delete-btn').on('click', function () {
      const customblockId = $('#confirmCustomDeleteModal').data('customblock-id');
    
      $.ajax({
        type: 'POST',
        url: 'delete_customblock.php',
        data: {
          action: 'delete_customblock',
          customblock_id: customblockId
        },
        success: function(response) {
          $('#confirmCustomDeleteModal').modal('hide');
          window.location.href = 'customblock.php';
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error(textStatus, errorThrown);
        }
      });
    });
    });
</script>
<?php
if (isset($_GET['edit_customblock_id'])) {
  $edit_customblock_id = filter_input(INPUT_GET, 'edit_customblock_id', FILTER_SANITIZE_NUMBER_INT);
  $safe_edit_customblock_id = htmlspecialchars($edit_customblock_id, ENT_QUOTES, 'UTF-8');
  echo "<script>loadCustomBlockEditForm($safe_edit_customblock_id);</script>";
}

if (isset($_GET['customblock_place'])) {
  $customblock_place = filter_input(INPUT_GET, 'customblock_place', FILTER_SANITIZE_STRING);
  $safe_customblock_place = htmlspecialchars($customblock_place, ENT_QUOTES, 'UTF-8');
  echo "<script>loadCustomBlocCreateForm('$safe_customblock_place');</script>";
}
?>
<script src="js/admin-customblock-edit.js"></script>

<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>