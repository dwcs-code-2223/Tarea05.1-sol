<div class="row">
	<form class="form" action="FrontController.php?controller=Book&action=delete" method="POST">
		<input type="hidden" name="id" value="<?php echo $dataToView["data"]->getBook_id(); ?>" />
		<div class="alert alert-warning">
			<b>¿Confirma que desea eliminar este libro?:</b>
			<i><?php echo $dataToView["data"]->getTitle(); ?></i>
		</div>
		<input type="submit" value="Eliminar" class="btn btn-danger"/>
		<a class="btn btn-outline-success" href="FrontController.php?controller=Book&action=list">Cancelar</a>
	</form>
</div>