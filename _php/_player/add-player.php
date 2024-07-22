<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Método não permitido. Permitido apenas método POST.');
}
require_once('../autoload.php');
if (!isset($_POST['playerName'], $_POST['playerLevel'], $_POST['playerPosition'], $_POST['playerAge'])) {
    header('HTTP/1.1 400 Bad Request');
    exit('Dados incompletos para salvar.');
}
$player = new Player();
try {
    $result = $player->save($_POST);
    if ($result === true) {
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Cadastrado com sucesso.'));
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Erro ao cadastrar.';
    }
} catch (Exception $e) {    
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Erro: ' . $e->getMessage();
}