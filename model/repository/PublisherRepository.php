<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of PublisherRepository
 *
 * @author mfernandez
 */
class PublisherRepository extends BaseRepository implements IPublisherRepository {

    public function __construct() {

        parent::__construct();
        $this->table_name = "publishers";
        $this->pk_name = "publisher_id";
        $this->class_name = "Publisher";
        $this->default_order_column = "name";
    }

    public function create($publisher) {

       $sentencia = $this->conn->prepare
                ("INSERT INTO publishers(name) VALUES ( ?) ");
        $name = $publisher->getName();
        $sentencia->bind_param("s", $name);

        $sentencia->execute();

        //Recuperamos el id de la última inserción
        $publisher_Id = $this->conn->insert_id;

        //Establecemos el id como parte del objeto
        if ($publisher_Id !== 0) {
            $publisher->setPublisher_id($publisher_Id);
           
        } else {
           $publisher=null;
        }        
        $sentencia->close();
        return $publisher;
    }

    public function update($object): bool {
        //TO DO
    }

    public function exists($name): bool {
        $sentencia = $this->conn->prepare
                ("SELECT publisher_id FROM publishers WHERE name LIKE ? ");
        $sentencia->bind_param("s", $name);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        //Devuelve array|null|false
        if (($object = $resultado->fetch_assoc()) === false) {
            echo "Falló fetch_object: ";
        }
        $exito= (($object !== null) && ($object !== false) && (count($object) > 0));
        
        $sentencia->close();
        $resultado->close();
        return $exito;
    }

}
