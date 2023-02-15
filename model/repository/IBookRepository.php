<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

/**
 *
 * @author wadmin
 */
interface IBookRepository extends IBaseRepository {
    //put your code here
    
        public function getLibrosYAutoresAgrupadosFetchAll():array;
        public function buscarPorAutorOTitulo($palabra):array;
        public function buscarPorAutorOTituloPalabras($cadena):array;
        public function addAuthorToBook($book_id, $author_id): bool;
        
        

}
