<form class='form-control ' method="post">
    <div>
        <label for="title" class="form-label col-3">Título</label>
        <input name="title" type="text" class="form-control col-9" id="title" pattern="^(?!\s*$).+"
               required/>
    </div>
    <div>
        <label for="isbn" class="form-label col-3">ISBN</label>
        <input name="isbn" type="text" class="form-control col-9" id="isbn" pattern="^(?!\s*$).+"
               />
    </div>

    <div>
        <label for="pdate" class="form-label col-3">Fecha de publicación</label>
        <input name="pdate" type="date" class="form-control col-9" id="pdate" 
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
                            ?>
                            <option value="<?= $publisher->getPublisher_id() ?>"><?= $publisher->getName() ?></option>
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
                            ?>
                            <option value="<?= $auth->getAuthor_id() ?>"><?= $auth->getCompleteName() ?></option>
                            <?php
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
        <button type="submit" class="btn btn-primary my-3 col-3">Crear libro</button>
    </div>

</form>

<?php if (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_OK)): ?>

    <div class="alert alert-success" role="alert" >
        El libro se ha creado correctamente
    </div>

<?php elseif (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_NOK)): ?>
    <div class="alert alert-danger" role="alert">
        Ha ocurrido un error y no se ha podido crear el libro.
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




