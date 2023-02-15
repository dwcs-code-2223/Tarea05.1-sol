
<form class='form-control'>
    <div class="input-group">
        <input name="search" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" required/>
        <button type="submit" class="btn btn-outline-primary">search</button>
    </div>
</form>
<?php if ( isset($dataToView["data"]) && count($dataToView["data"]) > 0):
?>
<p>Resultados de la búsqueda </p>
<ul>
    <?php
    $resultado = $dataToView["data"];
    foreach ($resultado as $key => $value) : ?>
        <li> <?= $resultado[$key]["title"] ?> <?= $resultado[$key]["name"] ?></li>


    <?php endforeach; ?>

</ul>

<?php elseif(isset($dataToView["data"]) && count($dataToView["data"])==0):
?>
<div class='alert alert-info'>No se han encontrado resultados</div><?php
endif;

