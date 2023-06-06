<footer class="footer bg-light py-3">
    <div class="container-fluid">
    <p class="text-center mb-0">
        <?php print $footer_text; ?>
    </p>
    </div>
</footer>

<script>
  $(document).ready(function() {
    $('.toast').toast({ autohide: true });
});

$(document).on('click', '.badge', function() {
    $(".badge").click(function() {
        var currentTags = $("#post_tags").val();
        var clickedTag = $(this).text().trim();
        
        if (!currentTags.includes(clickedTag)) {
            if (currentTags.length > 0) {
                $("#post_tags").val(currentTags + ", " + clickedTag);
            } else {
                $("#post_tags").val(clickedTag);
            }
        }
    });
});

$(document).ready(function() {
    $('.badge').on('click', function() {
        var tag = $(this).text();
        var confirmation = confirm('Ar tikrai norite ištrinti šį tag: ' + tag + '?');
        if (confirmation) {
            $.ajax({
                url: 'delete_tag.php',
                type: 'POST',
                data: {tag: tag},
                success: function(data) {
                      var toastNotification = new bootstrap.Toast(document.getElementById('toast-notification'));
                      toastNotification.show();

                      $('#toast-notification').on('hidden.bs.toast', function () {
                          location.reload();
                      })
                  },
                error: function() {
                    alert('Error deleting tag.');
                }
            });
        }
    });
});
</script>

<script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/js/content_redactor.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/js/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/popperjs/popper.min.js"></script>
<script>
  
 $(document).ready(function() {
            $('#search_term').on('keyup', function() {
        var search_term = $(this).val().toLowerCase();

        $('.translation-row').each(function() {
            var key = $(this).data('key').toLowerCase();
            var value = $(this).data('value').toLowerCase();

            if (key.includes(search_term) || value.includes(search_term)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    });

  setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000); 

        $(document).ready(function() {

            $('a[data-page]').on('click', function(e) {
                e.preventDefault();
                const page = $(this).data('page');

                $('#admin-content').load(page, function(response, status, xhr) {
                    if (status === 'error') {
                        console.error('Klaida įkeliant puslapį:', xhr.status, xhr.statusText);
                    }
                });
            });

 function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const content = document.getElementById("content");

    if (sidebar.classList.contains("sidebar-collapsed")) {
      sidebar.classList.remove("sidebar-collapsed");
      sidebar.classList.add("sidebar-expanded");
      content.classList.remove("col-custom");
      content.classList.add("col-md-10");
      content.classList.remove("main-content-collapsed-sidebar");
      content.classList.add("main-content-with-sidebar");
    } else {
      sidebar.classList.remove("sidebar-expanded");
      sidebar.classList.add("sidebar-collapsed");
      content.classList.remove("col-md-10");
      content.classList.add("col-custom");
      content.classList.remove("main-content-with-sidebar");
      content.classList.add("main-content-collapsed-sidebar");
    }

    if (content.classList.contains("col-custom")) {
      content.style.width = "calc(100% - 50px)"; 
    } else {
      content.style.width = "calc(100% - 250px)";
    }
  }
    $('#toggleSidebarBtn').on('click', toggleSidebar);
});

document.getElementById('settingsDropdown').addEventListener('click', function() {
  var submenu = document.getElementById('settingsSubmenu');
  if (submenu.style.display === "none") {
    submenu.style.display = "block";
  } else {
    submenu.style.display = "none";
  }
});

</script>


</body>
</html>
