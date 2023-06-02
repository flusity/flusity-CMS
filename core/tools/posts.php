<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';
$limit_per_page = $settings['posts_per_page'];
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
                $limit = $limit_per_page;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                $posts = getAllPostsPagination($db, $start, $limit);
                $total_posts = countAllPosts($db);
                $total_pages = ceil($total_posts / $limit);
                $allPost = getAllPosts($db);
                $menuItems = getMenuItems($db);
                $menuItemsIndexed = array_column($menuItems, null, 'id');
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
            <h2><?php echo t("Posts on pages");?></h2>
            <button type="button" class="btn btn-sm btn-primary" onclick="loadPostForm('create')" title="Add">
              <i class="fas fa-pencil"></i>
            </button>
            <!-- Išveda Puslapio redagavimo langą -->
            <div id="get-post-edit"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 3%;"><?php echo t("No.");?></th>
                        <th style="width: 17%;"><?php echo t("Title");?></th>
                        <th style="width: 40%;"><?php echo t("Content");?></th>
                        <th style="width: 12%;"><?php echo t("Page");?></th>
                        <th style="width: 3%;"><i title="<?php echo t("Public");?>" class="fas fa-eye"></i></th>
                        <th style="width: 8%;"><?php echo t("Author");?></th>
                        <th style="width: 10%;"><?php echo t("Actions");?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $post) { 
                        if (isset($menuItemsIndexed[$post['menu_id']])) {
                            $post['menu_name'] = $menuItemsIndexed[$post['menu_id']]['name'];
                        } else {
                            $post['menu_name'] = '';
                        }
                ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td>
                            <?php
                                $content = htmlspecialchars_decode($post['content']);
                                $content = preg_replace('/<img[^>]+>/i', '[image or file]', $content);
                                $content = preg_replace('/<hr[^>]*>/i', '___', $content);

                                // Pakeičiamas visų naujų eilučių simbolis į tarpą
                                $content = str_replace(array("\r", "\n"), ' ', $content);
                                // Pašalinamos visos HTML žymos
                                $content = strip_tags($content);

                                $max_length = 150;
                                if (strlen($content) > $max_length) {
                                    echo substr($content, 0, $max_length) . '...';
                                } else {
                                    echo $content;
                                }
                            ?>
                            </td>
                            <td><?php echo htmlspecialchars($post['menu_name']); ?></td>
                            <td><?php 
                                      if ($post['status'] == 'published') {
                                          echo 'On';
                                      } elseif ($post['status'] == 'draft') {
                                          echo 'Off';
                                      }
                                  ?></td>
                            <td><?php echo htmlspecialchars($user_name); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="loadPostEditForm(<?php echo $post['id']; ?>)" title="<?php echo t("Edit");?>">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal" data-post-id="<?php echo $post['id']; ?>" title="<?php echo t("Delete");?>">
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
        <h5 class="modal-title" id="confirmDeleteModalLabel"><?php echo t("Confirm deletion");?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php echo t("Are you sure you want to delete this post?");?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
        <button type="button" class="btn btn-danger delete-post-btn" id="confirm-delete-btn"><?php echo t("Delete");?></button>
      </div>
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="imageSelectOffcanvas" data-bs-backdrop="false" data-bs-scroll="true">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Select an Image</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  </div>
</div>

<script>
  function loadPostEditForm(postId) {
    loadPostForm('edit', postId);
  }
  
  $('button[data-bs-target="#deletePostModal"]').on('click', function () {
    const postId = $(this).data('post-id');
    $('#confirmDeleteModal').data('post-id', postId);
    $('#confirmDeleteModal').modal('show');
  });
  
  $('#confirm-delete-btn').on('click', function () {
    const postId = $('#confirmDeleteModal').data('post-id');
    $.ajax({
      type: 'POST',
      url: 'delete_post.php',
      data: {
        action: 'delete_post',
        post_id: postId
      },
      success: function(response) {
        $('#confirmDeleteModal').modal('hide');
        window.location.href = 'posts.php';
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });

  
</script>
<script src="js/admin-post-edit.js"></script>
<?php require_once ROOT_PATH . 'core/template/admin-footer.php';?>