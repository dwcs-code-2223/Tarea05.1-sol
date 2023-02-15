<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AddBookViewData
 *
 * @author wadmin
 */
trait AddBookViewData{
    use ViewData;
    
    private array $all_authors;
    private array $all_publishers;
    
    public function getAll_authors(): array {
        return $this->all_authors;
    }

    public function getAll_publishers(): array {
        return $this->all_publishers;
    }

    public function setAll_authors(array $all_authors): void {
        $this->all_authors = $all_authors;
    }

    public function setAll_publishers(array $all_publishers): void {
        $this->all_publishers = $all_publishers;
    }




}
