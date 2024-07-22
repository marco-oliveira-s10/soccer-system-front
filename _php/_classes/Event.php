<?php

class Event
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function createEvent($name_event, $id_location, $date_event)
    {
        $sql = "INSERT INTO events (name_event, id_location, date_event) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);        
        if ($stmt === false) {
            throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('sis', $name_event, $id_location, $date_event);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error inserting record into database.');
        }
        $event_id = $stmt->insert_id;
        $stmt->close();
        return $event_id;
    }

    public function createTeam($id_event, $name_team, $level_team)
    {
        $sql = "INSERT INTO teams (id_event, name_team, level_team) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('isi', $id_event, $name_team, $level_team);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error inserting record into database.');
        }
        $event_id = $stmt->insert_id;
        $stmt->close();
        return $event_id;
    }

    public function addPlayerToTeam($id_team, $id_player)
    {
        $sql = "INSERT INTO players_teams (id_team, id_player) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('ii', $id_team, $id_player);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error inserting record into database.');
        }
        $stmt->close();
        return true;
    }

    public function listEventPagination($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM events e ORDER BY e.id_event DESC LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing a SQL query: ' . $this->conn->getError());
        }
        $stmt->bind_param('ii', $offset, $perPage);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when listing records with pagination: ' . $stmt->error);
        }
        $events = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $events;
    }

    public function filterEventsByName($name)
    {
        if (empty($name)) {
            throw new Exception('The registry name was not provided.');
        }
        $sql = "SELECT * FROM events e WHERE e.name_event LIKE ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing a SQL query: ' . $this->conn->getError());
        }
        $searchName = '%' . $name . '%';
        $stmt->bind_param('s', $searchName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when filtering record by name: ' . $stmt->error);
        }
        $events = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $events;
    }

    public function getTotalEvents()
    {
        $result = $this->conn->select("SELECT count(*) as total FROM events");
        if ($result === false) {
            throw new Exception('Error count log: ' . $this->conn->getError());
        }
        return intval($result[0]['total']);
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM players_teams WHERE id_team IN (SELECT id_team FROM teams WHERE id_event = ?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
            }
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $sql = "DELETE FROM teams WHERE id_event = ?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
            }
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();

            $sql = "DELETE FROM events WHERE id_event = ?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
            }
            $stmt->bind_param('i', $id);
            $stmt->execute();
            if ($stmt->affected_rows <= 0) {
                throw new Exception('Error deleting record in the database.');
            }
            $stmt->close();       
            return true;
        } catch (Exception $e) {   
            throw $e;
        }
    }
    public function findById($id)
    {
        $sql = "
        SELECT 
        e.id_event,
        e.name_event,
        e.date_event,
        t.id_team,
        t.name_team,
        t.level_team,
        pt.id_player_team,
        p.id_player,
        p.name_player,
        p.level_player,
        l.name_location
        FROM 
        events e
        JOIN 
        teams t ON e.id_event = t.id_event
        JOIN 
        players_teams pt ON t.id_team = pt.id_team
        JOIN 
        players p ON pt.id_player = p.id_player
        JOIN 
        locations l ON e.id_location = l.id_location
        WHERE 
        e.id_event = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing a SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when searching record by ID: ' . $stmt->error);
        }
        $event = [
            'id_event' => null,
            'name_event' => null,
            'date_event' => null,
            'name_location' => null,
            'teams' => []
        ];
        $teams = [];
        while ($row = $result->fetch_assoc()) {
            if (!$event['id_event']) {
                $event['id_event'] = $row['id_event'];
                $event['name_event'] = $row['name_event'];
                $event['date_event'] = $row['date_event'];
                $event['name_location'] = $row['name_location'];
            }
            $id_team = $row['id_team'];
            if (!isset($teams[$id_team])) {
                $teams[$id_team] = [
                    'id_team' => $id_team,
                    'name_team' => $row['name_team'],
                    'level_team' => $row['level_team'],
                    'players' => []
                ];
            }
            $player = [
                'id_player_team' => $row['id_player_team'],
                'id_player' => $row['id_player'],
                'name_player' => $row['name_player'],
                'level_player' => $row['level_player']
            ];
            $teams[$id_team]['players'][] = $player;
        }
        $event['teams'] = array_values($teams);
        $stmt->close();
        return $event;
    }
}