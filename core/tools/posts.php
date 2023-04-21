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
        <?php   $i = 1;
                $limit = 5; // Kiek įrašų rodyti per puslapį
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                $posts = getAllPostsPagination($db, $start, $limit);
                $total_posts = countAllPosts($db);
                $total_pages = ceil($total_posts / $limit);




          //$posts = getAllPosts($db);
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
            <h2>Posts on pages</h2>
            <button type="button" class="btn btn-sm btn-primary" onclick="loadPostForm('create')" title="Add">

              <i class="fas fa-pencil"></i>
            </button>
            <!-- Išveda Puslapio redagavimo langą -->
            <div id="get-post-edit"></div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 3%;">Nr.</th>
                        <th style="width: 17%;">Title</th>
                        <th style="width: 40%;">Content</th>
                        <th style="width: 13%;">Public</th>
                        <th style="width: 12%;">Author</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) { ?>
                        <tr>
                            <!-- <td><?php //echo htmlspecialchars($post['id']); ?></td> -->
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td>
                            <?php
                                $content = htmlspecialchars($post['content']);
                                $max_length = 100; // Nustatykite norimą maksimalų simbolių kiekį
                                if (strlen($content) > $max_length) {
                                    echo substr($content, 0, $max_length) . '...';
                                } else {
                                    echo $content;
                                }
                            ?>
                            </td>
                            <td><?php echo htmlspecialchars($post['status']); ?></td>
                            <td><?php echo htmlspecialchars($user_name); ?></td>
                            <td>
                                
                                <button type="button" class="btn btn-sm btn-primary" onclick="loadPostEditForm(<?php echo $post['id']; ?>)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal" data-post-id="<?php echo $post['id']; ?>" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
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
        Ar tikrai norite ištrinti šį įrašą?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atšaukti</button>
        <button type="button" class="btn btn-danger delete-post-btn" id="confirm-delete-btn">Ištrinti</button>
      </div>
    </div>
  </div>
</div>
<script>
  function loadPostEditForm(postId) {
    loadPostForm('edit', postId);
  }
</script>

<script src="js/admin-post-edit.js"></script>

<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>
