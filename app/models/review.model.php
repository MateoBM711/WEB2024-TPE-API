<?php

class ReviewModel{
    private $db;
    
    
    public function __construct()
    {
        $this->db = new PDO("mysql:host=".MYSQL_HOST.
        ";dbname=".MYSQL_DB.
        ";charset=utf8",
        MYSQL_USER,MYSQL_PASS);   
    }

    public function getReviewsByMovie($id){
        $query = $this->db->prepare('SELECT * FROM review WHERE id_movie = ?');
        $query->execute([$id]);
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);

        return $reviews;
    }
    public function getCommentsByMovie($id){
        $query = $this->db->prepare('SELECT comment FROM review WHERE id_movie = ?');
        $query->execute([$id]);
        $comments = $query->fetchAll(PDO::FETCH_OBJ);

        return $comments;
    }

}