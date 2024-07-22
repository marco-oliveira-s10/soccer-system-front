<?php
require_once('../autoload.php');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 10;
$player = new Player();
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $players = $player->filterPlayersByName($name);
    $totalPlayers = count($players);
    $totalPages = ceil($totalPlayers / $pageSize);
    $offset = ($page - 1) * $pageSize;
    $pagedPlayers = array_slice($players, $offset, $pageSize);
    $response = array(
        'players' => $pagedPlayers,
        'totalPages' => $totalPages
    );
} else {
    $players = $player->listPlayersPagination($page, $pageSize);
    $totalPlayers = $player->getTotalPlayers();
    $totalPages = ceil($totalPlayers / $pageSize);
    $response = array(
        'players' => $players,
        'totalPages' => $totalPages
    );
}
echo json_encode($response);
?>
