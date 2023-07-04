<?php

function getContactFormSettings($db, $prefix) {
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_contact_form_settings");
    $stmt->execute();
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    return $settings;
}


