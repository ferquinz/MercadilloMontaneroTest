	
<script>

$(document).ready(function() {
	$('.combobox').combobox();
});

$(document).ready(function() {
	
    $('#txtcontacto').on('change',function(){ // # is id based selector
       document.getElementById("facebook").checked = false;
    });


	$("#productform").submit(function () {
	
		event.preventDefault();
		
		var $form = $(event.target),
		data = new FormData(),
		params   = $form.serializeArray(),
		files    = $form.find('[name="imagenes"]')[0].files;
	
		data.append("ciudad", addCity != "undefined"? addCity : "");
		data.append("provincia", addProvince != "undefined"? addProvince : "");
		data.append("pais", addCountry != "undefined"? addCountry : "");
				
		$.each(files, function (key, file){
			console.log("imagenes-" + key);
			data.append("imagenes-" + key, file);
		});
		
		$.each(params, function(i, val) {
			data.append(val.name, val.value);
		});
		
		// ajax adding data to database
		$.ajax({
			url : "<?php echo site_url('listado/ajax_add')?>",
			type: "POST",
			data: data,
			dataType: 'json',
			async: false,
			processData: false,
			contentType: false,
			success: function(data)
			{
				//if success close modal and reload ajax table
				$('#myModalForm').modal('hide');
				//$('#ListadoProductos').html(data);
				showAlert("Producto agregado", "success");
				window.location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				$('#myModalForm').modal('hide');
				showAlert("Error al añadir el producto: " + errorThrown, "danger");
			}
		});
	});
});

</script>
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId : '1733478033551312',
			xfbml : true,
			version : 'v2.5'
		});
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				// the user is logged in and has authenticated your
				// app, and response.authResponse supplies
				// the user's ID, a valid access token, a signed
				// request, and the time the access token
				// and signed request each expire
				var uid = response.authResponse.userID;
				$("#txtcontacto").val(uid);
				document.getElementById("facebook").checked = true;
				var accessToken = response.authResponse.accessToken;
				FB.api('/me', function(response) {
		  			console.log('Your name is ' + response.name);
		  			console.log("Link: " + response.link);
		  			$("#txtfbname").val(response.name);
				});
			} else if (response.status === 'not_authorized') {
				// the user is logged in to Facebook,
				// but has not authenticated your app
			} else {
				// the user isn't logged in to Facebook.
			}
		});
		
	};
	( function(d, s, id) {
			var js,
			    fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk')); 
</script>

<!--
MODAL PARA FORMULARIO
-->
<div class="modal fade" id="myModalForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<a class="cierreCuadroRegistro" id="cierremyModal" aria-hidden="true"></a>
				<h4 id="myModalLabel">Nuevo artículo
				<button type="button" class="close" aria-label="Close" style="float: right; color: white;" data-dismiss="modal" >
					<span aria-hidden="true">&times;</span>
				</button></h4>
			</div>
			<form action="#" id="productform" name="productform" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="modal-body">
					<div class="form-group" >
						<!--<label for="recipient-files" class="control-label">Imagenes:</label>
						<input type="file" class="form-control" id="txtfile" required class="ng-pristine ng-invalid" multiple accept="image/*">-->
						<label for="recipient-files" class="control-label">Imagenes:</label>
						<input id="input-23" name="imagenes" type="file" multiple class="file-loading form-control" required>
						<script>
							$(document).on('ready', function() {
								$("#input-23").fileinput({
									showUpload : false,
									allowedFileExtensions : ["jpeg", "jpg", "png", "gif"],
									maxFileCount : 5,
									showRemove : true,
									maxFileSize : 1500,
									layoutTemplates : {
										main1 : "{preview}\n" + "<div class=\'input-group {class}\'>\n" + "   <div class=\'input-group-btn\'>\n" + "       {browse}\n" + "       {upload}\n" + "       {remove}\n" + "   </div>\n" + "   {caption}\n" + "</div>"
									}
								});
							});
						</script>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" >
								<label for="recipient-title" class="control-label">Titulo:</label>
								<input type="text" class="form-control" id="txttitle" name="title" placeholder="Titulo" required size="50" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" >
								<label for="recipient-place" class="control-label">Lugar:</label>
								<input type="text" class="form-control controls" id="txtplace" placeholder="lugar" name="place" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-place" class="control-label">Categoria:</label>
								<select class="combobox form-control" placeholder="categoria" name="category" required>
									<option></option>
									<option value="1">Ropa</option>
									<option value="2">Calzado</option>
									<option value="3">Material</option>
									<option value="4">Accesorios</option>
									<option value="5">Camping</option>
									<option value="6">Otros</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-place" class="control-label">Precio:</label>
								<input type="number" class="form-control" id="txtprecio" placeholder="precio €" name="price" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-place" class="control-label"> <a data-toggle="tooltip" class="tooltipLink" data-placement="right" data-original-title="<p>Información personal para contactar con el vendedor, por ejemplo: </p><ul><li>Telefono</li><li>Email</li></ul>"> <span class="glyphicon glyphicon-info-sign "></span> </a> Contacto: </label>
								<div class="input-group">
									<input type="text" class="form-control" id="txtcontacto" placeholder="contacto" name="contact" required />
									<span class="input-group-addon" > <div class="fb-login-button" data-max-rows="1" data-size="icon" data-show-faces="false" data-auto-logout-link="false"></div> </span>
								</div>

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-place" class="control-label">Contraseña:</label>
								<input type="password" class="form-control" id="txtContraseña" placeholder="contraseña" name="pass" required />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="recipient-place" class="control-label">Descripción:</label>
						<textarea type="text" class="form-control" id="txtdescripcion" placeholder="descripción" name="description" ></textarea>
					</div>
					<input type="checkbox" name="facebook" id="facebook" class="hidden">
					<input type="text" id="txtfbname" name="txtfbname" class="hidden" />
				</div>
				<div class="modal-footer">
					<button class="btn btn-success" type="submit" >
						Vender
					</button>
					<button class="btn btn-primary" aria-hidden="true" data-dismiss="modal" >
						Cancelar
					</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	var addCity, addProvince, addCountry;
	
	function initAutocomplete() {
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('txtplace'));
		autocomplete.addListener('place_changed', function() {
		    var place = autocomplete.getPlace();
		    console.log(place);
		    if (!place.geometry) {
		      window.alert("Autocomplete's returned place contains no geometry");
		      return;
		    }

			var componentForm = {
			  street_number: 'short_name',
			  route: 'long_name',
			  locality: 'long_name',
			  administrative_area_level_1: 'long_name',
			  country: 'long_name',
			  postal_code: 'short_name'
			};
			
			for (var i = 0; i < place.address_components.length; i++) {

			    var addressType = place.address_components[i].types[0];
				//console.log(addressType);
			    if (componentForm[addressType]) {
			
			        var val = place.address_components[i][componentForm[addressType]];
			
			        if(addressType == 'locality')                    addCity = val;
			        if(addressType == 'administrative_area_level_1') addProvince = val;
			        if(addressType == 'country')                     addCountry = val;
			    }
			
			}
			
			console.log("Ciudad: " + addCity);
			console.log("Provincia: " + addProvince);
			console.log("Pais: " + addCountry);
				     
    	});
	}
	
</script>
 	
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete" async defer></script>