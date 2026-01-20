<?php
class User{
    protected $conn;
    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }
    public function create($name, $username, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, username, email, password)
            VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $username, $email, $hashedPassword);

        if($stmt->execute()){
            $_SESSION["user_id"] = $this->conn->insert_id;
            return true;
        }
        return false;
    }

    public function login($username, $password){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sql = "SELECT user_id, password FROM users WHERE username = ?"; #bind param go zamenuva ?
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows === 1){
            $row = $result->fetch_assoc();
            #so ovaj if proveruvam dali pw mi se poklopuva so hashedPW
            if(password_verify($password, $row['password'])){
                $_SESSION["user_id"] = $row['user_id'];
                return true;
            }
        }
        return false;
    }
    public function isLoggedIn(){
        if(isset($_SESSION["user_id"])){
            return true;
        }
        return false;
    }
    public function isAdmin(){
        $query = "SELECT * FROM users WHERE user_id = ? AND isAdmin = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows >0){
            return true;
        }
        return false;
    }
    public function logout(){
        unset($_SESSION["user_id"]);
    }

}
