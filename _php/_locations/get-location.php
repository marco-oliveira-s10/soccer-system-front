<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['locationId'])) {
    require_once('../autoload.php');
    $locationId = $_GET['locationId'];
    $location = new Location();
    $locationData = $location->findById($locationId);
    if ($locationData) {
        http_response_code(200);
        echo json_encode($locationData);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Registro não encontrado.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Requisição inválida.'));
}