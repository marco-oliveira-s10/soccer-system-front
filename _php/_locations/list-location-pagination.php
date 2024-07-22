<?php
require_once('../autoload.php');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 10;
$location = new Location();
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $locations = $location->filterLocationsByName($name);
    $totalLocations = count($locations);
    $totalPages = ceil($totalLocations / $pageSize);
    $offset = ($page - 1) * $pageSize;
    $pagedLocations = array_slice($locations, $offset, $pageSize);
    $response = array(
        'locations' => $pagedLocations,
        'totalPages' => $totalPages
    );
} else {
    $locations = $location->listLocationPagination($page, $pageSize);
    $totalLocations = $location->getTotalLocations();
    $totalPages = ceil($totalLocations / $pageSize);
    $response = array(
        'locations' => $locations,
        'totalPages' => $totalPages
    );
}
echo json_encode($response);
?>
