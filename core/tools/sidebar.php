<div class="col-md-2 sidebar-bg sidebar nav flex-column" id="sidebar">
 <?php
   $sidebar = new Sidebar($db);
   echo $sidebar->render();
 ?>
</div>
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarOffcanvas" data-bs-scroll="true" data-bs-backdrop="false">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>

    </div>
    <div class="offcanvas-body" id="sidebarOffcanvasBody">
    </div>
</div>
