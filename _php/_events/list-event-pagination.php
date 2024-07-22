<?php
require_once('../autoload.php');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 10;
$event = new Event();
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $events = $event->filterEventsByName($name);
    $totalEvents = count($events);
    $totalPages = ceil($totalEvents / $pageSize);
    $offset = ($page - 1) * $pageSize;
    $pagedEvents = array_slice($events, $offset, $pageSize);
    $response = array(
        'events' => $pagedEvents,
        'totalPages' => $totalPages
    );
} else {
    $events = $event->listEventPagination($page, $pageSize);
    $totalEvents = $event->getTotalEvents();
    $totalPages = ceil($totalEvents / $pageSize);
    $response = array(
        'events' => $events,
        'totalPages' => $totalPages
    );
}
echo json_encode($response);
?>
