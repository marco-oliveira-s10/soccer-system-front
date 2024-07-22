<?php
function embaralharJogadores($jogadores) {
    shuffle($jogadores);
    return $jogadores;
}
function distribuirJogadoresEmTimes($jogadores, $numeroPorTime, &$goleiros) {
    $times = [];
    $reservas = []; 
    $jogadores = embaralharJogadores($jogadores); 
    $goleiros = embaralharJogadores($goleiros);
    if (empty($jogadores) && empty($goleiros)) {
        echo "Não há jogadores para distribuir.";
        return [[], []];
    }
    while (count($jogadores) >= $numeroPorTime || !empty($goleiros)) {
        $timeAtual = [];
        if (empty(array_filter($timeAtual, function($jogador) {
            return $jogador['position_player'] == 'GOL';
        }))) {
            if (!empty($goleiros)) {
                $timeAtual[] = array_shift($goleiros);
            } else {
                if (!empty($jogadores)) {
                    $reservas[] = [
                        'time' => 'Reserva',
                        'pontos' => array_reduce($jogadores, function($sum, $jogador) {
                            return $sum + $jogador['level_player'];
                        }, 0),
                        'jogadores' => $jogadores
                    ];
                    $jogadores = [];
                }
                break;
            }
        }
        while (count($timeAtual) < $numeroPorTime && !empty($jogadores)) {
            $timeAtual[] = array_shift($jogadores);
        }
        $temGoleiro = array_filter($timeAtual, function($jogador) {
            return $jogador['position_player'] == 'GOL';
        });
        if (count($timeAtual) == $numeroPorTime && $temGoleiro) { 
            $pontos = array_reduce($timeAtual, function($sum, $jogador) {
                return $sum + $jogador['level_player'];
            }, 0);
            $times[] = [
                'time' => count($times) + 1,
                'pontos' => $pontos,
                'jogadores' => $timeAtual,
            ];
        } else {
            $reservas[] = [
                'time' => 'Reserva',
                'pontos' => array_reduce($timeAtual, function($sum, $jogador) {
                    return $sum + $jogador['level_player'];
                }, 0),
                'jogadores' => $timeAtual,
            ];
        }
    }
    if (!empty($jogadores)) {
        $reservas[] = [
            'time' => 'Reserva',
            'pontos' => array_reduce($jogadores, function($sum, $jogador) {
                return $sum + $jogador['level_player'];
            }, 0),
            'jogadores' => $jogadores,
        ];
    }
    if (!empty($goleiros)) {
        $reservas[] = [
            'time' => 'Reserva',
            'pontos' => array_reduce($goleiros, function($sum, $jogador) {
                return $sum + $jogador['level_player'];
            }, 0),
            'jogadores' => $goleiros,
        ];
    }
    return [$times, $reservas];
}
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['confirmados']) || !isset($data['numeroplayersPorTime'])) {
    echo "Dados inválidos.";
    exit;
}
$confirmados = $data['confirmados'];
$numeroPlayersPorTime = $data['numeroplayersPorTime'];
$goleiros = [];
$outrosJogadores = [];
foreach ($confirmados as $jogador) {
    if ($jogador['position_player'] == 'GOL') {
        $goleiros[] = $jogador;
    } else {
        $outrosJogadores[] = $jogador;
    }
}
list($timesPrincipais, $reservas) = distribuirJogadoresEmTimes($outrosJogadores, $numeroPlayersPorTime, $goleiros);
$response = [
    'principais' => $timesPrincipais,
    'reservas' => $reservas
];
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>