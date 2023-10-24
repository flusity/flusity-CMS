<?php

$settings = getSettings($db, $prefix);
$lang_code = $settings['language']; 
$current_lang = $_SESSION['lang'] ?? $lang_code;

$class = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? 'highlight-drag' : '';

$addonId = $addon['id'];
  $_SESSION['callendar_id'] = $addon['id'];
  
  function getCallendarSettingsFromDB($db, $prefix, $id = 1) {
    $sql = "SELECT * FROM ".$prefix['table_prefix']."_event_callendar WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return [
            'work_dayStart' => substr($row['work_dayStart'], 0, 5),
            'work_dayEnd' => substr($row['work_dayEnd'], 0, 5),
            'lunch_breakStart' => substr($row['lunch_breakStart'], 0, 5),
            'lunch_breakEnd' => substr($row['lunch_breakEnd'], 0, 5),
            'prepare_time' => $row['prepare_time'],
            'registration_end_date'=> $row['registration_end_date'],
        ];
    } else {
        return false;
    }
}


function getHolidaysFromDB($db, $prefix) {
    $sql = "SELECT * FROM ".$prefix['table_prefix']."_event_callendar_holidays";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $holidays = [];
    foreach($results as $row) {
        $month = str_pad($row['month'], 2, '0', STR_PAD_LEFT);  
        $holiday = str_pad($row['holiday'], 2, '0', STR_PAD_LEFT);  
        $date = "$month-$holiday";  

        $holidays[$date] = $row['holiday_name'];  
    }
    return $holidays;
}
$holidays = getHolidaysFromDB($db, $prefix);
$_SESSION['holidays'] = $holidays;


function reserveDateTimeAll($available, $db, $prefix, $laboratories_id, $event_item_id) {
    $sql = "SELECT reserve_date, reserve_event_time FROM ".$prefix['table_prefix']."_event_reservation_time WHERE event_laboratory_id = :event_laboratory_id AND event_item_id = :event_item_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':event_laboratory_id', $laboratories_id, PDO::PARAM_INT);
    $stmt->bindParam(':event_item_id', $event_item_id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reservedTimeSlots = [];
    foreach ($results as $row) {
        $reservedTimeSlots[] = $row['reserve_event_time'];
    }
    
    $availableTimeSlots = [];
    foreach ($available as $slot) {
        $availableTimeSlots[] = $slot['time'];
    }

    return array_diff($availableTimeSlots, $reservedTimeSlots);
}

function employmentLaboratories($db, $prefix, $reserveDay, $laboratoryId) {
    $sql = "SELECT COUNT(*) as activityCount 
            FROM " . $prefix['table_prefix'] . "_event_reservation_time 
            WHERE event_laboratory_id = :laboratoryId AND reserve_date = :reserveDay";
  
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':laboratoryId', $laboratoryId, PDO::PARAM_INT);
    $stmt->bindParam(':reserveDay', $reserveDay[0], PDO::PARAM_STR);
    $stmt->execute();
  
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['activityCount'];
}



function reserveDate($db, $prefix, $event_laboratory_id) {
    $sql = "SELECT reserve_date FROM ".$prefix['table_prefix']."_event_reservation_time WHERE event_laboratory_id = :event_laboratory_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':event_laboratory_id', $event_laboratory_id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reservedDateSlots = [];
    foreach ($results as $row) {
        $reservedDateSlots[] = $row['reserve_date'];
    }
    return $reservedDateSlots; 
}


    function getItemDetails($db, $prefix, $event_laboratory_id) {
        $sql = "SELECT id as event_item_id, time_limit
                FROM ".$prefix['table_prefix']."_event_callendar_item 
                WHERE laboratories_id = :event_laboratory_id";
    
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':event_laboratory_id', $event_laboratory_id, PDO::PARAM_INT);
    
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $getItemDetails = [];
        foreach ($results as $row) {
            $getItemDetails[$row['event_item_id']] = ['time_limit' => $row['time_limit']];
        }
        return $getItemDetails;
    }
    


    function fetchTimeLimitFromDatabase($db, $prefix, $event_laboratory_id, $event_item_id) {
        $sql = "SELECT a.reserve_event_time, b.time_limit
        FROM ".$prefix['table_prefix']."_event_reservation_time AS a
        JOIN ".$prefix['table_prefix']."_event_callendar_item AS b
        ON a.event_laboratory_id = b.laboratories_id AND a.event_item_id = b.id
        WHERE a.event_laboratory_id = :event_laboratory_id AND a.event_item_id = :event_item_id AND b.time_limit IS NOT NULL AND b.time_limit != ''
        AND a.reserve_event_time IS NOT NULL AND a.reserve_event_time != ''";
        
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':event_laboratory_id', $event_laboratory_id, PDO::PARAM_INT);
            $stmt->bindParam(':event_item_id', $event_item_id, PDO::PARAM_INT);

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $timeLimits = [];
            foreach ($results as $row) {
                $timeLimits[] = $row['time_limit'];
            }
            return $timeLimits;
    }
        

