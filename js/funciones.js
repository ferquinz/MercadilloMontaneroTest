/**
 * @author Fernando Sanchiz
 */

$(document).ready(function() {
		
	$("#emailform").submit(function () {

		event.preventDefault();
	
		var $form = $(event.target),
		data = new FormData(),
		params   = $form.serializeArray();
	
		// ajax adding data to database
		$.ajax({
			url : "contacto/contactvalidate",
			type: "POST",
			data: data,
			dataType: 'json',
			async: false,
			processData: false,
			contentType: false,
			success: function(data)
			{
				//console.log("Datos:" + data);
				//if success close modal and reload ajax table
				$('#successMessage').show();
			},
			error: function (jqXHR, textStatus, errorThrown, data)
			{
				//console.log("Datos:" + data);
				$('#errorMessage').show();
			}
		});
	});

});

function filterProduct(value){
	$.ajax({
			url : "ajax_filter/" + value,
			type : "POST",
			//dataType : "JSON",
			success : function(data) {
				//if success reload ajax table
				$('#ListadoProductos').html(data);
				showAlert("Filtrado por: '" + value + "'", "warning");
			},
			error : function(jqXHR, textStatus, errorThrown) {
				showAlert("Error al filtrar: " + errorThrown, "danger");
			}
		});
}

$(document).on("click", "#remove", function () {
     var ProductId = $(this).data('id');
     $(".modal-body #productid").val(ProductId);
});

function deleteProduct(id) {
	// ajax delete data to database
	$.ajax({
		url : "ajax_delete/" + id,
		type : "POST",
		success : function(data) {
			//if success reload ajax table
			$('#deleteModal').modal('hide');
			$('input[name=filtro]').val('');
			$('#ListadoProductos').html(data);				
			showAlert("Producto eliminado", "success");
		},
		error : function(jqXHR, textStatus, errorThrown) {
			showAlert("Error al eliminar el producto: " + errorThrown, "danger");
		}
	});
}

function showAlert(message, type, closeDelay) {

	if ($("#alerts-container").length == 0) {
		// alerts-container does not exist, create it
		$("body").append($('<div id="alerts-container" style="position: fixed; width: 50%; right: 0%; top: 80%;">'));
	}

	// default to alert-info; other options include success, warning, danger
	type = type || "info";

	// create the alert div
	var alert = $('<div class="alert alert-' + type + ' fade in">').append($('<button type="button" class="close" data-dismiss="alert">').append("&times;")).append(message);

	// add the alert div to top of alerts-container, use append() to add to bottom
	$("#alerts-container").prepend(alert);

	// if closeDelay was passed - set a timeout to close the alert
	if (type == 'success' || type == 'warning')
		alert.fadeTo(5000, 500).slideUp(500, function() {
			alert.alert("close");
		});
}

