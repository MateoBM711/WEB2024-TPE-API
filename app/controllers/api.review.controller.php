<?php
require_once 'app/models/movie.model.php';
require_once 'app/models/review.model.php';
require_once 'app/views/api.view.php';

class ApiReviewController{
    private $model;
    private $movieModel;
    private $view;
    private $data;

    function __construct(){
        $this->model = new ReviewModel;
        $this->movieModel = new MovieModel;
        $this->view = new APIView;
        $this->data = file_get_contents("php://input"); 
    }
    function getData(){
        return json_decode($this->data);
    }
    public function add($params = null){
        $idMovie = $params[':ID'];
        $body = $this->getData();
        $comment = $body->comment;
        $this->model->insertReview($idMovie, $comment);
        $reviews = $this->model->getReviews($params);
        return $this->view->response($reviews, 200);
    }
    public function getAll($params = null){
        $parametros = [];
        if(isset($_GET['sort'])){
            $parametros['sort'] = $_GET['sort'];
        }
        if(isset($_GET['order'])){
            $parametros['order'] = $_GET['order'];
        }
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPorPagina = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $offset = ($paginaActual - 1) * $itemsPorPagina;
        $parametros['limit'] = $itemsPorPagina;
        $parametros['offset'] = $offset;
        $reviews = $this->model->getReviews($parametros);
        $this->view->response($reviews, 200);
    }
    public function delete($params = null){
        $idReview = $params[':ID'];
        $review = $this->model->getReviewById($idReview);
        if($review){
            $this->model->removeReview($idReview);
            $this->view->response("El comentario con el id=".$idReview." se elimino correctamente", 200);
        } else{
            $this->view->response("El comentario con el id=".$idReview." no existe", 404);
        }
    }
    public function update($params = null){
        $idReview = $params[':ID'];
        $review = $this->model->getReviewById($idReview);
        if($review){
            $body = $this->getData();
            $idMovie = $body->id_movie;
            $comment = $body->comment;
            $this->model->updateReview($idMovie, $comment, $idReview);
            $review = $this->model->getReviewById($idReview);
            $this->view->response($review, 200);
        } else{
            $this->view->response("El comentario con el id=".$idReview." no existe", 404);
        }
    }
}