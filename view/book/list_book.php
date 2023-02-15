<div class="row">
    <div class="col-md-12 text-right">

    </div>
    <?php if (count($dataToView["data"]) > 0) : ?>

        <table class="table">
            <thead>
                <tr>

                    <th scope="col">Título</th>
                    <th scope="col">Autores</th>
                    <th scope="col">Editorial</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Fecha de publicación</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataToView["data"] as $book) { ?>
                    <tr>
                        <td><?= $book["title"] ?></td>
                        <td><?= $book["authors_names"] ?></td>
                        <td><?= $book["publisher_name"] ?></td>
                        <td><?= $book["isbn"] ?></td>
                        <td><?= $book["published_date"] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php endif;

    if (count($dataToView["data"]) === 0):
        ?>

        <div class="alert alert-info">
            Actualmente no existen libros.
        </div>
        <?php
    endif;
    ?>
</div>