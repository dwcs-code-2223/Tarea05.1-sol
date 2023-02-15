<form class='form-control' method="post" action="FrontController.php?controller=Book&action=addAuthor">
    <div>
        <label for="first" class="form-label col-3">Nombre</label>
        <input name="first" type="text" class="form-control col-9" id="first" 
               required pattern="^(?!\s*$).+"
               />
        <!--https://stackoverflow.com/questions/3085539/regular-expression-for-anything-but-an-empty-string-->
    </div>
    <div>
        <label for="middle" class="form-label col-3">Segundo nombre</label>
        <input name="middle" type="text" class="form-control col-9" id="middle" pattern="^(?!\s*$).+"
               />
    </div>

    <div>
        <label for="last" class="form-label col-3">Apellidos</label>
        <input name="last" type="text" class="form-control col-9" id="last" pattern="^(?!\s*$).+"
               required/>
    </div>


    <div>
        <label for="bdate" class="form-label col-3">Fecha de nacimiento</label>
        <input name="bdate" type="date" class="form-control col-9" id="bdate" 
               />
    </div>
    <button type="submit" class="btn btn-primary my-3">Crear</button>


</div>
</form>

<?php if (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_OK)): ?>
    <div class="alert alert-success my-3" role="alert" >
        El/La autor/a se ha creado correctamente
    </div>

<?php elseif (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_NOK)): ?>
    <div class="alert alert-danger my-3" role="alert">
        Ha ocurrido un error y no se ha podido crear el/la autor/a.
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