function timeToMinutes($time) {
    list($hours, $minutes) = explode(':', $time);
    return ($hours * 60) + $minutes;
}

function minutesToTime($minutes) {
    $hours = floor($minutes / 60);
    $minutes = $minutes % 60;
    return sprintf('%02d:%02d', $hours, $minutes);
}

function removeReservedSlots($availableSlots, $db, $prefix, $laboratories_id, $event_date, $time_limit, $event_item_id) {
    $callendarSettings = getCallendarSettingsFromDB($db, $prefix);
    $prepareTime = $callendarSettings['prepare_time'];

    $sql = "SELECT TIME_FORMAT(reserve_event_time, '%H:%i') as reserve_event_time, event_item_id 
            FROM ".$prefix['table_prefix']."_event_reservation_time 
            WHERE event_laboratory_id = :event_laboratory_id
            AND reserve_date = :event_date";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':event_laboratory_id', $laboratories_id, PDO::PARAM_INT);
    $stmt->bindParam(':event_date', $event_date[0], PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reservedIntervals = [];

    foreach ($results as $row) {
        $reservedMinutes = timeToMinutes($row['reserve_event_time']);
        $currentEventItemId = $row['event_item_id'];
        $itemSlotTimes = fetchTimeLimitFromDatabase($db, $prefix, $laboratories_id, $currentEventItemId);
        foreach ($itemSlotTimes as $itemSlotTime) {
            $resEndMinutes = $reservedMinutes + $itemSlotTime + $prepareTime;
            $reservedIntervals[] = [$reservedMinutes, $resEndMinutes];
        }
    }

    $remainingSlots = [];
    $remainingTimes = [];

    foreach ($availableSlots as $slot) {
        $isAvailable = true;
        $slotMinutes = timeToMinutes($slot['time']);
        $slotEndMinutes = $slotMinutes + $slot['duration'];
        
        foreach ($reservedIntervals as $interval) {
            list($resStart, $resEnd) = $interval;
            if ($slotMinutes < $resEnd && $slotEndMinutes > $resStart) {
                $isAvailable = false;
                break;
            }
        }
        
        if ($isAvailable) {
            $remainingSlots[] = $slot;
            $remainingTimes[] = $slot['time'];
        }
    }

    return $remainingTimes;
}


function getAvailableTimeSlots($timeLimit, $workDayStart, $workDayEnd, $lunchBreakStart, $lunchBreakEnd, $prepareTime) {
    $morningStart = new DateTime($workDayStart);
    $morningEnd = new DateTime($lunchBreakStart);
    
    $afternoonStart = new DateTime($lunchBreakEnd);
    $afternoonEnd = new DateTime($workDayEnd);
    
    $availableSlots = [];

    // Prieš pietus
    while ($morningStart < $morningEnd) {
        $potentialEnd = clone $morningStart;
        $potentialEnd->add(new DateInterval('PT' . $timeLimit . 'M'));
        
        if ($potentialEnd <= $morningEnd) {
            $availableSlots[] = [
                'time' => $morningStart->format('H:i'),
                'duration' => $timeLimit + $prepareTime
            ];
        }

        $morningStart->add(new DateInterval('PT' . ($timeLimit + $prepareTime) . 'M'));
    }
    // Po pietų
    while ($afternoonStart < $afternoonEnd) {
        $potentialEnd = clone $afternoonStart;
        $potentialEnd->add(new DateInterval('PT' . $timeLimit . 'M'));
        
        if ($potentialEnd <= $afternoonEnd) {
            $availableSlots[] = [
                'time' => $afternoonStart->format('H:i'),
                'duration' => $timeLimit + $prepareTime
            ];
        }

        $afternoonStart->add(new DateInterval('PT' . ($timeLimit + $prepareTime) . 'M'));
    }
    return $availableSlots;
}




function getTopicsFromDB($db, $prefix) {
  
    $callendarSettings = getCallendarSettingsFromDB($db, $prefix); 

    $workDayStart = $callendarSettings['work_dayStart'];
    $workDayEnd = $callendarSettings['work_dayEnd'];
    $lunchBreakStart = $callendarSettings['lunch_breakStart'];
    $lunchBreakEnd = $callendarSettings['lunch_breakEnd'];
    $prepareTime = $callendarSettings['prepare_time'];
    $setRegistrationEndDate = $callendarSettings['registration_end_date'];
   
    $sql = "SELECT t.*, f.url as image_url 
    FROM ".$prefix['table_prefix']."_event_callendar_item t
    LEFT JOIN ".$prefix['table_prefix']."_flussi_files f ON t.image_id = f.id
    INNER JOIN ".$prefix['table_prefix']."_event_callendar_laboratories l ON l.id = t.laboratories_id
    WHERE l.id = t.laboratories_id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 


    $topics = [];
    
    foreach($results as $row) {  
        $reserveDay = reserveDate($db, $prefix, $row['laboratories_id']);
        $availableSlots = getAvailableTimeSlots($row['time_limit'], $workDayStart, $workDayEnd, $lunchBreakStart, $lunchBreakEnd, $prepareTime);  
        $provideEventDay = removeReservedSlots($availableSlots, $db, $prefix, $row['laboratories_id'], $reserveDay, $row['time_limit'], $row['id']);
        $reserveEventDay = reserveDateTimeAll( $availableSlots, $db, $prefix, $row['laboratories_id'], $row['id']);
        $employment = employmentLaboratories($db, $prefix, $reserveDay, $row['laboratories_id'], $row['id']);
      
       // var_dump($employment);

        $topics[] = [
            'id' => $row['id'],
            'theme_id' => $row['laboratories_id'],
            'title' => $row['title'],
            'shortDescription' => $row['short_description'],
            'targetAudience' => $row['target_audience'],    //tikslinė auditorija
            'methodicalMaterial' => $row['methodical_material'],    
            'timeLimit' => $row['time_limit'],
            'metodicFileId' => $row['metodic_file_id'],
            'imageUrl' => $row['image_url'],
            'provideTime' => $provideEventDay,
            'reserveEventDay' => $reserveEventDay,
            'reserveDay' => $reserveDay,
            'employmentLaboratories' => $employment,
            'setRegistrationEndDate' => $setRegistrationEndDate
        ];
    }
    
    return $topics;
}


$topics = getTopicsFromDB($db, $prefix);
$_SESSION['topics'] = $topics;


function getEventWithLaboratories($db, $prefix, $addonId) {
    $id = $addonId;
    $sql = "SELECT a.*, b.* FROM ". $prefix['table_prefix'] ."_event_callendar a
            LEFT JOIN ". $prefix['table_prefix'] ."_event_callendar_laboratories b ON a.id = b.callendar_id
            WHERE a.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 $eventData = getEventWithLaboratories($db, $prefix, $addonId);
  $_SESSION['events'] = $eventData;

 echo '<div ';
 if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {;
 echo  'class="' . $class . '">';} else { echo '>';}

if (isset($admin_label)) {
    echo '<h3>' . htmlspecialchars($admin_label) . '</h3>';
}?>

<div id="calendar-container" class="content event-callendar">
<?php 
 require_once 'callendar.php';
echo '</div>
</div>'; 
displayAddonEditButton($db, $prefix, $addon, 'event_callendar');
echo '</div>';
?>
<script>
    updateCalendar(<?php echo date("m"); ?>, <?php echo date("Y"); ?>);
    const eventTopics = <?php echo json_encode($topics); ?>;
</script>