<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['playerId'])) {
    require_once('../autoload.php');
    $playerId = $_GET['playerId'];
    $player = new Player();
    $playerData = $player->findById($playerId);
    if ($playerData) {
        http_response_code(200);
        echo json_encode($playerData);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Registro não encontrado.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Requisição inválida.'));
}