<?php
class Player
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function listPlayersPagination($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM players WHERE position_player != '' ORDER BY id_player DESC LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query:  ' . $this->conn->getError());
        }
        $stmt->bind_param('ii', $offset, $perPage);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when listing records with pagination: ' . $stmt->error);
        }
        $players = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $players;
    }

    public function filterPlayersByName($name)
    {
        if (empty($name)) {
            throw new Exception('Registration name was not provided.');
        }
        $sql = "SELECT * FROM players WHERE position_player != '' AND name_player LIKE ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query:  ' . $this->conn->getError());
        }
        $searchName = '%' . $name . '%';
        $stmt->bind_param('s', $searchName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when filtering records by name: ' . $stmt->error);
        }
        $players = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $players;
    }

    public function getTotalPlayers()
    {
        $result = $this->conn->select("SELECT count(*) as total FROM players WHERE position_player != ''");
        if ($result === false) {
            throw new Exception('Error counting records: ' . $this->conn->getError());
        }
        return intval($result[0]['total']);
    }

    public function save($data)
    {
        if (!isset($data['playerName'], $data['playerLevel'], $data['playerPosition'], $data['playerAge'])) {
            throw new Exception('Incomplete data to save records.');
        }
        $playerName = $data['playerName'];
        $playerLevel = $data['playerLevel'];
        $playerPosition = $data['playerPosition'];
        $playerAge = $data['playerAge'];
        $sql = "INSERT INTO players (name_player, level_player, created_at_player, position_player, age_player)
        VALUES (?, ?, NOW(), ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query:  ' . $this->conn->error);
        }
        $stmt->bind_param('sisi', $playerName, $playerLevel, $playerPosition, $playerAge);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error inserting record into database.');
        }
        $stmt->close();
        return true;
    }

    public function delete($id)
    {
        $sql = "UPDATE players SET name_player = 'Jogador Removido', level_player = 0, position_player = '', age_player = 0 WHERE id_player = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query:  ' . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error updating player record.');
        }
        $stmt->close();
        return true;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM players WHERE id_player = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query:  ' . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when searching for record by ID: ' . $stmt->error);
        }
        $player = $result->fetch_assoc();
        $stmt->close();
        return $player;
    }

    public function update($data)
    {    
        if (!isset($data['playerId'], $data['playerName'], $data['playerLevel'], $data['playerPosition'], $data['playerAge'])) {
            throw new Exception('Incomplete data to update the record.');
        }
        $playerId = $data['playerId'];
        $playerName = $data['playerName'];
        $playerLevel = $data['playerLevel'];
        $playerPosition = $data['playerPosition'];
        $playerAge = $data['playerAge'];
        $sql = "UPDATE players SET name_player = ?, level_player = ?, position_player = ?, age_player = ? WHERE id_player = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query:  ' . $this->conn->error);
        }
        $stmt->bind_param('sisii', $playerName, $playerLevel, $playerPosition, $playerAge, $playerId);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error updating record in the database.');
        }
        $stmt->close();
        return true;
    }
}
?>
