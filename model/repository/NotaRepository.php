<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of noteRepository
 *
 * @author maria
 */
require_once 'INotaRepository.php';

class NotaRepository implements INotaRepository {

    const RUTA_FICHERO = "config" . DIRECTORY_SEPARATOR . "notas.json";

    private $filePath;
    private $notasArray = [];

    public function __construct() {
        $this->filePath = dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . self::RUTA_FICHERO;
        $this->notasArray = $this->getNotas();
    }

    public function getNotas(): array {

        //Leemos el fichoro JSON y se devuelve array con índices numéricos con tantos índices como notas haya.
        // El valor del array es a su vez un array asociativo con claves "id", "titulo", "contenido"
        $arrayFromJSON = json_decode(file_get_contents($this->filePath), true);
        $arrayNotas = [];
        if ($arrayFromJSON != null) {
            foreach ($arrayFromJSON as $index => $notaArrayAsoc) {

                $nota = Util::json_decode_array_to_class($notaArrayAsoc, "Nota");
                array_push($arrayNotas, $nota);
            }
        }

        return $arrayNotas;
    }

    private function saveNotas(array $notas): bool {

        $writtenBytes = file_put_contents($this->filePath, json_encode($notas));

        return ($writtenBytes !== false);
    }

    public function getNotaById(int $id): Nota {

        $nota = null;

        foreach ($this->notasArray as $key => $nota) {
            if ($nota->getId() === $id) {
                return $nota;
            }
        }
        return $nota;
    }

    public function updateNota(Nota $notaToUpdate): bool {

        $encontrado = false;

        foreach ($this->notasArray as $key => $nota) {
            if ($nota->getId() === $notaToUpdate->getId()) {
                $encontrado = true;
                $nota->setTitulo($notaToUpdate->getTitulo());
                $nota->setContenido($notaToUpdate->getContenido());
                $nota->setImagePath($notaToUpdate->getImagePath());
            }
        }


        if ($encontrado) {
            $this->saveNotas($this->notasArray);
        }
        return $encontrado;
    }

    public function create(Nota $nota): Nota {

        $id = $this->getMaxId($this->notasArray);
        $nota->setId($id);

        array_push($this->notasArray, $nota);
        if ($this->saveNotas($this->notasArray)) {

            return $nota;
        } else {
            return null;
        }
    }

    public function deleteById(int $id): bool {

        $encontrado = false;

        foreach ($this->notasArray as $key => $nota) {
            if ($nota->getId() === $id) {
                $encontrado = true;
                unset($this->notasArray[$key]);
                break;
            }
        }


        if ($encontrado) {
            $this->saveNotas($this->notasArray);
        }
        return $encontrado;
    }

    private function getMaxId($arrayFichero): int {
        $max_id = 0;

        $arrayNotas = array_values($arrayFichero);

        $array_ids = array_map(function ($nota) {
            return $nota->getId();
        }, $arrayNotas
        );

        if (count($array_ids) > 0) {
            $max_id = max($array_ids);
        }


        return ++$max_id;
    }

}
