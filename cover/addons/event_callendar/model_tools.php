<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$monthNames = array(
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
);

$name_addon ='event_callendar';
$id = intval(htmlspecialchars($_GET['id']));
$placesId = getplaces($db, $prefix);
$menuId = getMenuItems($db, $prefix);
$settings = getSettings($db, $prefix);
$stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$addonId = isset($_GET['addon_event_edit_id']) ? (int)htmlspecialchars($_GET['addon_event_edit_id']) : 0;
$addonPlace = isset($_GET['place_name']) ? $_GET['place_name'] : null; 
$addonMenuId = isset($_GET['menu']) ? $_GET['menu'] : null; 
$mode = $addonId > 0 ? 'edit' : 'create';
$selected_place_id = getPlaceIdByName($db, $prefix, $addonPlace);
$addon = $mode === 'edit' ? getAddonById($db, $prefix, $name_addon, $addonId) : null;
$selectedMenuId = ($mode === 'edit' && $addon) ? $addon['menu_id'] : $addonMenuId;

if ($mode === 'create' || $addon) { ?>
<div class="col-md-12">
    <h4>
        <?php echo t('Addon JD Flusity \'Event Callendar\' ');?>
    </h4>
        <ul class="nav nav-tabs  mt-2">
            <li class="nav-item tabs-nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#calendar">
                    <?php echo t("Calendar settings");?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#coordinators">
                    <?php echo t("Coordinators of activities");?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#calendarItem">
                    <?php echo t("Calendar event activities");?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#eventRegistration">
                    <?php echo t("Event registration");?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tabs-nav-item" data-bs-toggle="tab" href="#members">
                    <?php echo t("Member User");?>
                </a>
            </li>

        </ul>
<div class="tab-content">  
        <div class="tab-pane fade show active" id="calendar">
         <div class="form-group row p-2">
            <form id="update-addon-form" method="POST" action="../../cover/addons/event_callendar/action/<?php echo $mode === 'edit' ? 'edit_addon.php' : 'add_addon.php'; ?>"
                enctype="multipart/form-data" class="col-md-10">
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="addon_event_edit_id" value="<?php echo isset($addon['id']) ? $addon['id'] : ''; ?>">
                <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">

                <?php
                $stmt = $db->prepare("SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_event_callendar WHERE addon_id = :id");
                $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                $showFields = ($count == 0) || ($mode === 'edit');
                
                if($showFields): ?>
                    <div class="form-group row p-2">
                    <div class="col-md-4 mb-3">
                        <label for="addon_place_id"><?php echo t('Place');?></label>
                        <select class="form-control" id="addon_place_id" name="addon_place_id" required>

                    <?php foreach ($placesId as $place) : ?>
                            <option value="<?php echo $place['id']; ?>" 
                                <?php 
                                if (($mode === 'edit' && $addon['place_id'] === $place['id']) || 
                                    ($mode === 'create' && $selected_place_id === $place['id'])) echo 'selected'; 
                                ?>>
                                <?php echo htmlspecialchars($place['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="addon_menu_id"><?php echo t('Menu');?></label>
                        <select class="form-control" id="addon_menu_id" name="addon_menu_id" required>
                        <option value="0"><?php echo t('To all pages');?></option>
                         <?php  foreach ($menuId as $menu) : ?>
                        <option value="<?php echo $menu['id']; ?>"
                        <?php echo ($selectedMenuId == $menu['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($menu['name']); ?>
                        </option>
                    <?php endforeach;?>
                    </select>
                    </div>

                    <div class="col-md-5 mb-3">
                        <label for="calendarFormControlInput" class="form-label"><?php echo t('Calendar Name');?></label>
                        <input type="text" class="form-control" name="callendar_name" id="calendarFormControlInput" placeholder="Name" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['callendar_name']) : ''; ?>" required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="calendarFormControlworkDayStartInput" class="form-label"><?php echo t('Work day start');?></label>
                        <input type="time" class="form-control" name="work_dayStart" id="calendarFormControlworkDayStartInput" placeholder="work day Start" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['work_dayStart']) : ''; ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="calendarFormControlWorkDayEndInput" class="form-label"><?php echo t('Work day End');?></label>
                        <input type="time" class="form-control" name="work_dayEnd" id="calendarFormControlWorkDayEndInput" placeholder="work day End" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['work_dayEnd']) : ''; ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="calendarFormControlLunchBreakStartInput" class="form-label"><?php echo t('Lunch time Start');?></label>
                        <input type="time" class="form-control" name="lunch_breakStart" id="calendarFormControlLunchBreakStartInput" placeholder="Lunch Start" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['lunch_breakStart']) : ''; ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="calendarFormControlLunchBreakEndInput" class="form-label"><?php echo t('Lunch time end');?></label>
                        <input type="time" class="form-control" name="lunch_breakEnd" id="calendarFormControlLunchBreakEndInput" placeholder="Lunch End" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['lunch_breakEnd']) : ''; ?>" required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="calendarFormControlPrepareInput" class="form-label"><?php echo t('Prepare time');?></label>
                        <input type="text" class="form-control" name="prepare_time" id="calendarFormControlPrepareInput" placeholder="Prepare time" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['prepare_time']) : ''; ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="calendarFormControlRegisEndDateInput" class="form-label"><?php echo t('Regist. end date');?></label>
                        <input type="text" class="form-control" name="registration_end_date" id="calendarFormControlRegisEndDateInput" placeholder="registr. end date" value="<?php echo $mode === 'edit' ? htmlspecialchars($addon['registration_end_date']) : ''; ?>" required>
                    </div>

                    <div class="col-md-5 mb-3">
                        <button type="submit" name="submit" class="btn btn-primary"><?php echo t('Submit');?></button>
                        <?php if (isset($_GET['addon_event_edit_id'])): ?>
                        <a href="addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($_GET['id']) ?>"
                            class="btn btn-secondary">
                            <?php echo t('Cancel');?>
                        </a>
                        <?php endif; ?>
                    </div>
                    </div>

                    <?php  endif; ?>

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">
                                    <?php echo t("Calendar Name");?>
                                </th>
                                <th scope="col" width="15%">
                                    <?php echo t("Menu");?>
                                </th>
                                <th scope="col" width="10%">
                                    <?php echo t("Place");?>
                                </th>
                                <th scope="col" width="8%">
                                    <?php echo t("Actions");?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
                $get_params = $_GET;
                unset($get_params['page']);
                
                $get_param_str = '';
                if (!empty($get_params)) {
                    $get_param_str = http_build_query($get_params) . '&';
                }
   
                    $stmt = $db->prepare("SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_event_callendar");
                    $stmt->execute();
                    $total_addons = $stmt->fetchColumn();
                    $stmt = $db->prepare("SELECT addons.id, addons.callendar_name, menu.name as menu_name, places.name as place_name, addons.menu_id
                    FROM " . $prefix['table_prefix'] . "_event_callendar as addons LEFT JOIN " .
                    $prefix['table_prefix'] . "_flussi_menu as menu ON addons.menu_id = menu.id LEFT JOIN " .
                    $prefix['table_prefix'] . "_flussi_places as places ON addons.place_id = places.id ORDER BY addons.id DESC");
                    $stmt->execute();
                    $addonResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($addonResults as $addonRes) {
                        echo '<tr>';
                        $short_callendar_name = htmlspecialchars(mb_substr($addonRes['callendar_name'], 0, 60));
                        $short_menu = htmlspecialchars($addonRes['menu_name']);
                        $short_place = htmlspecialchars($addonRes['place_name']);
                        $shot_menu_id = htmlspecialchars($addonRes['menu_id']);
                        echo '<td>' . $short_callendar_name . '</td>';
                       
                        echo '<td>';  if($shot_menu_id >0 ){ echo $short_menu; } else { echo t('All pages');} 
                        echo '</td>';
                        echo '<td>' . $short_place . '</td>';
                        echo '<td>';
                        echo '<a href="addons_model.php?name=event_callendar&id=' . htmlspecialchars($_GET['id']) . '&addon_event_edit_id=' . htmlspecialchars($addonRes['id']) . '"><i class="fa fa-edit"></i></a> ';
                    ?>
                        <a href="javascript:void(0);" onclick="deleteEventAddon(<?php echo htmlspecialchars($addonRes['id']); ?>)"><i class="fa fa-trash"></i></a>
                    
                        </td>
                        </tr>
                   <?php  } ?>
                </form>
                </tbody>
                </table> 
                <div class="form-group row p-2">
                    
                <?php require ("holidays.php");?>
            
            </div>
        </div>
    </div>
        <div class="tab-pane fade" id="coordinators" data-tab="coordinators">
            <div class="form-group row p-2">
                <h3>
                    <?php echo t('Cabinet heads'); ?>
                </h3>
               <?php require ("coordinators.php");?>
            </div>
  
        </div>
        
        <div class="tab-pane fade" id="calendarItem" data-tab="calendarItem">
            <div class="form-group p-2">
                <h3>
                    <?php echo t('Event activities'); ?>
                </h3>
                <?php require ("event_activities.php");?>

            </div>
        </div>
        <div class="tab-pane fade" id="eventRegistration" data-tab="eventRegistration">
            <div class="form-group row p-2">
                <h3>
                    <?php echo t('Event registration'); ?>
                </h3>
                <?php require ("event_registration.php");?>
        
            </div>
        </div>
        <div class="tab-pane fade" id="members" data-tab="members">
            <div class="form-group row p-2">
                <h3>
                    <?php echo t('Member Users'); ?>
                </h3>
                <?php require ("members.php");?>
    
            </div>
        </div>
    </div>
