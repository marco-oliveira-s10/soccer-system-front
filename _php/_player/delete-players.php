<?php
require_once('../autoload.php');
header('Content-Type: application/json');
$response = array('success' => false);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ids']) && is_array($_POST['ids'])) {
        $playerIds = $_POST['ids'];
        $player = new Player();
        foreach ($playerIds as $id) {
            if (is_numeric($id)) {
                $player->delete($id);
            }
        }
        $response['success'] = true;
    }
}
echo json_encode($response);
?>
