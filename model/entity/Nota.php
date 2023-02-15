<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Note
 *
 * @author maria
 */
class Nota implements JsonSerializable {

    use ViewData;

    private ?int $id;
    private string $titulo;
    private string $contenido;
  
    private string $imagePath="";

    public function __construct(?int $id = null, String $titulo = "", String $contenido = "") {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitulo(): String {
        return $this->titulo;
    }

    public function getContenido(): String {
        return $this->contenido;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setTitulo(String $titulo): void {
        $this->titulo = $titulo;
    }

    public function setContenido(String $contenido): void {
        $this->contenido = $contenido;
    }

   public function getImagePath(): string {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): void {
        $this->imagePath = $imagePath;
    }


    public function jsonSerialize() {
        //Especificamos qué propiedades no públicas queremos que pasen a formar parte del objeto JSON
        return array(
            'id' => $this->id,
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'imagePath' => $this->imagePath
        );
    }
    
 

}
