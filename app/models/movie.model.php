<?php
require_once './config.php';

class MovieModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=".MYSQL_HOST.
                            ";dbname=".MYSQL_DB.
                            ";charset=utf8",
                            MYSQL_USER,MYSQL_PASS);
        $this->_deploy();
    }

    private function _deploy(){
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0){
            $sql = <<<END

                CREATE TABLE `genre` (
                `id` int(11) NOT NULL,
                `genre` varchar(30) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `genre`
                --

                INSERT INTO `genre` (`id`, `genre`) VALUES
                (5, 'accion'),
                (6, 'aventura'),
                (7, 'comedia'),
                (8, 'crimen');

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `movie`
                --

                CREATE TABLE `movie` (
                `id` int(11) NOT NULL,
                `title` varchar(70) NOT NULL,
                `director` varchar(30) NOT NULL,
                `id_genre` int(11) NOT NULL,
                `descrip` text NOT NULL,
                `img` varchar(200) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `movie`
                --

                INSERT INTO `movie` (`id`, `title`, `director`, `id_genre`, `descrip`, `img`) VALUES
                (7, 'El padrino', 'Francis Ford Coppola', 8, 'Don Vito Corleone es el respetado y temido jefe de una de las cinco familias de la mafia de Nueva York en los años 40. El hombre tiene cuatro hijos: Connie, Sonny, Fredo y Michael, que no quiere saber nada de los negocios sucios de su padre. Cuando otro capo, Sollozzo, intenta asesinar a Corleone, empieza una cruenta lucha entre los distintos clanes.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdohemWWsH0BxkyIhJwlmTJmBK1Ix2jCXntg&s'),
                (8, 'Kill bill', 'Quentin Tarantino', 5, 'Mamba Negra es una asesina que, el día de su boda, es atacada por los miembros de la banda de su jefe, Bill. Sin embargo consigue sobrevivir, aunque queda en coma. Cinco años después despierta, con un deseo de venganza.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8wAHtrHuAsLx_IwBMYHdEE65lmMNIHt60cg&s'),
                (9, 'Jurassic Park', 'Steven Spielberg', 6, 'El multimillonario John Hammond hace realidad su sueño de clonar dinosaurios del Jurásico y crear con ellos un parque temático en una isla. Antes de abrir el parque al público general, Hammond invita a una pareja de científicos y a un matemático para que comprueben la viabilidad del proyecto. Sin embargo, el sistema de seguridad falla y los dinosaurios se escapan.\r\n', 'https://www.clarin.com/img/2021/05/21/wJI65YJFm_1200x0__1.jpg'),
                (10, 'Rapido y furioso', 'Rob Cohen', 5, 'Cada noche, Los Ángeles es testigo de alguna carrera de coches. Últimamente ha aparecido un nuevo corredor, todos saben que es duro y que es rápido, pero lo que no saben es que es un detective con la determinación de salir victorioso.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7z1e4lie-fI0BKNJUgVEz2eALOzXVHbVLpg&s'),
                (14, 'La familia de mi novia', 'Jay Roach', 7, 'Greg Focker quiere casarse con su novia, Pam, pero antes de proponerle matrimonio, debe ganarse a su formidable padre, Jack Byrnes, un ex agente de la CIA sin ningún sentido del humor, en el casamiento de la hermana de Pam. Greg hace lo imposible por causar una buena impresión, pero su visita a la casa de los Byrnes resulta una hilarante serie de desastres en donde todo lo que puede salir mal sale mal, bajo la mirada crítica y desafiante de Jack.', 'https://http2.mlstatic.com/D_NQ_NP_659174-MLA74061994547_012024-OO.jpg'),
                (15, 'Buenos vecinos', 'Nicholas Stoller', 7, 'Mac y Kelly acaban de tener una niña adorable y se han comprado una preciosa casa en las afueras. Pero estos exjuerguistas descubren de pronto que sus nuevos vecinos son los miembros de la fraternidad Delta Psi Beta, con el presidente Teddy Sanders.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRltIfVVHwdXx3vC4wcq2CVu2P0Dmdg6rPKYQ&s'),
                (16, 'El secreto de sus ojos', 'Juan José Campanella', 8, 'Benjamín Espósito es un oficial de un Juzgado de Instrucción de Buenos Aires que acaba de jubilarse. Su sueño es escribir una novela y, para ello, intentará dar solución a un caso abierto desde hace varias décadas, del cual fue testigo y protagonista. Reviviendo el caso, vuelve también a su memoria el recuerdo de una mujer, a quien ha amado en silencio durante todos esos años.', 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTiuZCK6QazCgK87TNCP4pt-sWS4pV90Ga3TqObxXaYLqxAvuQI'),
                (17, 'Terminator', 'James Cameron', 5, 'En el año 2029 las máquinas dominan el mundo. Los rebeldes que luchan contra ellas tienen como líder a John Connor, un hombre que nació en los años ochenta. Para eliminarlo y así acabar con la rebelión, las máquinas envían al pasado el robot Terminator con la misión de matar a Sarah Connor, la madre de John, e impedir así su nacimiento. Sin embargo, un hombre del futuro intentará protegerla.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7btnbUsG8w5WfXa5p7AzHgX8fM02rQzA9QA&s'),
                (18, 'Piratas del Caribe: la maldicion del Perla Negra ', 'Gore Verbinski', 6, 'El capitán Barbossa le roba el barco al pirata Jack Sparrow y secuestra a Elizabeth, amiga de Will Turner. Barbossa y su tripulación son víctimas de un conjuro que los condena a vivir eternamente y a transformarse cada noche en esqueletos vivientes.', 'https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/CDFF38C4E0D5966152BA4087F85154710B102E4DD7A8ABA5A80EC815A7F581CE/scale?width=1200&aspectRatio=1.78&format=webp'),
                (19, 'La Momia', 'Stephen Sommers', 6, 'Rick O\'Connell y un compañero descubren las ruinas de Hamunaptra. Después vuelven al mismo lugar con una egiptóloga y su hermano. Allí coinciden con un grupo de americanos que provocan la resurrección de la momia de un diabólico sacerdote egipcio.', 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQjbeyUFhC4fVpbGTnirwdLHjjjx8gMcfjymFCQUz_GFd1oTBVN');

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `user`
                --

                CREATE TABLE `user` (
                `id` int(11) NOT NULL,
                `username` varchar(200) NOT NULL,
                `password` varchar(60) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `user`
                --

                INSERT INTO `user` (`id`, `username`, `password`) VALUES
                (1, 'webadmin', '\$2y\$10\$th8zeOQxEIOTkYz4J0ePmuueSxKJWoCdn2P1MPWymyqZLPQSIf3h2');

                --
                -- Índices para tablas volcadas
                --

                --
                -- Indices de la tabla `genre`
                --
                ALTER TABLE `genre`
                ADD PRIMARY KEY (`id`);

                --
                -- Indices de la tabla `movie`
                --
                ALTER TABLE `movie`
                ADD PRIMARY KEY (`id`),
                ADD KEY `id_genre` (`id_genre`);

                --
                -- Indices de la tabla `user`
                --
                ALTER TABLE `user`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `user` (`username`);

                --
                -- AUTO_INCREMENT de las tablas volcadas
                --

                --
                -- AUTO_INCREMENT de la tabla `genre`
                --
                ALTER TABLE `genre`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

                --
                -- AUTO_INCREMENT de la tabla `movie`
                --
                ALTER TABLE `movie`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

                --
                -- AUTO_INCREMENT de la tabla `user`
                --
                ALTER TABLE `user`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
                
            END;
            $this->db->query($sql);
        }
    }

    public function getMovies()
    {
        $query = $this->db->prepare('SELECT m.*, g.genre FROM movie m JOIN genre g ON m.id_genre = g.id');
        $query->execute();

        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }
    public function getMovieById($id)
    {
        $query = $this->db->prepare('SELECT m.*, g.genre FROM movie m JOIN genre g ON m.id_genre = g.id WHERE m.id = ?');
        $query->execute([$id]);

        $movie = $query->fetch(PDO::FETCH_OBJ);
        return $movie;
    }
    public function getMoviesByGenre($id_genre)
    {
        $query = $this->db->prepare('SELECT m.*, g.genre FROM movie m JOIN genre g ON m.id_genre = g.id WHERE m.id_genre = ?');
        $query->execute([$id_genre]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }
    public function insertMovie($title, $director, $genre, $descrip, $img){
        $query = $this->db->prepare('INSERT INTO movie(title, director, id_genre, descrip, img) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$title, $director, $genre, $descrip, $img]);
    }
    public function removeMovie($id){
        $query = $this->db->prepare('DELETE FROM movie WHERE id = ?');
        $query->execute([$id]);
    }
    public function updateMovie($title, $director, $genre, $description, $img, $id){
        $query = $this->db->prepare('UPDATE movie SET title = ?, director = ?, id_genre = ?, descrip = ?, img = ? WHERE id = ?');
        $query->execute([$title, $director, $genre, $description, $img, $id]);
    }
}
