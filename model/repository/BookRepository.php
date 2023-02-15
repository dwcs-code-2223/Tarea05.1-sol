<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of BookRepository
 *
 * @author mfernandez
 */
class BookRepository extends BaseRepository implements IBookRepository {

    // private MyPDO $conn;

    public function __construct() {
        // $this->conn = new MyPDO();
        parent::__construct();
        $this->table_name = "books";
        $this->pk_name = "book_id";
        $this->class_name = "Book";
        $this->default_order_column = "title";
    }

    public function getLibrosYAutoresAgrupadosFetchAll(): array {

        $pdostmt = $this->conn->query('SELECT b.title,'
                . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
                . ' from books b '
                . ' INNER JOIN book_authors ba ON b.book_id = ba.book_id '
                . ' INNER JOIN authors a on ba.author_id=a.author_id'
                . ' GROUP BY b.title ');

        $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);

        return $array;
    }

    public function buscarPorAutorOTitulo($cadena): array {
        $pdostmt = $this->conn->prepare(
                'SELECT T.title, T.name FROM ('
                . 'SELECT b.title,'
                . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
                . ' from books b '
                . ' LEFT JOIN book_authors ba ON b.book_id = ba.book_id '
                . ' LEFT JOIN authors a on ba.author_id=a.author_id '
                . ' GROUP BY b.title '
                . ') as T WHERE T.name LIKE ? OR  T.title LIKE ? ');

        $criterio = "%" . $cadena . "%";
        $pdostmt->bindParam(1, $criterio);
        $pdostmt->bindParam(2, $criterio);
        $pdostmt->execute();
        // $pdostmt->debugDumpParams();

        $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    //Varias palabras
    public function buscarPorAutorOTituloPalabras($cadena): array {
        $palabrasArray = explode(" ", $cadena);

        function filtrarEspacios(string $palabra): bool {
            return (trim($palabra) !== "");
        }

        //eliminarmos palabras con solo espacios
        //https://www.php.net/manual/en/language.types.callable.php
        $palabrasArray = array_filter($palabrasArray, "filtrarEspacios");

        
        $num_repeticiones = count($palabrasArray);

        $filtro_resultado_name = $this->prepararFiltroComparacionString("T", "name", $num_repeticiones, " OR ");
        $filtro_resultado_title = $this->prepararFiltroComparacionString("T", "title", $num_repeticiones, " OR ");

        $query = 'SELECT T.title, T.name FROM ('
                . 'SELECT b.title,'
                . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'), \' \', COALESCE(a.middle_name, \'\' ), \' \',   COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
                . ' from books b '
                . ' LEFT JOIN book_authors ba ON b.book_id = ba.book_id '
                . ' LEFT JOIN authors a on ba.author_id=a.author_id '
                . ' GROUP BY b.title '
                . ') as T ';

        $query .= " WHERE $filtro_resultado_name OR $filtro_resultado_title ";

        
       // echo "La query es: $query <br/> ";
        $sentencia = $this->conn->prepare($query);
       
        
        for ($index = 0; $index < count($palabrasArray); $index++) {
            $palabrasArray[$index]='%'. $palabrasArray[$index].'%';
        }
            
//        print_r($palabrasArray);
//        echo" <br/>";       
       
        
        $arraydoblepalabras = array_merge($palabrasArray, $palabrasArray);
       // print_r($arraydoblepalabras);
        $sentencia->execute($arraydoblepalabras);     

        $resultado= $sentencia->get_result();
        
        $array = $resultado->fetch_all(MYSQLI_ASSOC);
        return $array;
    }

    /**
     *  Devuelve un string con filtro de parámetros nominales con LIKE para una determinada tabla y columna.
     * @param type $aliasTabla <p>alias de la tabla sobre la que se aplica el filtro</p>
     * @param type $nombre_columna  <p> nombre de la columna sobre la que se aplica la condición </p>
     * @param type $plantilla_param  <p>nombre del parámetro nominal (sin puntos)</p>
     * @param type $numRepeticiones <p> número de veces que se repite la condición</p>
     * @param type $operadorBool <p> operador AND u OR</p>
     * @return type
     */
    private function prepararFiltroComparacionString($aliasTabla, $nombre_columna,  $numRepeticiones, $operadorBool) {
        $query_plantilla_name = "$aliasTabla.$nombre_columna LIKE ";

        $array_query_name = array();
        for ($i = 0; $i < $numRepeticiones; $i++) {
           // $param = ":" . $plantilla_param . $i;
            $param="?";
            $query_name = $query_plantilla_name . $param;
            array_push($array_query_name, $query_name);
        }

        $array_resultado = implode($operadorBool, $array_query_name);
        return $array_resultado;
    }

    public function create($book) {
        $sentencia = $this->conn->prepare("INSERT INTO books(title, isbn, published_date, publisher_id) VALUES ( ?, ?, ?, ? ) ");
        $titulo = $book->getTitle();
        $isbn = $book->getIsbn();
        $pdate = ($book->getPublished_date() != null) ? $book->getPublished_date()->format("Y-m-d") : null;
        $publisher_id = $book->getPublisher_id();

        $sentencia->bind_param("sssi", $titulo, $isbn, $pdate, $publisher_id);

        $sentencia->execute();

        //Recuperamos el id de la última inserción
        $book_id = $this->conn->insert_id;
        //var_dump($book_id);
        //Establecemos el id como parte del objeto
        if ($book_id !== 0) {
            $book->setBook_id($book_id);
            return $book;
        } else {
            return null;
        }
    }

    public function update($book): bool {
        $pdostmt = $this->conn->prepare("UPDATE books"
                . " SET title = :newTitle, isbn = :newIsbn, published_date = :newDate, publisher_id =:newPublisher_id "
                . "WHERE book_id = :book_id");
        $pdostmt->bindValue("book_id", $book->getBook_id());
        $pdostmt->bindValue("newTitle", $book->getTitle());
        $pdostmt->bindValue("newIsbn", $book->getIsbn());
        $pdostmt->bindValue("newDate", ($book->getPublished_date() != null) ? $book->getPublished_date()->format("Y-m-d") : null);
        $pdostmt->bindValue("newPublisher_id", $book->getPublisher_id());

        $pdostmt->execute();

        return ($pdostmt->rowCount() == 1);
    }

    public function read($book_id) {
        $book = parent::read($book_id);
        if ($book !== false) {
            //Las propiedades se establecen como cadenas de texto
            //Lee un string inicialmente y lo convertimos a DateTimeInmutable
            //Ojo, que la propiedad published_date de Book no puede ser tipada para que no dé problemas
            $date = Util::stringToDateTimeISO8601($book->getPublished_date());
            if ($date != null) {
                $book->setPublished_date($date);
            }
            return $book;
        } else {
            return null;
        }
    }

    public function addAuthorToBook($book_id, $author_id): bool {
        $sentencia = $this->conn->prepare("INSERT INTO book_authors(author_id, book_id) VALUES (?, ?)");

        $sentencia->bind_param("ii", $author_id, $book_id);

        $sentencia->execute();
        $resultado = $sentencia->get_result();

        // echo "Num rows afectadas en " . __METHOD__ . "es: " . $this->conn->affected_rows;
        return ($this->conn->affected_rows === 1);
    }

}
