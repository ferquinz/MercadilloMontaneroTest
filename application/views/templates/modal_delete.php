<script>
		
	$(document).ready(function() {

		$("#deleteform").submit(function () {

			event.preventDefault();

			$.ajax({
				url : "ajax_delete",
				type: "POST",
				data: $(this).serialize(),
				dataType: 'json',
				success: function(data)
				{
					if (data['status'] == 0){
						showAlert("Error al eliminar el producto: Las contraseñas no coinciden", "danger");
					}
					else{
						//if success close modal and reload ajax table
						$('#deleteModal').modal('hide');
						$('input[name=filtro]').val('');
						$('#ListadoProductos').html(data.datos);				
						showAlert("Producto eliminado", "success");
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					showAlert("Error al eliminar el producto: " + errorThrown, "danger");
				}
			});
		});
	});
	
</script>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header btn-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="deleteModalLabel"><i class="icon-attention"></i> Eliminar el producto</h4>
			</div>
			<form action="#" id="deleteform" name="deleteform" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="modal-body">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Contraseña:</label>
						<input type="password" class="form-control" id="productpass" name="productpass">
						<input type="hidden" class="form-control" id="productid" name="productid">
					</div>

				</div>
				<div class="modal-footer" style="padding: 5px !important;">
					<button type="submit" id="btnEliminarProducto" class="btn btn-success" >
						Eliminar
					</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Cancelar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>