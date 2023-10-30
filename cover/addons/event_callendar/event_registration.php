<?php
    $sql = "SELECT rewxcas_event_reservation_time.*, lab.event_name AS laboratory_name, item.title AS event_title, mem.member_first_name, mem.member_last_name
    FROM rewxcas_event_reservation_time
    LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_laboratories AS lab ON rewxcas_event_reservation_time.event_laboratory_id = lab.id
    LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_item AS item ON rewxcas_event_reservation_time.event_item_id = item.id
    LEFT JOIN " . $prefix['table_prefix'] . "_callendar_users_member AS mem ON rewxcas_event_reservation_time.event_users_member_id = mem.id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lentelė</title>
</head>
<body>
<table class="table table-sm">
        <thead>
            <tr>
                <th><?php echo t("No.");?></th>
                <th><?php echo t("Cabinet heads");?></th>
                <th><?php echo t("Event Title");?></th>
                <th><?php echo t("Audience");?></th>
                <th><?php echo t("Member User");?></th>
                <th><?php echo t("Reservation time");?></th>
                <th><?php echo t("Date");?></th>
                <th><?php echo t("Additional information");?></th>
                <th><?php echo t("Actions");?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
             foreach ($results as $row): ?>
                 <tr><!--$row['id'] -->
                    <td><?php echo $i.". "; ?></td>
                    <td><?php echo htmlspecialchars($row['laboratory_name']); ?></td> 
                    <td><?php echo htmlspecialchars($row['event_title']); ?></td> 
                    <td><?php echo htmlspecialchars($row['event_target_audience']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_first_name'] . ' ' . $row['member_last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['reserve_event_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['reserve_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['reservation_description']); ?></td>
                    <td>
                        <a href="addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($id); ?>&edit_reservation_id=<?php echo htmlspecialchars($row['id']); ?>"><i class="fa fa-edit"></i></a> |
                        <a href="#" onclick="confirmDelete4('../../cover/addons/event_callendar/action/delete_reservation.php?event_calendar&id=<?php echo htmlspecialchars($id); ?>&edit_reservation_id=<?php echo htmlspecialchars($row['id']) ?>')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php 
            $i++; 
            endforeach; ?>
        </tbody>
    </table>