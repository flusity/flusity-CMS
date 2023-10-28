<?php     
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
                   echo '<a href="#" onclick="confirmDelete2(\'../../cover/addons/event_callendar/action/delete_holiday.php?event_calendar='.$id.'&holiday_id='.htmlspecialchars($holiday['id']).'\')"><i class="fa fa-trash"></i></a>';

                   ?></td>
                   
               </tr>
       <?php $i++; 
           endforeach; ?>
       </tbody>
   </table>
</div>