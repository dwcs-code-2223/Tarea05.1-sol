<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Author
 *
 * @author mfernandez
 */
class Author {
    use ViewData;
    
     private $author_id;
   private $first_name;
   private $last_name;
   private $middle_name;
   private $birthDate;
   
   private $completeName;
   
   public function getFirst_name() {
       return $this->first_name;
   }

   public function getLast_name() {
       return $this->last_name;
   }

   public function getMiddle_name() {
       return $this->middle_name;
   }

   public function getBirthDate() {
       return $this->birthDate;
   }

   public function setFirst_name($first_name): void {
       $this->first_name = $first_name;
   }

   public function setLast_name($last_name): void {
       $this->last_name = $last_name;
   }

   public function setMiddle_name($middle_name): void {
       $this->middle_name = $middle_name;
   }

   public function setBirthDate($birthDate): void {
       $this->birthDate = $birthDate;
   }

   public function getAuthor_id() {
       return $this->author_id;
   }

   public function setAuthor_id($author_id): void {
       $this->author_id = $author_id;
   }

   public function getCompleteName() {
       return $this->completeName;
   }

   public function setCompleteName($completeName): void {
       $this->completeName = $completeName;
   }

}
