<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'class_callendar/class_callendar.php';

date_default_timezone_set('Europe/Vilnius');

$year = isset($_GET['year']) ? $_GET['year'] : date("Y");
$month = isset($_GET['month']) ? $_GET['month'] : date("m");
$day = isset($_GET['day']) ? $_GET['day'] : date("d");
$calendar = new Calendar("$year-$month-$day");
//$calendar = new Calendar("$year-$month-$day", $dayOccupancy);

if (isset($_SESSION['holidays'])) {
    $holidays = $_SESSION['holidays'];
    $calendar->add_holidays($holidays);
}
if (isset($_SESSION['topics'])) {
    $topics = $_SESSION['topics'];
}

if (isset($_SESSION['events'])) {
    foreach ($_SESSION['events'] as $event) {
        $calendar->add_event(
            $event['id'],
            $event['event_name'],
            $event['when_event_will_start'],
            $event['event_days'],
            $event['event_color']
        );
    }
}

?>
<?=$calendar?>