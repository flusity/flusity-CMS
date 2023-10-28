<div class="accordion accordion-flush" id="accordionFlushExample">
 <div class="accordion-item">
     <h2 class="accordion-header" id="flush-headingOne">
     <i class="fa fa-plus plus-accordion-icon" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" title="Add Manager"></i>
     
     </h2>
     <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
     <div class="accordion-body">
         <?php
         $editId = isset($_GET['event_edit_id']) ? intval($_GET['event_edit_id']) : null;
         if ($editId !== null) {
             $stmt = $db->prepare("SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar_laboratories WHERE id = :id");
             $stmt->bindParam(':id', $editId, PDO::PARAM_INT);
             $stmt->execute();
             $eventToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
             
         }
         ?>

         <form action="../../cover/addons/event_callendar/action/add_event_manager.php" method="post">
         <input type="hidden" name="action" value="<?php echo isset($eventToEdit) ? 'edit' : 'add'; ?>">
         <input type="hidden" name="id" value="<?php echo $id; ?>">
         <input type="hidden" name="event_edit_id" value="<?php echo $editId; ?>">
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

         <input type="text" name="event_name" placeholder="Event Name" value="<?php echo isset($eventToEdit) ? htmlspecialchars($eventToEdit['event_name']) : ''; ?>">
         <input type="date" name="when_event_will_start" placeholder="When Event Will Start" value="<?php echo isset($eventToEdit) ? htmlspecialchars($eventToEdit['when_event_will_start']) : date('Y-m-d'); ?>">
         <input type="text" name="event_days" placeholder="Event Days" value="<?php echo isset($eventToEdit) ? htmlspecialchars($eventToEdit['event_days']) : ''; ?>">
                         
             <select name="event_color">
                 <option value="" disabled <?php echo !isset($eventToEdit) ? 'selected' : ''; ?>><?php echo t('Color'); ?></option>
                 <option value="red" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'red' ? 'selected' : ''; ?>><?php echo t('Red'); ?></option> <!-- 337 eilutė -->
                 <option value="green" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'green' ? 'selected' : ''; ?>><?php echo t('Green'); ?></option>
                 <option value="blue" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'blue' ? 'selected' : ''; ?>><?php echo t('Blue'); ?></option>
                 <option value="yellow" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'yellow' ? 'selected' : ''; ?>><?php echo t('Yellow'); ?></option>
                 <option value="orange" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'orange' ? 'selected' : ''; ?>><?php echo t('Orange'); ?></option>
                 <option value="purple" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'purple' ? 'selected' : ''; ?>><?php echo t('Purple'); ?></option>
                 <option value="pink" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'pink' ? 'selected' : ''; ?>><?php echo t('Pink'); ?></option>
                 <option value="brown" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'brown' ? 'selected' : ''; ?>><?php echo t('Brown'); ?></option>
                 <option value="teal" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'teal' ? 'selected' : ''; ?>><?php echo t('Teal'); ?></option>
                 <option value="cyan" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'cyan' ? 'selected' : ''; ?>><?php echo t('Cyan'); ?></option>
                 <option value="magenta" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'magenta' ? 'selected' : ''; ?>><?php echo t('Magenta'); ?></option>
                 <option value="gold" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'gold' ? 'selected' : ''; ?>><?php echo t('Gold'); ?></option>
                 <option value="silver" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'silver' ? 'selected' : ''; ?>><?php echo t('Silver'); ?></option>
                 <option value="navy" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'navy' ? 'selected' : ''; ?>><?php echo t('Navy'); ?></option>
                 <option value="lime" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'lime' ? 'selected' : ''; ?>><?php echo t('Lime'); ?></option>
                 <option value="indigo" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'indigo' ? 'selected' : ''; ?>><?php echo t('Indigo'); ?></option>
                 <option value="beige" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'beige' ? 'selected' : ''; ?>><?php echo t('Beige'); ?></option>
                 <option value="maroon" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'maroon' ? 'selected' : ''; ?>><?php echo t('Maroon'); ?></option>
                 <option value="olive" <?php echo isset($eventToEdit) && $eventToEdit['event_color'] === 'olive' ? 'selected' : ''; ?>><?php echo t('Olive'); ?></option>
             </select>
             
             <select name="new_manager_id[]" multiple="multiple" id="managerSelect"   data-placeholder="<?php echo t('Select Managers...'); ?>">
             <?php
             $stmt = $db->prepare("SELECT id, username FROM " . $prefix['table_prefix'] . "_flussi_users WHERE role IN ('admin', 'moderator')");
             $stmt->execute();
             $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);
             foreach ($managers as $manager) {
                 $selected = isset($eventToEdit) && in_array($manager['id'], explode(',', $eventToEdit['managers'])) ? 'selected' : '';
                 echo '<option value="' . $manager['id'] . '" ' . $selected . '>' . $manager['username'] . '</option>';
             }
             ?>
         </select>
             
         <input type="submit" value="<?php echo t('Add/Edit Event & Managers'); ?>">
         <a href="addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($_GET['id']) ?>" class="btn btn-secondary"><?php echo t('Cancel');?></a>

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
             echo '<a href="addons_model.php?name=event_callendar&id=' . htmlspecialchars($_GET['id']) . '&event_edit_id=' . htmlspecialchars($laboratory['id']) . '"  value="'.isset($eventToEdit).'"><i class="fa fa-edit"></i></a>';
             echo '<a href="#" onclick="return confirmDelete(\'../../cover/addons/event_callendar/action/delete_event.php?name=event_callendar&id=' . htmlspecialchars($_GET['id']) . '&event_id=' . htmlspecialchars($laboratory['id']) . '\')"><i class="fa fa-trash"></i></a>';
             echo '</td>';
             echo '</tr>';

             $counter++; 
         }
     ?>

 </tbody>
</table>
