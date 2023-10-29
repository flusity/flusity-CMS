<?php
    $sql = "SELECT 
    item.id, lab.event_name AS laboratory_name, item.title, item.short_description, item.methodical_material, item.time_limit,
    item.target_audience, item.created, item.metodic_file_id, item.updated
    FROM " . $prefix['table_prefix'] . "_event_callendar_item AS item
    LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_laboratories AS lab ON item.laboratories_id = lab.id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlLabs = "SELECT id, event_name FROM " . $prefix['table_prefix'] . "_event_callendar_laboratories";
    $stmtLabs = $db->prepare($sqlLabs);
    $stmtLabs->execute();
    $laboratories = $stmtLabs->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM " . $prefix['table_prefix'] . "_flussi_files";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $isEditing = isset($_GET['edit_activity_id']);

    if ($isEditing) {
        $activity_id = intval($_GET['edit_activity_id']);
        $sql = "SELECT * FROM " . $prefix['table_prefix'] . "_event_callendar_item WHERE id = :activity_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
        $stmt->execute();
        $activity = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>
<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            <?php echo t('Create a new activity or edit one'); ?>
            </button></h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="POST" action="../../cover/addons/event_callendar/action/add_activities.php">
                            <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" class="form-control" name="edit_activity_id" value="<?php echo isset($_GET['edit_activity_id']) ? intval($_GET['edit_activity_id']) : ''; ?>">

                                <div class="form-group d-flex">
                                <select name="laboratories_id" class="p-2" id="laboratories_id" required>
                                    <option value="" disabled selected><?php echo t('Select cabinet heads'); ?></option>
                                    <?php foreach ($laboratories as $lab): ?>
                                        <option value="<?php echo $lab['id']; ?>" <?php echo ($isEditing && $activity['laboratories_id'] == $lab['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($lab['event_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" class="p-1 w-50" name="title" id="title" value="<?php echo $isEditing ? $activity['title'] : ''; ?>" placeholder="<?php echo t('Event Title'); ?>" required>
                                    <input type="number" class="p-1" name="time_limit" id="time_limit" value="<?php echo $isEditing ? $activity['time_limit'] : ''; ?>" placeholder="<?php echo t('Time Limit'); ?>" required>
                                    <input type="text" class="p-1" width="20%" name="target_audience" id="target_audience" value="<?php echo $isEditing ? $activity['target_audience'] : ''; ?>" placeholder="<?php echo t('Target Audience'); ?>" required>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group p-2" style="margin-bottom:-250px">
                            <select name="metodic_file_id" id="metodic_file_id" class="p-2 m-2"  style="left: 10px; max-height: 100px; overflow-y: auto; width: 200px;">
                                <option value=""><?php echo t('Select pdf, office File'); ?></option>
                                <?php foreach ($files as $file): ?>
                                    <?php
                                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                                    $allowedExtensions = ['doc', 'docx', 'xls', 'xlsx', 'pdf'];
                                    if (in_array($extension, $allowedExtensions)): ?>
                                        <option value="<?php echo $file['id']; ?>"
                                            <?php echo ($isEditing && $activity['metodic_file_id'] == $file['id']) ? 'selected' : ''; ?>>
                                            <?php echo $file['name']; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div id="metodicThumbnail-container">
                                <p id="metodicThumbnail" src="" alt="Selected" width="100px" style="margin-left: 8px;"></p>
                            </div>
                            <select name="image_id" id="image_id" class="p-2 m-2" style="left: 10px; max-height: 100px; overflow-y: auto; width: 200px;">
                                <option value=""><?php echo t('Select Image'); ?></option>
                                <?php foreach ($files as $file): ?>
                                    <option value="<?php echo $file['id']; ?>" data-img-src="<?php echo $file['url']; ?>"
                                        <?php echo ($isEditing && $activity['image_id'] == $file['id']) ? 'selected' : ''; ?>>
                                        <?php echo substr($file['name'], 0, 15); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="thumbnailEvent-container">
                                <img id="thumbnailEvent" src="" alt="Selected thumbnail" width="220px" style="margin-left: 8px;">
                            </div>
                                <button type="submit" class="p-3 m-3" name="submit"><?php echo t("Add/Edit activity");?></button>
                                <button type="submit" class="p-3 m-3" name="cancel"  id="cancelButton"><?php echo t("Cancel");?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group p-2"> 
                        <textarea name="short_description" id="short_description" rows="10" cols="100" placeholder="<?php echo t('Description'); ?>" required><?php echo $isEditing ? $activity['short_description'] : ''; ?></textarea>
                    </div>  
                </div>
                <div class="col-md-8 mb-3">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <?php echo t('Methodical Material'); ?></button></h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body" style="margin-left:-12px">
                                <textarea type="text" name="methodical_material" id="methodical_material" rows="10" cols="100" placeholder="<?php echo t('Methodical Material'); ?>"><?php echo $isEditing ? $activity['methodical_material'] : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div> 
        </div>
</div>
    <div class="col-md-12 mt-5">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><?php echo t("No.");?></th>
                    <th><?php echo t("Cabinet heads");?></th>
                    <th><?php echo t("Event Title");?></th>
                    <th><?php echo t("Description");?></th>
                    <th><?php echo t("Time limit");?></th>
                    <th><?php echo t("Target audience");?></th>
                    <th><?php echo t("Actions");?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;
                foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $i.". "; ?></td>
                    <td><?php echo htmlspecialchars($row['laboratory_name']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['title'], 0, 20));?></td>
                    <td><?php echo htmlspecialchars(substr($row['short_description'], 0, 24)); ?></td>
                    <td><?php echo htmlspecialchars($row['time_limit']); ?></td>
                    <td><?php echo htmlspecialchars($row['target_audience']); ?></td>
                    <td>
                        <?php 
                        echo '<a href="addons_model.php?name=event_callendar&id='. htmlspecialchars($_GET['id']).'&edit_activity_id='. htmlspecialchars($row['id']).'&tab=calendarItem&accordion=flush-collapseOne"><i class="fa fa-edit"></i></a>';

                      //  echo '<a href="addons_model.php?name=event_callendar&id='. htmlspecialchars($_GET['id']).'&edit_activity_id='. htmlspecialchars($row['id']).'"><i class="fa fa-edit"></i></a>';        
                        echo '<a href="#" onclick="confirmDelete3(\'../../cover/addons/event_callendar/action/delete_activity.php?event_calendar&id='.$id.'&activity_id='.htmlspecialchars($row['id']).'\')"><i class="fa fa-trash"></i></a>';
                        ?>
                    </td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>