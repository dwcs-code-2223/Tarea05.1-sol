<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of BookController
 *
 * @author mfernandez
 */
class BookController {

    public $page_title;
    public $view;
    private $bookServicio;

    const VIEW_FOLDER = 'book';

    public function __construct() {
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'new_publisher';
        $this->page_title = '';
        $this->bookServicio = new BookServicio();
    }

    public function addPublisher() {
        $this->page_title = 'Nueva editorial';
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'new_publisher';
        $obj_guardado = new Publisher();

        if (isset($_POST["publisher"])) {
            $publisher = $_POST["publisher"];

            if (trim($publisher) !== "") {
                $publisher_obj = new Publisher();
                $publisher_obj->setName($publisher);

                $obj_guardado = $this->bookServicio->addPublisher($publisher_obj);
                if ($obj_guardado == null) {
                    $obj_guardado = new Publisher();
                    $obj_guardado->setStatus(Util::OPERATION_NOK);
                }
            } else {
                $obj_guardado->setStatus(Util::OPERATION_NOK);
                $obj_guardado->addError("No se aceptan cadenas vacías");
            }
        }
        return $obj_guardado;
    }

    public function addAuthor() {
        $this->page_title = 'Nuevo/a autor/a';
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'new_author';
        $author = new Author();
        if (isset($_POST["first"]) && isset($_POST["last"])) {

            if (Util::isNotEmpty($_POST["first"]) && Util::isNotEmpty($_POST["last"])) {
                $first = $_POST["first"];
                $last = $_POST["last"];
                $middle = null;
                $bdate = null;

                if (Util::isNotEmpty($_POST["middle"])) {
                    $middle = $_POST["middle"];
                }
                if (Util::isNotEmpty($_POST["bdate"])) {
                    $bdate = $_POST["bdate"];
                    $bdate = DateTimeImmutable::createFromFormat("Y-m-d", $bdate);
                }


                $author->setFirst_name($first);
                $author->setLast_name($last);
                $author->setMiddle_name($middle);
                $author->setBirthDate($bdate);

                $author_guardado = $this->bookServicio->addAuthor($author);

                if ($author_guardado != null) {
                    $author->setStatus(Util::OPERATION_OK);
                } else {
                    $author->setStatus(Util::OPERATION_NOK);
                }
            }
            return $author;
        }
    }

    public function addBook() {
        $this->page_title = 'Nuevo libro';
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'new_book';

        $publishers = $this->bookServicio->getPublishers();
        $authors = $this->bookServicio->getAuthors();

        $book = new Book();
        $book->setAll_publishers($publishers);
        $book->setAll_authors($authors);

        if (isset($_POST["title"])) {


            $pdate = null;
            $isbn = null;
            $pub_Id = null;
            $authors = null;
            $title = "";

            if (Util::isNotEmpty($_POST["title"])) {
                $title = $_POST["title"];
            }

            if (isset($_POST["isbn"]) && Util::isNotEmpty($_POST["isbn"])) {
                $isbn = $_POST["isbn"];
            }

            if (isset($_POST["pdate"]) && Util::isNotEmpty($_POST["pdate"])) {
                $pdate = $_POST["pdate"];
                $pdate_converted = DateTimeImmutable::createFromFormat("Y-m-d", $pdate);
                if ($pdate_converted !== false) {
                    $pdate = $pdate_converted;
                }
            }

            if (isset($_POST["publisher"]) && Util::isNotEmpty($_POST["publisher"])) {
                $pub_Id = $_POST["publisher"];
            }


            $book->setTitle($title);
            $book->setIsbn($isbn);
            $book->setPublished_date($pdate);
            $book->setPublisher_id($pub_Id);
//Si fuese una relación POO de Book y array de Author
//            if (isset($_POST["$authors"]) && count($_POST["$authors"]) > 0) {
//                $authors = $_POST["$authors"];
//                $array_authors = array();
//                foreach ($authors as $author_id):
//                    $author = new Author();
//                    $author->setAuthor_id($author_id);
//                    array_push($array_authors, $author);
//                endforeach;
//                $book->setAutores($array_authors);
//            }

            $exito = $this->bookServicio->addBook($book, $_POST["authors"]);
            if ($exito) {
                $book->setStatus(Util::OPERATION_OK);
            } else {
                $book->setStatus(Util::OPERATION_NOK);
            }
        } else {
            $book->setStatus(Util::NO_OPERATION);
        }

        return $book;
    }

    public function search() {
        $this->view=self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'search_book';
        $this->page_title = "Búsqueda de libros por autor o título";
        if (isset($_GET["search"])) {

            $cadena = $_GET["search"];
            if (Util::isNotEmpty($cadena)) {
                return $this->bookServicio->search($cadena);
            }
        }
    }

}