function AbrirFicha(pagina, valor, visitas){
	
	$.ajax({
        url:'updatevisits',
        data:{id:valor,visitas:visitas},
        dataType:'json',
        success:function(data){
        }
  	});
	
	var url = pagina + "?Producto_id=" + valor;
    $.fancybox.open({
        type: 'iframe',
        href: url,
        scrolling: 'no',
        preload: true,
        padding: 0,
        maxWidth: 1170,
        maxHeight: 710,
        height: 710,
        width: 1170,
        fitToView: true,
        autoSize: false,
        closeClick: false,
        closeBtn: false,
        openEffect: 'none',
        closeEffect: 'none',
        afterShow: function(){
	   		/*this.height = $('.fancybox-iframe').contents().find('html').height();
	   		console.log("Altura = " + this.height);*/
	   		$("#cuadro_producto").css("height", (this.height - 40) + "px"); 
	  	},
	  	afterClose: function(){
	  		$.ajax({
	            type : "POST",
	            url : "ajax_get_data",
	            data : "productid=" + valor,//la última id
	            success : function(data) 
	            {
	            	var html = "";
	            	var json = JSON.parse(data);
	            	console.log(json);
	            	html += '<div class="thumbnail_ext" >';
					html += '	<div id="div_img_box_' + json.datos[0].id + '" >';
							var files = "";
							if(json.datos[0].files != null){
								files = json.datos[0].files.split(",");
							}
							var idimagen = 1;
							for(img in files)
               				{
               					if(idimagen == 1){
               						html += '<a id="img-' + json.datos[0].id + '-' + idimagen + '" class="img_box thumbnail" href="' + files[img] + '" data-lightbox="image-' + json.datos[0].id + '" data-title="' + json.datos[0].title + '" > ';
									html += '	<div class="hovereffect">';
									html += '		<img class="img-responsive first" alt="" src="' + files[img].replace("/basic/", "/thumb/") + '" ></img>';
									html += '		<div class="overlay">';
									html += '			<h2>Precio</h2>';
									html += '			<p>';
									html += '				' + json.datos[0].price + ' €';
									html += '			</p>';
									html += '		</div>';
									html += '	</div>	';
									html += '</a>               ';    						
               					}
               					else{
               						html += '<a id="img-' + json.datos[0].id + '-' + idimagen + '" class="img_box thumbnail" href="' + files[img] + '" data-lightbox="image-' + json.datos[0].id + '"'; 
									html += '	data-title="' + json.datos[0].title + '" style="display: none; width: 100%"> ';
									html += '	<img class="img-responsive" alt="" src="' + files[img].replace("/basic/", "/thumb/") + '" ></img>';
									html += '</a>    ';               						
               					}
               					idimagen += 1;	
               				}

						html += '</div>';
						html += '<div id="descripcion_box_' + json.datos[0].id + '" class="caption" alt="div_img_box" >';
						html += '	<h3 style="text-align: center;">' + json.datos[0].title + '</h3>';
	        			html += '	<p class="cortar" style="text-align: center;">';
	        			html += '		<label id="lblLugar">Lugar: </label>';
						html += '		<span for="Lugar">' + json.datos[0].place + '</span>';
						html += '	</p>';
						html += '	<p class="cortar" style="text-align: center;">';
	        			html += '		<label id="lblContacto">Contacto: </label>';
	        			if(json.datos[0].fbchecked == 0){
	        				html += '			<span for="Contacto">' + json.datos[0].contact + '</span>';
	        			}
	        			else{
	        				html += '			<span for="Contacto">' + json.datos[0].fbname + '</span>';
	        			}	
						html += '	</p>';
						html += '	<button id="remove" class="btn btn-danger icon-ok hidden-xs" data-id="' + json.datos[0].id + '" data-toggle="modal" data-target="#deleteModal" alt="button" data-toggle="tooltip" data-placement="bottom" title="Solo para propietarios">Vendido</button>';
						html += '	<span style="margin-left: 10%;" class="hidden-xs">';
						html += '		<i style="color: #5bc0de; background-color: white; padding-right: 5px " class="glyphicon btn-info glyphicon-eye-open "></i>';
						html += '		<b>' + json.datos[0].visitas + '</b>';
						html += '	</span> ';
						var url = "'" + window.location.origin + "/FichaProducto'";
						html += '	<button class="btn btn-warning" id="btnLeer" onclick="AbrirFicha(' + url + ', ' + json.datos[0].id + ', ' + json.datos[0].visitas + ')" style="float: right;" >Leer Mas<i class="icon-forward"></i></button>';
						html += '</div>';
						html += '</div>';
						
						var div = document.getElementById('product-' + valor);

						div.innerHTML = html;
	            }
         	});
	  	},
        helpers: {
            overlay: { 
            	closeClick: false,
            	locked: false 
        	} // prevents closing when clicking OUTSIDE fancybox
        }
    });
	
}


