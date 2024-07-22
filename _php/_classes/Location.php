<?php
class Location
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function listLocationPagination($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM locations WHERE name_location != 'Local removido' ORDER BY name_location ASC LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->getError());
        }
        $stmt->bind_param('ii', $offset, $perPage);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when listing records with pagination: ' . $stmt->error);
        }
        $locations = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $locations;
    }

    public function filterLocationsByName($name)
    {
        if (empty($name)) {
            throw new Exception('Registration name was not provided.');
        }
        $sql = "SELECT * FROM locations WHERE name_location != 'Local removido' AND name_location LIKE ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->getError());
        }
        $searchName = '%' . $name . '%';
        $stmt->bind_param('s', $searchName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when filtering records by name: ' . $stmt->error);
        }
        $locations = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $locations;
    }

    public function getTotalLocations()
    {
        $result = $this->conn->select("SELECT count(*) as total FROM locations WHERE name_location != 'Local removido'");
        if ($result === false) {
            throw new Exception('Error counting records: ' . $this->conn->getError());
        }
        return intval($result[0]['total']);
    }

    public function save($data)
    {
        if (!isset($data['locationName'], $data['locationLocationName'])) {
            throw new Exception('Incomplete data to save record.');
        }
        $locationName = $data['locationName'];
        $locationLocationName  = $data['locationLocationName'];
        $sql = "INSERT INTO locations (
            name_location,
            location_location,
            created_at_location
            )
        VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('ss', $locationName, $locationLocationName);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error inserting records into the database.');
        }
        $stmt->close();
        return true;
    }  

    public function delete($id)
    {    
        $sqlCheckLocation = "SELECT 1 FROM locations WHERE id_location = ?";
        $stmtCheckLocation = $this->conn->prepare($sqlCheckLocation);
        if ($stmtCheckLocation === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->error);
        }
        $stmtCheckLocation->bind_param('i', $id);
        $stmtCheckLocation->execute();
        if ($stmtCheckLocation->get_result()->num_rows === 0) {
            throw new Exception('Location ID does not exist.');
        }
        $stmtCheckLocation->close();
        $sqlUpdate = "UPDATE locations SET name_location = 'Local removido' WHERE id_location = ?";
        $stmt = $this->conn->prepare($sqlUpdate);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error updating location name.');
        }
        $stmt->close();

        return true;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM locations WHERE id_location = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception('Error when searching for records by ID: ' . $stmt->error);
        }
        $location = $result->fetch_assoc();
        $stmt->close();
        return $location;
    }

    public function update($data)
    {
        if (!isset($data['locationId'], $data['locationName'], $data['locationLocationName'])) {
            throw new Exception('Incomplete data to save record.');
        }
        $locationId = $data['locationId'];
        $locationName = $data['locationName'];
        $locationLocationName = $data['locationLocationName'];
        $sql = "UPDATE locations SET name_location = ?, location_location = ? WHERE id_location = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error preparing SQL query: ' . $this->conn->error);
        }
        $stmt->bind_param('ssi', $locationName, $locationLocationName, $locationId);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) {
            throw new Exception('Error updating record in the database.');
        }
        $stmt->close();
        return true;
    }
}
?>
