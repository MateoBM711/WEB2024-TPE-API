# WEB2024-TPE-API

##

## Listado ordenado

### Listado ordenado de peliculas

- Endpoint -> `GET /api/peliculas?order=<>&sort=<>&page=<>&limit=<>`

En este endpoint se listan todas las peliculas del catalogo que se encuentran en la base de datos. Luego de **"order="** se declara el atributo por el cual se va a ordenar la lista, acepta cualquier atributo de la pelicula. Con el parametro **"sort="** se establece si el orden del listado sera de forma ascendente(ASC) o descendente(DESC).
Para utilizar el paginado del catalogo se utilizan los parametros:
**"page="** que indica la pagina en la cual se encuentra actualmente, por defecto sera 1.
**"limit="** que indica la cantidad de peliculas que veremos por pagina, por defecto sera 4.

#### Ejemplo

**_/api/peliculas?order=id&sort=ASC&page=1&limit=5_**

Con estos valores se mostrara la primer pagina del catalogo con 5 peliculas en la lista, la cual estara ordenada por el id de las peliculas de manera que la pelicula con el id mas bajo se mostrara primero y luego ira ascendiendo.
Cada pelicula se mostrara de la siguiente manera:

```json
{
  "id": 14,
  "title": "La familia de mi novia",
  "director": "Jay Roach",
  "id_genre": 7,
  "descrip": "Greg Focker quiere casarse con su novia, Pam, pero antes de proponerle matrimonio, debe ganarse a su formidable padre, Jack Byrnes, un ex agente de la CIA sin ningún sentido del humor, en el casamiento de la hermana de Pam. Greg hace lo imposible por causar una buena impresión, pero su visita a la casa de los Byrnes resulta una hilarante serie de desastres en donde todo lo que puede salir mal sale mal, bajo la mirada crítica y desafiante de Jack.",
  "img": "https://http2.mlstatic.com/D_NQ_NP_659174-MLA74061994547_012024-OO.jpg",
  "genre": "Comedia"
}
```

### Listado ordenado de reviews

- Endpoint -> `GET api/reviews?order=<>&sort=<>&page=<>&limit=<>`

En este endpoint se listan todas las reviews que se encuentran en la base de datos. Luego de **"order="** se declara el atributo por el cual se va a ordenar la lista, acepta cualquier atributo de la review. Con el parametro **"sort="** se establece si el orden del listado sera de forma ascendente(ASC) o descendente(DESC).
Para utilizar el paginado de las reviews se utilizan los parametros:
**"page="** que indica la pagina en la cual se encuentra actualmente, por defecto sera 1.
**"limit="** que indica la cantidad de reviews que veremos por pagina, por defecto sera 10.

#### Ejemplo

**_/api/reviews?order=id&sort=ASC&page=2&limit=6_**

Con estos valores se mostraran la segunda pagina de las reviews con 6 reviews de la lista, la cual estara ordenada por el id de la review donde se mostrara primero la de menor id e ira ascendiendo.
Cada review se mostrara de la siguiente manera:

```json
{
  "id": 7,
  "id_movie": 16,
  "comment": "Clasico total del cine argentino"
}
```

##

## Obtener un elemento por ID

### Obtener una pelicula por ID

- Endpoint -> `GET api/peliculas/:ID`

En este endpoint se obtiene una pelicula determinada requiriendola por su **id**. Si el id ingresado es inexistente se devuelve un String y un error 404. A diferencia del listado de peliculas, aca se agrega el listado de comentarios de esa pelicula.

#### Ejemplo

**_/api/peliculas/8_**

En este caso se retorna la pelicula con el **id=8** en formato JSON de la siguiente manera:

```json
{
  "id": 8,
  "title": "Kill bill",
  "director": "Quentin Tarantino",
  "id_genre": 5,
  "descrip": "Mamba Negra es una asesina que, el día de su boda, es atacada por los miembros de la banda de su jefe, Bill. Sin embargo consigue sobrevivir, aunque queda en coma. Cinco años después despierta, con un deseo de venganza.",
  "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8wAHtrHuAsLx_IwBMYHdEE65lmMNIHt60cg&s",
  "genre": "Accion",
  "comments": [
    {
      "comment": "La mejor pelicula que vi en mi vida"
    },
    {
      "comment": "Un clasico de Tarantino, cada tanto la vuelvo a ver"
    },
    {
      "comment": "Un clasico de Tarantino"
    },
    {
      "comment": "Esta pelicula me da ganas de salir a pelearme con alguien"
    }
  ]
}
```

### Obtener una review por ID

- Endpoint -> `GET api/reviews/:ID`

En este endpoint se obtiene una review especificada por el **id**. Si el id ingresado no existe se devuelve un String y un 404.

#### Ejemplo

**_/api/reviews/14_**

En este caso se retornaria la review con el **id=14** en formato JSON de la siguiente manera:

```json
{
    "id": 14,
    "id_movie": 8,
    "comment": "Esta pelicula me da ganas de salir a pelearme
    con alguien"
}
```

##

## PUT

### Modificar una review

- Endpoint -> `PUT /api/reviews/:ID`

En este endpoint se utiliza para actualizar o modificar los datos de una review en particular. La review deseada se indica con el **id**. En el body de POSTMAN o la aplicacion que se use para probar, se cargan los valores nuevos de dicha review. Se deben cargar todos los datos nuevamente aun que solo se desee cambiar un solo atributo.

#### Ejemplo

**_/api/reviews/6_**

Si se quisiera cambiar el id de la pelicula por ejemplo, se deberan cargar, en el body, todos los datos originales cambiandole el id_movie.

```json
{
  "id": 6,
  "id_movie": 15, //id_movie modificado
  "comment": "Excelente reflejo de lo que es la vida descontrolada de los adolescentes americanos"
}
```

Luego se envia la request. Si el producto se pudo actualizar correctamente se mostrara un 200 y la review actualizada.

##

## POST

### Agregar una review

- Endpoint -> `POST api/reviews`

Este endpoint se utiliza para agregar una nueva review a la base de datos. En el **body** se escriben todos los atributos de la nueva review. Siempre en formato JSON

#### Ejemplo

**\_/api/reviews**

En el body se escriben los valores de la nueva review de lasiguiente manera:

```json
{
  "id": 31,
  "id_movie": 17,
  "comment": "Siempre supe que las maquinas iban a ser la perdicion de la humanidad"
}
```

En caso que la review se agregue correctamente se devuelve la lista de reviews con la nueva review y un 200.

##

## DELETE

### Eliminar una review

- Endpoint -> `DELETE /api/reviews/:ID`

Este endpoint se utiliza para borrar una review de la base de datos. Se indica la review con el **id**. En caso que la review con el id indicado exista, se devuelve un String y un 200, confirmando la eliminacion. Por otro lado, si el id no existe se envia un String y un 404.

#### Ejemplo

**_/api/reviews/10_**

En este caso se eliminaria la review con el **id=10**. La review eliminada seria:

```json
{
  "id": 10,
  "id_movie": 9,
  "comment": "Malisima"
}
```

La proxima vez que se obtenga el listado dicha review no apareceria.
