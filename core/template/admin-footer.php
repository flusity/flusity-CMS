<script>
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

    $('.selectable-image').on('click', function() {
    var imageName = $(this).data('image-name');
    var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('imageSelectOffcanvas'));
    offcanvas.hide();
    addImage(imageName);
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

var quill = new Quill('#editor', {
    theme: 'snow'
});

document.querySelector('#post-form').addEventListener('submit', function() {
    var content = quill.root.innerHTML;
    document.querySelector('#post_content').value = content;
});
</script>
   
<script src="../tools/js/content_redactor.js"></script>
</body>
</html>
