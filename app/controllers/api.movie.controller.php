<?php
require_once 'app/models/movie.model.php';
require_once 'app/models/review.model.php';
require_once 'app/views/api.view.php';

class ApiMovieController
{
    private $model;
    private $reviewModel;
    private $view;
    private $data;
    function __construct()
    {
        $this->model = new MovieModel;
        $this->reviewModel = new ReviewModel;
        $this->view = new APIView;
        $this->data = file_get_contents("php://input");
    }
    function getData(){
        return json_decode($this->data);
    }
    public function getAll($params = null)
    {
        $movies = $this->model->getMovies();
        $this->view->response($movies, 200);
    }
    public function get($params = null)
    {
        $idMovie = $params[':ID'];
        $movie = $this->model->getMovieById($idMovie);
        if ($movie) {
            $movie->comments = $this->reviewModel->getCommentsByMovie($idMovie);
            $this->view->response($movie, 200);
        } else {
            $this->view->response("La pelicula con el id=" . $idMovie . " no existe", 404);
        }
    }
    public function delete($params = null)
    {
        $idMovie = $params[':ID'];
        $movie = $this->model->getMovieById($idMovie);
        if($movie){
        $this->model->removeMovie($idMovie);
        $this->view->response("La pelicula con el id=".$idMovie." se elimino con exito", 200);
        }else{
            $this->view->response("La pelicula con el id=".$idMovie."no existe", 404);
        }
    }
    public function add($params = null){
        $body = $this->getData();
    }
}
