<?php
 $title = $isbn = $fecha = $editorial = "";
$book_author_ids=null;
$book_id=null;

if (isset($dataToView["data"])) {
    $book = $dataToView["data"];

    if ($book->getBook_id() !== null) {
        $book_id = $book->getBook_id();
    }
    if ($book->getTitle() !== null) {
        $title = $book->getTitle();
    }
    if ($book->getIsbn() !== null) {
        $isbn = $book->getIsbn();
    }

    if ($book->getPublisher_id() !== null) {
        $editorial = $book->getPublisher_id();
    }

    if ($book->getPublished_date() !== null) {
        $fecha = $book->getPublished_date()->format("Y-m-d");
    }

    $book_author_ids = $book->getAuthor_ids();
    //print_r($book_author_ids);
}
?>



<form class='form-control ' method="post" action="FrontController.php?controller=Book&action=save">
    <input type="hidden" value="<?=$book_id?>" name="book_id"/>
    <div>
        <label for="title" class="form-label col-3">Título</label>
        <input name="title" type="text" class="form-control col-9" id="title" pattern="^(?!\s*$).+"
               value="<?= $title ?>"  required/>
    </div>
    <div>
        <label for="isbn" class="form-label col-3">ISBN</label>
        <input name="isbn" type="text" class="form-control col-9" id="isbn" pattern="^(?!\s*$).+"
               value="<?= $isbn ?>"    />
    </div>

    <div>
        <label for="pdate" class="form-label col-3">Fecha de publicación</label>
        <input name="pdate" type="date" class="form-control col-9" id="pdate"  value="<?= $fecha ?>"
               />
    </div>

    <div class='row form-group my-3'>
        <label for="publisher" class="col-form-label col-2">Editorial</label>
        <div class='col-6'>
            <select name="publisher" id="publisher" class="form-control col-3" required>
<?php
if (isset($dataToView["data"])) :
    $publishers = $dataToView["data"]->getAll_publishers();
    ?>
                    <option value="">----</option>
                    <?php
                    if (count($publishers) > 0):
                        foreach ($publishers as $publisher) :
                            $selected = ($publisher->getPublisher_id() == $editorial) ? " selected " : "";
                            ?>

                            <option value="<?= $publisher->getPublisher_id() ?>" <?= $selected ?>> <?= $publisher->getName() ?></option>
            <?php
        endforeach;
    endif;
endif;
?>


            </select>
        </div>
        <div class="alert alert-info col-4 " role="alert">
            ¿No la encuentras? <a href="FrontController.php?controller=Book&action=addPublisher" class="alert-link">Crea una nueva</a>. 
        </div>
        <!--        <a href="FrontController.php?controller=Book&action=addPublisher" class="col-3">Crear editorial </a> -->
    </div>

    <div class="form-group row my-3">
        <label for="authors" class="col-form-label col-2">Autor</label>

        <div class="col-6">
            <select name="authors[]" id="authors" class="form-control" multiple>
<?php
if (isset($dataToView["data"])) :
    $authors = $dataToView["data"]->getAll_authors();

    ?>
                    <option value="">----</option>
                    <?php
                    if (count($authors) > 0):
                        foreach ($authors as $auth) :
                            
                    // print_r($book_author_ids);
                            
                            $selected = (in_array($auth->getAuthor_id(), $book_author_ids)) ? " selected " : "";
                         
                            ?>
                            <option value="<?= $auth->getAuthor_id() ?>" <?=$selected?> ><?= $auth->getCompleteName() ?></option>
                          
                            <?php
                                 //echo "selected:$selected";
                        endforeach;
                    endif;
                endif;
                ?>


            </select>
        </div>
        <div class="alert alert-info col-4" role="alert">
            ¿No lo encuentras? <a href="FrontController.php?controller=Book&action=addAuthor" class="alert-link">Crea uno nuevo</a>. 
        </div>

    </div>
    <div class="row d-flex justify-content-center"> 
        <button type="submit" class="btn btn-primary my-3 col-3">Guardar</button>
        <a href="FrontController.php?controller=Book&action=list" class="btn btn-secondary mx-2 my-3 col-3">Volver</a>
    </div>

</form>

<?php if (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_OK)): ?>

    <div class="alert alert-success" role="alert" >
        El libro se ha guardado correctamente
    </div>

<?php elseif (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_NOK)): ?>
    <div class="alert alert-danger" role="alert">
        Ha ocurrido un error y no se ha podido guardar el libro.
        <br/>

    <?php
    if (count($dataToView["data"]->getErrors()) > 0) {
        $errors = $dataToView["data"]->getErrors();
        foreach ($errors as $msg) {
            echo "$msg <br/>";
        }
    }
    ?>
    </div>
    <?php endif; ?>