</div>

<?php  } else { 
    echo t("No such record exists");
 } ?>

<div class="modal tools fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo t("Delete confirm");?></h5>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
           <p style="font-size: 24px; color: red;"><?php echo t("Are you sure you want to delete this calendar block?");?> </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo t("Cancel");?></button>
                <button type="button" class="btn btn-danger" id="confirmDelete"><?php echo t("Delete");?></button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        $('#managerSelect').select2();
    });
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete?")) {
            window.location.href = url;
        }
    }

    function confirmDelete2(url) {
        if (confirm("Are you sure you want to delete this item?")) {
            window.location.href = url;
        }
        return false;
    }

    function confirmDelete3(url) {
        if (confirm("Are you sure you want to delete this activity?")) {
            window.location.href = url;
        }
        return false;
    }

    function confirmDelete4(url) {
        if (confirm("Are you sure you want to delete this registration?")) {
            window.location.href = url;
        }
        return false;
    }

    function deleteEventAddon(addonId) {
        $("#deleteModal").modal("show");
        $("#confirmDelete").off('click').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '../../cover/addons/event_callendar/action/delete_calendar_addon.php',
                data: {
                    name: 'event_callendar',
                    id: '<?php echo htmlspecialchars($_GET['id']); ?>',
                    addon_event_id: addonId
                },
                success: function(response) {
                    window.location.href = 'addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($_GET['id']); ?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
            $("#deleteModal").modal("hide");
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const eventEditId = urlParams.get('event_edit_id');

        if(eventEditId) {
            var tab = new bootstrap.Tab(document.querySelector('a[href="#coordinators"]'));
            tab.show();

            var myAccordion = document.getElementById('accordionFlushExample');
            var bsCollapse = new bootstrap.Collapse(myAccordion.querySelector('.collapse'), {
                toggle: true
            });
        }
    });

    $(document).ready(function() {
    const thumbnailElement = document.getElementById('thumbnailEvent');
    const metodicTextElement = document.getElementById('metodicThumbnail'); // Naujas tekstas

    // Inicializuojame Select2 image_id
    $('#image_id').select2().on('select2:select', function (e) {
        const data = e.params.data;
        const imgSrc = $(data.element).attr('data-img-src');
        
        thumbnailElement.src = imgSrc;
    });

    // Inicializuojame Select2 metodic_file_id
    $('#metodic_file_id').select2().on('select2:select', function (e) {
        const data = e.params.data;
        const fileName = data.text; // Gausime pasirinkto elemento tekstą
        
        metodicTextElement.innerText = fileName; // Naujas tekstas
    });

    // Inicialinis paveikslėlio rodymas image_id
    const initialImgSrc = $('#image_id').find(':selected').data('img-src');
    if (initialImgSrc) {
        thumbnailElement.src = initialImgSrc;
    }

    // Inicialinis failo pavadinimo rodymas metodic_file_id
    const initialMetodicFileName = $('#metodic_file_id').find(':selected').text();
    if (initialMetodicFileName) {
        metodicTextElement.innerText = initialMetodicFileName; // Naujas tekstas
    }
});


$(document).ready(function() {
  $('.accordion-button').click(function() {
    let collapseId = $(this).attr('data-bs-target');
    if ($(collapseId).hasClass('show')) {
      sessionStorage.setItem('activeAccordion', '');
    } else {
      sessionStorage.setItem('activeAccordion', collapseId);
    }
  });

  $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
    let tabId = $(e.target).attr('href');
    sessionStorage.setItem('activeTab', tabId);
  });

  let activeAccordion = sessionStorage.getItem('activeAccordion');
  if (activeAccordion) {
    $(activeAccordion).addClass('show');
    $(`button[data-bs-target="${activeAccordion}"]`).removeClass('collapsed');
  }

  let activeTab = sessionStorage.getItem('activeTab');
  if (activeTab) {
    $('a[href="' + activeTab + '"]').tab('show');
  }
});


</script>