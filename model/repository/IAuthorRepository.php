<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

/**
 *
 * @author mfernandez
 */
interface IAuthorRepository extends IBaseRepository{
   public function getAuthorIdsByBookId($book_id):array;
}
