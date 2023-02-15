<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Publisher
 *
 * @author mfernandez
 */
class Publisher {
    use ViewData;

    private $publisher_id;
    private $name;

    public function getPublisher_id() {
        return $this->publisher_id;
    }

    public function getName() {
        return $this->name;
    }

    public function setPublisher_id($publisher_id): void {
        $this->publisher_id = $publisher_id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

}
