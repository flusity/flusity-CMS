<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

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
 <?php
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

    $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar_holidays");
    $stmt->execute();
    $holidays = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
$edit_holiday_data = null;
if (isset($_GET['edit_holiday_id'])) {
    $edit_holiday_id = intval($_GET['edit_holiday_id']);
    $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar_holidays WHERE id = :edit_holiday_id");
    $stmt->bindParam(':edit_holiday_id', $edit_holiday_id, PDO::PARAM_INT);
    $stmt->execute();
    $edit_holiday_data = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

                <h3><?php echo t('Create Holiday'); ?></h3>
                <form action="../../cover/addons/event_callendar/action/add_holiday.php" method="post">
                    
                
                <input type="hidden" name="edit_holiday_id" value="<?php echo ($edit_holiday_data !== null) ? $edit_holiday_data['id'] : ''; ?>">      
                <input type="hidden" name="id" value="<?php echo $id; ?>">       
                <select name="month">
                    <option value="" disabled <?php echo ($edit_holiday_data === null) ? 'selected' : ''; ?>><?php echo t('Month'); ?></option>
                    <?php foreach ($monthNames as $key => $value): ?>
                        <option value="<?php echo $key; ?>" <?php echo ($edit_holiday_data !== null && $edit_holiday_data['month'] == $key) ? 'selected' : ''; ?>><?php echo t($value); ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="holiday">
                    <option value="" disabled <?php echo ($edit_holiday_data === null) ? 'selected' : ''; ?>><?php echo t('Day'); ?></option>
                    <?php for($i=1; $i<=31; $i++){ ?>
                        <option value="<?php echo $i; ?>" <?php echo ($edit_holiday_data !== null && $edit_holiday_data['holiday'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="holiday_name" placeholder="Holiday name" value="<?php echo ($edit_holiday_data !== null) ? htmlspecialchars($edit_holiday_data['holiday_name']) : ''; ?>">                       
                <input type="submit" value="<?php echo t('Add or Edit Holiday'); ?>">
                </form>


    <div class="form-group row p-2">
    <h3><?php echo t('All Holidays'); ?></h3>
    <table>
        <thead>
            <tr>
                <th><?php echo t('No.'); ?></th>
                <th><?php echo t('Holiday month'); ?></th>
                <th><?php echo t('Day'); ?></th>
                <th><?php echo t('Holiday Name'); ?></th>
                <th><?php echo t('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $i=1;
                foreach ($holidays as $holiday):  ?>
                <tr><?php //echo htmlspecialchars($holiday['id']); ?>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($monthNames[$holiday['month']]); ?></td>
                    <td><?php echo htmlspecialchars($holiday['holiday']); ?></td>
                    <td><?php echo htmlspecialchars($holiday['holiday_name']); ?></td>
                    <td><?php 
                    echo '<a href="addons_model.php?name=event_callendar&id='. htmlspecialchars($_GET['id']).'&edit_holiday_id='. htmlspecialchars($holiday['id']).'"><i class="fa fa-edit"></i></a>';        
                    echo '<a href="#" onclick="confirmDelete(\'../../cover/addons/event_callendar/action/delete_holiday.php?event_calendar='.$id.'&holiday_id='.htmlspecialchars($holiday['id']).'\')"><i class="fa fa-trash"></i></a>';

                    ?></td>
                    
                </tr>
        <?php $i++; 
            endforeach; ?>
        </tbody>
    </table>
</div>

        </div>

    </div>
</div>
          
            <div class="tab-pane fade" id="coordinators">
              <div class="form-group row p-2">
                <h3>
                    <?php echo t('Cabinet heads'); ?>
                </h3>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                        <i class="fa fa-plus plus-accordion-icon" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" title="Add Manager"></i>
                        
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                      
                            <form action="../../cover/addons/event_callendar/action/add_event_manager.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <select name="callendar_id" id="callendarSelect" data-placeholder="<?php echo t('Select Calendar...'); ?>">
                                <?php
                                $stmt = $db->prepare("SELECT id, callendar_name FROM " . $prefix['table_prefix'] . "_event_callendar");
                                $stmt->execute();
                                $calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($calendars as $calendar) {
                                    echo '<option value="' . $calendar['id'] . '">' . $calendar['callendar_name'] . '</option>';
                                }
                                ?>
                            </select>
 
                                <input type="text" name="event_name" placeholder="Event Name">
                                <input type="date" name="when_event_will_start" placeholder="When Event Will Start" value="<?php echo date('Y-m-d'); ?>">
                                <input type="text" name="event_days" placeholder="Event Days">
                                                
                                <select name="event_color">
                                    <option value="" disabled selected><?php echo t('Color'); ?></option>
                                    <option value="red">Red</option>
                                    <option value="green">Green</option>
                                    <option value="blue">Blue</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="orange">Orange</option>
                                    <option value="purple">Purple</option>
                                    <option value="pink">Pink</option>
                                    <option value="brown">Brown</option>
                                    <option value="teal">Teal</option>
                                    <option value="cyan">Cyan</option>
                                    <option value="magenta">Magenta</option>
                                    <option value="gold">Gold</option>
                                    <option value="silver">Silver</option>
                                    <option value="navy">Navy</option>
                                    <option value="lime">Lime</option>
                                    <option value="indigo">Indigo</option>
                                    <option value="beige">Beige</option>
                                    <option value="maroon">Maroon</option>
                                    <option value="olive">Olive</option>
                                </select>
                                
                                <select name="new_manager_id[]" multiple="multiple" id="managerSelect" data-placeholder="<?php echo t('Select Managers...'); ?>">
                                    
                                    <?php
                                    $stmt = $db->prepare("SELECT id, username FROM " . $prefix['table_prefix'] . "_flussi_users WHERE role IN ('admin', 'moderator')");
                                    $stmt->execute();
                                    $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($managers as $manager) {
                                        echo '<option value="' . $manager['id'] . '">' . $manager['username'] . '</option>';
                                    }
                                    ?>
                                </select>
                                
                                <input type="submit" value="<?php echo t('Add Event & Managers'); ?>">
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                <?php
                    $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar WHERE addon_id = :id");
                    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result !== false) {
                        $calendaries = $result['id'];
                    } else {

                        $calendaries = null;
                    }
                    ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <?php echo t('No.'); ?>
                            </th>
                            <th scope="col">
                                <?php echo t('Event Name'); ?>
                            </th>
                            <th scope="col">
                                <?php echo t('When Event Will Start'); ?>
                            </th>
                            <th scope="col">
                                <?php echo t('Event Days'); ?>
                            </th>
                            <th scope="col">
                                <?php echo t('Color'); ?>
                            </th>
                            <th scope="col">
                                <?php echo t('Managers'); ?>
                            </th>
                            <th scope="col">
                                <?php echo t('Actions'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar_laboratories WHERE callendar_id = :addon_id");
                            $stmt->bindParam(':addon_id', $calendaries, PDO::PARAM_INT);
                            $stmt->execute();
                            $laboratoryResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $counter = 1; 

                            foreach ($laboratoryResults as $laboratory) {
                                $managers = explode(',', $laboratory['managers']);
                                $managers = array_map('intval', $managers);
                                $placeholders = implode(',', array_fill(0, count($managers), '?'));

                                $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_flussi_users WHERE id IN ($placeholders)");
                                $stmt->execute($managers);
                                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                $managerNames = array_map(function($user) {
                                    return $user['username'] . " ";
                                }, $users);

                                echo '<tr>';
                                echo '<th scope="row">' . $counter . '</th>';
                                echo '<td>' . htmlspecialchars($laboratory['event_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($laboratory['when_event_will_start']) . '</td>';
                                echo '<td>' . htmlspecialchars($laboratory['event_days']) . '</td>';
                                echo '<td>' . htmlspecialchars($laboratory['event_color']) . '</td>';
                                echo '<td>' . implode(", ", $managerNames) . '</td>';
                                echo '<td>'; 
                                echo '<a href="addons_model.php?name=event_callendar&id=' . htmlspecialchars($_GET['id']) . '&addon_event_edit_id=' . htmlspecialchars($laboratory['id']) . '"><i class="fa fa-edit"></i></a> ';
                                echo '<a href="../../cover/addons/event_callendar/action/delete_event.php?name=event_callendar&id=' . htmlspecialchars($_GET['id']) . '&event_id=' . htmlspecialchars($laboratory['id']) . '"><i class="fa fa-trash"></i></a>';
                                echo '</td>';
                                echo '</tr>';

                                $counter++; 
                            }
                        ?>

                    </tbody>
                </table>
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
        if (confirm("Ar tikrai norite trinti?")) {
            window.location.href = url;
        }
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

</script>