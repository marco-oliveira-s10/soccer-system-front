<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../autoload.php');    
    $player = new Player();
    $success = $player->update($_POST);
    if ($success) {
        http_response_code(200);
        echo json_encode(array('message' => 'Atualizado com sucesso.'));
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Erro ao atualizar.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Requisição inválida.'));
}