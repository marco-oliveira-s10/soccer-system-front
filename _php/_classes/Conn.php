<?php

class Conn
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->servername = getenv('DB_SERVERNAME') ?: '127.0.0.1';
        $this->username = getenv('DB_USERNAME') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: '';
        $this->dbname = getenv('DB_NAME') ?: 'soccer_system';
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function prepare($sql)
    {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . $this->conn->error);
        }
        return $stmt;
    }
    
    public function query($sql)
    {
        $result = $this->conn->query($sql);
        if ($result === false) {
            throw new Exception("Error executing query: " . $this->conn->error);
        }
        return $result;
    }

    public function select($sql)
    {
        $result = $this->conn->query($sql);
        if ($result === false) {
            throw new Exception("Error executing query: " . $this->conn->error);
        }
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}
?>