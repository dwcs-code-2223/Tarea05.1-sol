<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>


<form method="post" 
      action="FrontController.php?controller=Book&action=addPublisher"
      >
    <div class="mb-3">
        <label for="publisher" class="form-label">Editorial</label>
        <input 
            name="publisher"
            type="text" class="form-control" id="publisher" required >

    </div>

    <button type="submit" class="btn btn-primary">Crear</button>
</form>

<?php if (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_OK)): ?>
    <div class="alert alert-success my-3" role="alert" >
        La editorial se ha creado correctamente
    </div>

<?php elseif (isset($dataToView["data"]) && ($dataToView["data"]->getStatus() === Util::OPERATION_NOK)): ?>
    <div class="alert alert-danger my-3" role="alert">
        Ha ocurrido un error y no se ha podido crear la editorial
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
    <?php endif;
?>