<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eventId'])) {
    require_once('../autoload.php');
    $eventId = $_GET['eventId'];
    $event = new Event();
    $eventData = $event->findById($eventId);
    if ($eventData) {
        http_response_code(200);
        echo json_encode($eventData);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Registro não encontrado.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Requisição inválida.'));
}
