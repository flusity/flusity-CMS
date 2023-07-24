
<footer class="footer">
        <div class="container-fluid text-bg-secondary p-3" style="z-index: 999;">
           <div class="row">
            <div class="col-12 text-center">
            <p class="text-center mb-0">
        <?php print $footer_text; ?>
    </p>
            </div>
           </div>
       </div>
    </footer>
    <script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/ckeditor/ckeditor.js"></script> 
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

});

document.getElementById('settingsDropdown').addEventListener('click', function() {
  var submenu = document.getElementById('settingsSubmenu');
  if (submenu.style.display === "none") {
    submenu.style.display = "block";
  } else {
    submenu.style.display = "none";
  }
});

        window.addEventListener('DOMContentLoaded', (event) => {
        var mediaQueryList = window.matchMedia('(max-width: 768px)');

        var sidebar = document.getElementById('sidebar');
        var sidebarOffcanvasBody = document.getElementById('sidebarOffcanvasBody');

        function handleScreenChange(e) {
            if (e.matches) {
                while (sidebar.children.length > 0) {
                    sidebarOffcanvasBody.appendChild(sidebar.children[0]);
                }
            } else {
                while (sidebarOffcanvasBody.children.length > 0) {
                    sidebar.appendChild(sidebarOffcanvasBody.children[0]);
                }
            }
        }
        mediaQueryList.addListener(handleScreenChange);
        handleScreenChange(mediaQueryList);
    });
    document.getElementById("settingsDropdown").addEventListener("click", function(event) {
    var submenu = document.getElementById("settingsSubmenu");
    if (submenu.style.display === "none") {
        submenu.style.display = "block";
    } else {
        submenu.style.display = "none";
    }
    event.preventDefault(); // Čia sustabdomas numatytasis nuorodos veikimas
});
var dropdown = document.getElementById("settingsDropdown");
var submenuLinks = document.querySelectorAll('#settingsSubmenu a');
if (dropdown) {
    dropdown.addEventListener("click", function(event) {
        var submenu = document.getElementById("settingsSubmenu");
        if (submenu.style.display === "none") {
            submenu.style.display = "block";
        } else {
            submenu.style.display = "none";
        }
        event.preventDefault();
    });

    submenuLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.stopPropagation();
        });
    });
}
</script>

</body>
</html>
