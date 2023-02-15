<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Book
 *
 * @author wadmin
 */
class Book {
    
    use AddBookViewData;
    
    public int $book_id;
    public string $title;
    public ?string $isbn;
    public ?int $publisher_id;
    public  $published_date;
    
    //Si usáseis POO estricta
//    private $autores; //array de objetos Autor
//    
//   
//
//    public function getAutores() {
//        return $this->autores;
//    }
//
//    public function setAutores($autores): void {
//        $this->autores = $autores;
//    }

             
    public function getBook_id(): int {
        return $this->book_id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getIsbn(): ?string {
        return $this->isbn;
    }

    public function getPublisher_id(): ?int {
        return $this->publisher_id;
    }

    public function getPublished_date() {
        return $this->published_date;
    }


    public function setBook_id(int $book_id): void {
        $this->book_id = $book_id;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setIsbn(?string $isbn): void {
        $this->isbn = $isbn;
    }

    public function setPublisher_id(?int $publisher_id): void {
        $this->publisher_id = $publisher_id;
    }

    public function setPublished_date($published_date): void {
        $this->published_date = $published_date;
    }


        
   
    
    
   


}
