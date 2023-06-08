<?php define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/core/template/admin-menu-horizontal.php';?>
  <button class="btn btn-primary position-fixed start-0 translate-middle-y d-md-none tools-settings" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
      <i class="fas fa-bars"></i>
  </button>
 <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/core/tools/sidebar.php';?>
<div class="container-fluid mt-4 main-content admin-layout">
    <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content-up">

        <?php
          $users = getAllUsers($db);
          ?>
    
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
    <h1><?php echo t("User's");?></h1>
      <!-- Išveda Vartotojo redagavimo langą -->
      <div id="get-user-edit"></div>
    <table class="table">
        <thead>
            <tr>
                <th><?php echo t("No.");?></th>
                <th><?php echo t("Login Name");?></th>
                <!-- <th><?php // echo t("Username");?></th>
                <th><?php // echo t("Surname");?></th>
                <th><?php // echo t("Phone");?></th> -->
                <th><?php echo t("Email");?></th>
                <th><?php echo t("Role");?></th>
                <th><?php echo t("Actions");?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            foreach ($users as $user) { ?>
                <tr>
                    <td><?php $i=$i+1; echo $i; ?>.</td>
                    <td><?php echo htmlspecialchars($user['login_name']); ?></td>
                    <!-- <td><?php // echo htmlspecialchars($user['username']); ?></td>
                    <td><?php // echo htmlspecialchars($user['surname']); ?></td>
                    <td><?php // echo htmlspecialchars($user['phone']); ?></td> -->
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                       <button type="button" class="btn btn-sm btn-primary" onclick="loadUserEditForm(<?php echo $user['id']; ?>)" title="<?php echo t('Edit'); ?>">
                        <i class="fas fa-edit"></i>
                        </button>
                       
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="<?php echo $user['id']; ?>" title="<?php echo t('Delete'); ?>">
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
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel"><?php echo t('Confirm the removal'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php echo t('Are you sure you want to delete this User?'); ?>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger  delete-user-btn" id="confirm-delete-btn"><?php echo t("Remove");?></button>
      </div>
    </div>
  </div>
</div>

<script src="js/admin-user-edit.js"></script>
<script>

$('button[data-bs-target="#deleteUserModal"]').on('click', function () {
      const userId = $(this).data('user-id');
      $('#confirmDeleteModal').data('user-id', userId);
      $('#confirmDeleteModal').modal('show');
    });
  
    $('#confirm-delete-btn').on('click', function () {
      const userId = $('#confirmDeleteModal').data('user-id');
      $.ajax({
        type: 'POST',
        url: 'delete_user.php',
        data: {
          action: 'delete_user',
          user_id: userId
        },
        success: function(response) {
          $('#confirmDeleteModal').modal('hide');
          window.location.href = 'users.php';
        },
        error: function(jqXHR, textStatus, errorThrown) {
         
          console.error(textStatus, errorThrown);
        }
      });
    });

</script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>
