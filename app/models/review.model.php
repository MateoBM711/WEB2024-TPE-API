<?php

class ReviewModel
{
    private $db;


    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST .
                ";dbname=" . MYSQL_DB .
                ";charset=utf8",
            MYSQL_USER,
            MYSQL_PASS
        );
    }
    public function getReviews($parametros)
    {
        $sql = 'SELECT * FROM review';
        if (isset($parametros['order'])) {
            $sql .= ' ORDER BY ' . $parametros['order'];
            if (isset($parametros['sort'])) {
                $sql .= ' ' . $parametros['sort'];
            }
        }
        $limit = isset($parametros['limit']) ? (int)$parametros['limit'] : 10;
        $offset = isset($parametros['offset']) ? (int)$parametros['offset'] : 0;

        $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        $query = $this->db->prepare($sql);
        $query->execute();
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);
        return $reviews;
    }
    public function getReviewById($id)
    {
        $query = $this->db->prepare('SELECT * FROM review WHERE id = ?');
        $query->execute([$id]);
        $review = $query->fetch(PDO::FETCH_OBJ);
        return $review;
    }
    public function getCommentsByMovie($id)
    {
        $query = $this->db->prepare('SELECT comment FROM review WHERE id_movie = ?');
        $query->execute([$id]);
        $comments = $query->fetchAll(PDO::FETCH_OBJ);

        return $comments;
    }
    public function insertReview($idMovie, $comment)
    {
        $query = $this->db->prepare('INSERT INTO review(id_movie, comment) VALUES (?, ?)');
        $query->execute([$idMovie, $comment]);
    }
    public function removeReview($id)
    {
        $query = $this->db->prepare('DELETE FROM review WHERE id = ?');
        $query->execute([$id]);
    }
    public function updateReview($idMovie, $comment, $id)
    {
        $query = $this->db->prepare('UPDATE review SET id_movie = ?, comment = ? WHERE id = ?');
        $query->execute([$idMovie, $comment, $id]);
    }
}
