<?php 
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

<?php $places = getAllPlaces($db); ?>

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
    <h1><?php echo t("Layout Places");?></h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlaceModal" data-mode="add">
    <?php echo t("Add Place");?>
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
                $i=1;
                 foreach ($places as $place) { ?>
                    <tr>  
                        <td><?php  echo $i++;?>.</td>
                        <td><?php echo htmlspecialchars($place['name']); ?></td>
                        <td>  
                          <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPlaceModal" data-place-id="<?php echo $place['id']; ?>" data-mode="update" title="<?php echo t("Edit");?>">
                          <i class="fas fa-edit"></i>
                          </button>
                        
                          <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePlaceModal" data-place-id="<?php echo $place['id']; ?>" title="<?php echo t("Delete");?>">
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
                 </main>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addPlaceModal" tabindex="-1" aria-labelledby="addPlaceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPlaceModalLabel"><?php echo t("Add Place");?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-place-form">
          <div class="form-group">
            <label for="place_name"><?php echo t("Place Name");?></label>
            <input type="text" class="form-control" id="place_name" name="place_name" required>
          </div>
          <button type="submit" class="btn btn-primary mt-3" id="submit-button"><?php echo t("Add Place");?></button>
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
      <?php echo t("Are you sure you want to delete this Place?");?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger  delete-place-btn" id="confirm-delete-btn"><?php echo t("Delete");?></button>
      </div>
    </div>
  </div>
</div>
<script>
// Prideda kategoriją po paspaudimo
$('#add-place-form').on('submit', function (e) {
  e.preventDefault();

  const placeName = $('#place_name').val();
  const mode = $('#addPlaceModal').data('mode');
  const placeId = $('#addPlaceModal').data('place-id');

  let url;
  let action;

  if (mode === 'add') {
    url = 'add_places.php';
    action = 'add_place';
  } else if (mode === 'update') {
    url = 'update_place.php';
    action = 'update_place';
  } else {
    console.error('Invalid mode');
    return;
  }

  $.ajax({
    type: 'POST',
    url: url,
    data: {
      action: action,
      place_id: placeId,
      place_name: placeName,
    },
    success: function (response) {
      console.log(response);

      // Uždaro modal
      $('#addPlaceModal').modal('hide');

      // Išvalo input laukus
      $('#place_name').val('');
      location.reload();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
    },
  });
});

$('#addPlaceModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget); 
  const mode = button.data('mode'); 
  const placeId = button.data('place-id'); 

  const modal = $(this);
  modal.data('mode', mode);
  modal.data('place-id', placeId);

  if (mode === 'update') {
    const placeName = button.closest('tr').find('td:nth-child(2)').text();
    $('#place_name').val(placeName);
    modal.find('.modal-title').text('Edit Place');
    modal.find('#submit-button').text('Update Place');
  } else {
    $('#place_name').val('');
    modal.find('.modal-title').text('Add Place');
    modal.find('#submit-button').text('Add Place');
  }
});

$(document).ready(function () {
  // Paspaudus ištrynimo mygtuką, atidaro patvirtinimo modalą
  $('button[data-bs-target="#deletePlaceModal"]').on('click', function () {
    const placeId = $(this).data('place-id');
    $('#confirmDeleteModal').data('place-id', placeId);
    $('#confirmDeleteModal').modal('show');
  });

  // Paspaudus patvirtinimo mygtuką, ištrina kategoriją
  $('#confirm-delete-btn').on('click', function () {
    const placeId = $('#confirmDeleteModal').data('place-id');
    
    // Siunčia POST užklausą į delete_place.php failą
    $.ajax({
      type: 'POST',
      url: 'delete_place.php',
      data: {
        action: 'delete_place',
        place_id: placeId
      },
      success: function(response) {
        // Uždaro modalą ir peradresuoja į places.php puslapį
        $('#confirmDeleteModal').modal('hide');
        window.location.href = 'places.php';
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });
});

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>