<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MyPDO
 *
 * @author mfernandez
 */
class MyMySqli extends mysqli {

    public function __construct($host, $usuario, $contraseña, $bd) {


        parent::__construct($host, $usuario, $contraseña, $bd);

        if ($this->connect_error) {
            die('Error de Conexión (' . $this->connect_errno . ') '
                    . $this->connect_error);
        }
        else{
            echo 'Éxito... ' . $this->host_info . "\n";
        }
        //Para versiones e PHP anteriores a 5.2.9 y 5.3.0.

//        if (mysqli_connect_error()) {
//            die('Error de Conexión (' . mysqli_connect_errno() . ') '
//                    . mysqli_connect_error());
//        }
    }

}
