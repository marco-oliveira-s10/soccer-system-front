<?php
session_start();
require_once("autoload.php");
class Login
{
    private $conn;
    private $data;

    public function __construct()
    {
        $this->conn = new Conn();
    }
    
    public function checkLogin($data)
    {
        $data['password'] = md5($data['password']);
        try {
            $sql = "SELECT * FROM users WHERE login_user = ? AND password_hash_user = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparing SQL query: ' . $this->conn->getError());
            }
            $stmt->bind_param('ss', $data['login'], $data['password']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result === false) {
                throw new Exception('Error processing data: ' . $stmt->error);
            }
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();                
                $_SESSION['nameUser'] = $user['name_user'];                
                $this->data = ['login' => true];
                $_SESSION['login'] = true;
            } else {
                $this->data = ['login' => false];
                $_SESSION['login'] = false;
            }
            $stmt->close();
        } catch (PDOException $e) {    
            echo 'Error processing data: ' . $e->getMessage();
        }
    }
    
    public function getData()
    {
        return $this->data;
    }
}

$exec = new Login();
$exec->checkLogin($_POST);
echo json_encode($exec->getData());
?>
