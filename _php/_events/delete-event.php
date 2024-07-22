<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array('message' => 'Método não permitido.'));
    exit;
}
if (!isset($_POST['eventId'])) {
    http_response_code(400);
    echo json_encode(array('message' => 'ID não foi fornecido.'));
    exit;
}
require_once('../autoload.php');
$event = new Event();
$eventId = $_POST['eventId'];
if ($event->delete($eventId)) {
    http_response_code(200);
    echo json_encode(array('message' => 'Deletado com sucesso.'));
} else {
    http_response_code(500);
    echo json_encode(array('message' => 'Erro ao excluir.'));
}
