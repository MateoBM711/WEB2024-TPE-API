<?php
require_once 'app/models/movie.model.php';

class ApiMovieController{
    private $model;
    function __construct()
    {
        $this->model = new MovieModel;
    }
    function getAll(){
        echo "getall aca";
    }
}