function loadMore()
	{
	    var id = $(".lastId").attr("id"), getLastId, html = "";
	    if (id != "" || id != "undefined") 
	    {
	        $.ajax({
	            type : "POST",
	            url : "loadMore",
	            data : "lastId=" + id,//la última id
	            beforeSend: function()
	            {
	                $(".before").show();
	            },
	            success : function(data) 
	            {
	                $(".before").hide();
	                var json = JSON.parse(data);
	                if(json.res === "success")
	                {                  
	                   for(datos in json.users)
	                   {
	                   		html += '<div id="product-' + json.users[datos].id + '" class="col-sm-6 col-md-4" >';
			    			html += '<div class="thumbnail_ext" >';
							html += '	<div id="div_img_box_' + json.users[datos].id + '" >';
									var files = "";
									if(json.users[datos].files != null){
										files = json.users[datos].files.split(",");
									}
									var idimagen = 1;
									for(img in files)
	                   				{
	                   					if(idimagen == 1){
	                   						html += '<a id="img-' + json.users[datos].id + '-' + idimagen + '" class="img_box thumbnail" href="' + files[img] + '" data-lightbox="image-' + json.users[datos].id + '" data-title="' + json.users[datos].title + '" > ';
											html += '	<div class="hovereffect">';
											html += '		<img class="img-responsive first" alt="" src="' + files[img].replace("/basic/", "/thumb/") + '" ></img>';
											html += '		<div class="overlay">';
											html += '			<h2>Precio</h2>';
											html += '			<p>';
											html += '				' + json.users[datos].price + ' €';
											html += '			</p>';
											html += '		</div>';
											html += '	</div>	';
											html += '</a>               ';    						
	                   					}
	                   					else{
	                   						html += '<a id="img-' + json.users[datos].id + '-' + idimagen + '" class="img_box thumbnail" href="' + files[img] + '" data-lightbox="image-' + json.users[datos].id + '"'; 
											html += '	data-title="' + json.users[datos].title + '" style="display: none; width: 100%"> ';
											html += '	<img class="img-responsive" alt="" src="' + files[img].replace("/basic/", "/thumb/") + '" ></img>';
											html += '</a>    ';               						
	                   					}
	                   					idimagen += 1;	
	                   				}
	
								html += '</div>';
								html += '<div id="descripcion_box_' + json.users[datos].id + '" class="caption" alt="div_img_box" >';
								html += '	<h3 style="text-align: center;">' + json.users[datos].title + '</h3>';
			        			html += '	<p class="cortar" style="text-align: center;">';
			        			html += '		<label id="lblLugar">Lugar: </label>';
								html += '		<span for="Lugar">' + json.users[datos].place + '</span>';
								html += '	</p>';
								html += '	<p class="cortar" style="text-align: center;">';
			        			html += '		<label id="lblContacto">Contacto: </label>';
			        			if(json.users[datos].fbchecked == 0){
			        				html += '			<span for="Contacto">' + json.users[datos].contact + '</span>';
			        			}
			        			else{
			        				html += '			<span for="Contacto">' + json.users[datos].fbname + '</span>';
			        			}	
								html += '	</p>';
								html += '	<button id="remove" class="btn btn-danger icon-ok hidden-xs" data-id="' + json.users[datos].id + '" data-toggle="modal" data-target="#deleteModal" alt="button" data-toggle="tooltip" data-placement="bottom" title="Solo para propietarios">Vendido</button>';
								html += '	<span style="margin-left: 10%;" class="hidden-xs">';
								html += '		<i style="color: #5bc0de; background-color: white; padding-right: 5px " class="glyphicon btn-info glyphicon-eye-open "></i>';
								html += '		<b>' + json.users[datos].visitas + '</b>';
								html += '	</span> ';
								var url = "'" + window.location.origin + "/FichaProducto'";
								html += '	<button class="btn btn-warning" id="btnLeer" onclick="AbrirFicha(' + url + ', ' + json.users[datos].id + ', ' + json.users[datos].visitas + ')" style="float: right;" >Leer Mas<i class="icon-forward"></i></button>';
								html += '</div>';
							html += '</div>';
						html += '</div>';
	                        getLastId = json.users[datos].id;
	                   }
	
	                   $("#ListadoProductos").append(html);
	                   scrollLoad = true;
	               }
	               else
	               {
	                    moreusers = false;
	                    //$("#ListadoProductos").append("<div class='alert alert-danger text-center'>Ya no hay más productos</div>");
	                    showAlert("Ya no hay más productos", "warning");    
	               }
	                 $(".lastId").attr("id",getLastId);
	            },
	            error: function()
	            {
	                showAlert("Error al cargar los productos", "danger");
	            }
	        });
	    }
	}
	