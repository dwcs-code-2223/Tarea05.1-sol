<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AuthorRepository
 *
 * @author mfernandez
 */
class AuthorRepository extends
BaseRepository implements IAuthorRepository {

    public function __construct() {
        // $this->conn = new MyPDO();
        parent::__construct();
        $this->table_name = "authors";
        $this->pk_name = "author_id";
        $this->class_name = "Author";
        $this->default_order_column = "last_name";
    }

    //put your code here
    public function create($author) {
        $sentencia = $this->conn->prepare("INSERT INTO `authors`(`first_name`, `middle_name`, `last_name`, `birth_date`) VALUES ( ?, ?, ?, ?)");
        $first_name = $author->getFirst_name();
        $middle_name = $author->getMiddle_name();
        $last_name = $author->getLast_name();
        $bdate = ($author->getBirthDate() !== null) ? $author->getBirthDate()->format("Y-m-d") : null;

        $sentencia->bind_param("ssss", $first_name, $middle_name, $last_name, $bdate);

        //$pdostmt->debugDumpParams();
        $sentencia->execute();

        //Recuperamos el id de la última inserción
        $author_id = $this->conn->insert_id;

        //Establecemos el id como parte del objeto
        if ($author_id !== 0) {
            $author->setAuthor_id($author_id);
        } else {
            $author = null;
        }

        $sentencia->close();

        return $author;
    }

    public function update($object): bool {
        //TO DO
    }

    public function findAll(): array {
        $sentencia = $this->conn->prepare("SELECT author_id, "
                . "CONCAT (COALESCE(a.last_name, ''), ' ', COALESCE(a.first_name,''), ' ',"
                . "COALESCE(a.middle_name, '' )) as completeName " .
                " FROM authors a ORDER BY $this->default_order_column");

        $sentencia->execute();

        $resultado = $sentencia->get_result();
        $authors_array = array();

        while ($object = $resultado->fetch_object($this->class_name)) {

            array_push($authors_array, $object);
        }

        $sentencia->close();
        $resultado->close();

        return $authors_array;
    }

}
