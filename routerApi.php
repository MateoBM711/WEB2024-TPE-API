<?php
/*-Servicio LISTADO (GET) 
    debe poder ordenarse por cualquier campo de la tabla,
    de manera ascendente o descendente.
    OPCIONALES
    se debe poder paginar.
    se debe poder filtrar por alguno de sus campos
  -Servicio OBTENER/:ID (GET)
  -Servicio para agregar (POST)
    OPCIONAL
    se debe requerir un token para realizar una modificacion
  -Servicio para modificar (PUT)
    OPCIONAL
    se debe requerir un token para realizar una modificacion 
  
  Se debe manejar los codigos de error (200, 201, 400, 404)
  
  OPCIONALES
    el servicio de lista se debe poder paginar.
    el servicio de lista se debe poder filtrarse por alguno de sus campos*/

require_once './app/libs/router.php';
require_once './app/controllers/api.movie.controller.php';

$router = new Router();
//       addRoute (endpoint,   verb,   controller,           method) */
$router->addRoute('peliculas', 'GET', 'ApiMovieController', 'getAll');
$router->addRoute('peliculas/:ID', 'GET', 'ApiMovieController', 'get');
$router->addRoute('peliculas/:ID', 'DELETE', 'ApiMovieController', 'delete');
$router->addRoute('peliculas', 'POST', 'ApiMovieController', 'add');
//$router->addRoute('peliculas/:ID', 'PUT', 'ApiMovieController', 'update');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
