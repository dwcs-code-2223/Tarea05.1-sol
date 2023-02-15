<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of BaseRepository
 *
 * @author mfernandez
 */
abstract class BaseRepository implements IBaseRepository {

    protected string $table_name;
    protected string $pk_name;
    protected MyMySqli $conn;
    protected string $class_name;
    protected string $default_order_column;

    public function __construct() {
        try{
        $this->conn = ConnectionFactory::getConnection();
        }
        catch(Exception $ex){
            echo "Ha ocurrido un error obteniendo la conexión: ";
            //No mostrar esta información:
            //.$ex->getMessage() ." <br/>". $ex->getTraceAsString();
            exit;
            }
    }

    abstract public function create($object);

    public function read($id) {
        $sentencia = $this->conn->prepare("SELECT * FROM $this->table_name "
                . "WHERE $this->pk_name = ?");

        $sentencia->bind_param("i", $id);

        $sentencia->execute();

        $resultado = $sentencia->get_result();
        $object = $resultado->fetch_object($this->class_name);
        //Puede devolver false en caso de error o null si no hay nada
        if ($object === false) {
            echo "Hubo un error en fetch_object";
            $object = null;
        }
        $resultado->close();
        $sentencia->close();
        
        return $object;
    }

    abstract public function update($object): bool;

    public function delete($id): bool {

        $sentencia = $this->conn->prepare(
                "DELETE FROM " . $this->table_name . " WHERE " . $this->pk_name
                . " = ?");

        $sentencia->bind_param("i", $id);

        // $pdostmt->debugDumpParams();
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $exito= ($resultado->num_rows ===1);
        
        $sentencia->close();
        $resultado->close();
        
        return $exito;
    }

    public function findAll(): array {
        $sentencia = $this->conn->prepare("SELECT *  FROM $this->table_name ORDER BY $this->default_order_column");

        $sentencia->execute();

        $resultado = $sentencia->get_result();
        $all_array = array();

        while ($object = $resultado->fetch_object($this->class_name)) {

            array_push($all_array, $object);
        }
        
        $sentencia->close();
        $resultado->close();
        return $all_array;
    }

    public function readConError($id) {
        if (!($sentencia = $conn->prepare("SELECT * FROM $this->table_name "
                . "WHERE $this->pk_name = ?"))) {
            echo "Falló la preparación: (" . $conn->errno . ") " . $conn->error;
        }

        if (!$sentencia->bind_param("i", $id)) {
            echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $sentencia->error;
        }

        if (!$sentencia->execute()) {
            echo "Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;
        }

        if (!( $resultado = $sentencia->get_result())) {
            echo "Falló get_result(): (" . $sentencia->errno . ") " . $sentencia->error;
        }
        if (!($object = $resultado->fetch_object($this->class_name))) {
            echo "Falló fetch_object: ";
        }
        return $object;
    }

    public function readNoPreparada($id) {

        $result = $conn->query("SELECT * FROM $this->table_name "
                . "WHERE $this->pk_name = $id");
   
//Llama al constructor después de establecer las propiedades. 
        $object = $result->fetch_object($this->class_name);

        $result->close();
        return $object;
    }

    public function beginTransaction(): bool {

        return $this->conn->begin_transaction();
    }

    public function commit(): bool {

        return $this->conn->commit();
    }

    public function rollback(): bool {

        return $this->conn->rollback();
    }

}
