<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("HTTP/1.1 405 Method Not Allowed");
    exit("Método não permitido. Permitido apenas método POST.");
}
require_once "../autoload.php";
$data = json_decode(file_get_contents("php://input"), true);
array_push(
    $data["timesSorteados"]["principais"],
    $data["timesSorteados"]["reservas"][0]
);
$data["timesSorteados"] = $data["timesSorteados"]["principais"];
try {
    $event = new Event();
    $nomeEvento = $data["nomeEvento"];
    $localEvento = (int) $data["localEvento"];
    $dataEvento = $data["dataEvento"];
    $event_id = $event->createEvent($nomeEvento, $localEvento, $dataEvento);
    $conversion = [];
    foreach ($data["timesSorteados"] as $time) {
        $arr = [
            "name_team" => "Time " . $time["time"],
            "level_team" => $time["pontos"],
            "players" => [],
        ];
        foreach ($time["jogadores"] as $key => $jogadores) {
            array_push($arr["players"], $jogadores["id_player"]);
        }
        array_push($conversion, $arr);
        unset($arr);
    }
    $timesSorteados = $conversion;
    try {
        foreach ($timesSorteados as $team) {
            $team_id = $event->createTeam(
                $event_id,
                $team["name_team"],
                $team["level_team"]
            );
            foreach ($team["players"] as $playerId) {
                $event->addPlayerToTeam($team_id, $playerId);
            }
        }
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode([
            "error" => "Ocorreu um erro.",
            "message" => $e->getMessage(),
        ]);
    }
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "Erro: " . $e->getMessage();
}
?>