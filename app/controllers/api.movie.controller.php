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
    function getData()
    {
        return json_decode($this->data);
    }
    public function getAll($params = null)
    {
        $parametros = [];
        if (isset($_GET['sort'])) {
            $parametros['sort'] = $_GET['sort'];
        }
        if (isset($_GET['order'])) {
            $parametros['order'] = $_GET['order'];
        }
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPorPagina = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;
        $offset = ($paginaActual - 1) * $itemsPorPagina;
        $parametros['limit'] = $itemsPorPagina;
        $parametros['offset'] = $offset;
        $movies = $this->model->getMovies($parametros);
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
}
