<?php
    $sql = "SELECT * FROM " . $prefix['table_prefix'] . "_callendar_users_member";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
 <table class="table table-sm">
        <thead>
            <tr>
                <th><?php echo t("No.");?></th>
                <th><?php echo t("Login Name");?></th>
                <th><?php echo t("Member User");?></th>
                <th><?php echo t("Telephone");?></th>
                <th><?php echo t("Email");?></th>
                <th><?php echo t("Institution");?></th>
                <th><?php echo t("Position");?></th>
                <th><?php echo t("Actions");?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
            foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $i.". "; ?></td>
                    <td><?php echo htmlspecialchars($row['member_login_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_first_name'] . ' ' . $row['member_last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_telephone']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_institution']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_employee_position']); ?></td>
                    <td>
                        <a href="addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($id); ?>&edit_member_id=<?php echo htmlspecialchars($row['id']); ?>"><i class="fa fa-edit"></i></a> |
                        <a href="#" onclick="confirmDelete5('../../cover/addons/members/action/delete_member.php?id=<?php echo htmlspecialchars($row['id']); ?>')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php 
            $i++; 
            endforeach; ?>
        </tbody>
    </table>