<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of UsuarioRepository
 *
 * @author wadmin
 */
class UsuarioRepository implements IUsuarioRepository{
    const RUTA_FICHERO = "config" . DIRECTORY_SEPARATOR . "users.json";

    private $filePath;
    private $usuariosArray = [];

    public function __construct() {
        $this->filePath = dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . self::RUTA_FICHERO;
        $this->usuariosArray = $this->getUsuarios();
        //print_r($this->usuariosArray);
    }
    
      public function getUsuarios(): array {

        //Leemos el fichero JSON y se devuelve array con índices numéricos con tantos índices como notas haya.
        // El valor del array es a su vez un array asociativo con claves "id", "titulo", "contenido"
        $arrayFromJSON = json_decode(file_get_contents($this->filePath), true);
        $arrayUsuarios = [];
        if ($arrayFromJSON != null) {
            foreach ($arrayFromJSON as $index => $usuariosArrayAsoc) {

                $usuario = Util::json_decode_array_to_class($usuariosArrayAsoc, "Usuario");
                array_push($arrayUsuarios, $usuario);
            }
        }

        return $arrayUsuarios;
    }
    
   
}
