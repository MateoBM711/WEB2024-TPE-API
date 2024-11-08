<?php
require_once './config.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST.
        ";dbname=".MYSQL_DB.
        ";charset=utf8",
        MYSQL_USER,MYSQL_PASS);
    }
 
    public function getUserByUsername($username) { 
           
        $query = $this->db->prepare("SELECT * FROM user WHERE username = ?");
        $query->execute([$username]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}