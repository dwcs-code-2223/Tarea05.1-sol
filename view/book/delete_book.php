<div class="row">
    <?php
    if (isset($dataToView["data"])) {
        $exito = $dataToView["data"];
    }
    if (isset($exito) && ($exito===true)):
        ?>

        <div class="alert alert-success">
            Libro eliminado correctamente. <a href="FrontController.php?controller=Book&action=list">Volver al listado</a>
        </div>
        <?php
    else:
        ?>
        <div class="alert alert-danger">
            Ha ocurrido algún problema y no se ha podido eliminar el libro. <a href="FrontController.php?controller=Book&action=list">Volver al listado</a>
        </div>
    <?php endif;
    ?>
</div>